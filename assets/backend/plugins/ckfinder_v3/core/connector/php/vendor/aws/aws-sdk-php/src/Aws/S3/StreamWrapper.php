<?php
/**
 * Copyright 2010-2013 Amazon.com, Inc. or its affiliates. All Rights Reserved.
 *
 * Licensed under the Apache License, Version 2.0 (the "License").
 * You may not use this file except in compliance with the License.
 * A copy of the License is located at
 *
 * http://aws.amazon.com/apache2.0
 *
 * or in the "license" file accompanying this file. This file is distributed
 * on an "AS IS" BASIS, WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either
 * express or implied. See the License for the specific language governing
 * permissions and limitations under the License.
 */

namespace Aws\S3;

use Aws\Common\Exception\RuntimeException;
use Aws\S3\Exception\S3Exception;
use Aws\S3\Exception\NoSuchKeyException;
use Aws\S3\Iterator\ListObjectsIterator;
use Guzzle\Http\EntityBody;
use Guzzle\Http\CachingEntityBody;
use Guzzle\Http\Mimetypes;
use Guzzle\Iterator\FilterIterator;
use Guzzle\Stream\PhpStreamRequestFactory;
use Guzzle\Service\Command\CommandInterface;

/**
 * Amazon S3 stream wrapper to use "s3://<bucket>/<key>" files with PHP streams, supporting "r", "w", "a", "x".
 *
 * # Supported stream related PHP functions:
 * - fopen, fclose, fread, fwrite, fseek, ftell, feof, fflush
 * - opendir, closedir, readdir, rewinddir
 * - copy, rename, unlink
 * - mkdir, rmdir, rmdir (recursive)
 * - file_get_contents, file_put_contents
 * - file_exists, filesize, is_file, is_dir
 *
 * # Opening "r" (read only) streams:
 *
 * Read only streams are truly streaming by default and will not allow you to seek. This is because data
 * read from the stream is not kept in memory or on the local filesystem. You can force a "r" stream to be seekable
 * by setting the "seekable" stream context option true. This will allow true streaming of data from Amazon S3, but
 * will maintain a buffer of previously read bytes in a 'php://temp' stream to allow seeking to previously read bytes
 * from the stream.
 *
 * You may pass any GetObject parameters as 's3' stream context options. These options will affect how the data is
 * downloaded from Amazon S3.
 *
 * # Opening "w" and "x" (write only) streams:
 *
 * Because Amazon S3 requires a Content-Length header, write only streams will maintain a 'php://temp' stream to buffer
 * data written to the stream until the stream is flushed (usually by closing the stream with fclose).
 *
 * You may pass any PutObject parameters as 's3' stream context options. These options will affect how the data is
 * uploaded to Amazon S3.
 *
 * When opening an "x" stream, the file must exist on Amazon S3 for the stream to open successfully.
 *
 * # Opening "a" (write only append) streams:
 *
 * Similar to "w" streams, opening append streams requires that the data be buffered in a "php://temp" stream. Append
 * streams will attempt to download the contents of an object in Amazon S3, seek to the end of the object, then allow
 * you to append to the contents of the object. The data will then be uploaded using a PutObject operation when the
 * stream is flushed (usually with fclose).
 *
 * You may pass any GetObject and/or PutObject parameters as 's3' stream context options. These options will affect how
 * the data is downloaded and uploaded from Amazon S3.
 *
 * Stream context options:
 *
 * - "seekable": Set to true to create a seekable "r" (read only) stream by using a php://temp stream buffer
 * - For "unlink" only: Any option that can be passed to the DeleteObject operation
 */
class StreamWrapper
{
    /**
     * @var resource|null Stream context (this is set by PHP when a context is used)
     */
    public $context;

    /**
     * @var S3Client Client used to send requests
     */
    protected static $client;

    /**
     * @var string Mode the stream was opened with
     */
    protected $mode;

    /**
     * @var EntityBody Underlying stream resource
     */
    protected $body;

    /**
     * @var array Current parameters to use with the flush operation
     */
    protected $params;

    /**
     * @var ListObjectsIterator Iterator used with opendir() and subsequent readdir() calls
     */
    protected $objectIterator;

    /**
     * @var string The bucket that was opened when opendir() was called
     */
    protected $openedBucket;

    /**
     * @var string The prefix of the bucket that was opened with opendir()
     */
    protected $openedBucketPrefix;

    /**
     * @var array The next key to retrieve when using a directory iterator. Helps for fast directory traversal.
     */
    protected static $nextStat = array();

    /**
     * Register the 's3://' stream wrapper
     *
     * @param S3Client $client Client to use with the stream wrapper
     */
    public static function register(S3Client $client)
    {
        if (in_array('s3', stream_get_wrappers())) {
            stream_wrapper_unregister('s3');
        }

        stream_wrapper_register('s3', get_called_class(), STREAM_IS_URL);
        static::$client = $client;
    }

    /**
     * Close the stream
     */
    public function stream_close()
    {
        $this->body = null;
    }

    /**
     * @param string $path
     * @param string $mode
     * @param int    $options
     * @param string $opened_path
     *
     * @return bool
     */
    public function stream_open($path, $mode, $options, &$opened_path)
    {
        // We don't care about the binary flag
        $this->mode = $mode = rtrim($mode, 'bt');
        $this->params = $params = $this->getParams($path);
        $errors = array();

        if (!$params['Key']) {
            $errors[] = 'Cannot open a bucket. You must specify a path in the form of s3://bucket/key';
        }

        if (strpos($mode, '+')) {
            $errors[] = 'The Amazon S3 stream wrapper does not allow simultaneous reading and writing.';
        }

        if (!in_array($mode, array('r', 'w', 'a', 'x'))) {
            $errors[] = "Mode not supported: {$mode}. Use one 'r', 'w', 'a', or 'x'.";
        }

        // When using mode "x" validate if the file exists before attempting to read
        if ($mode == 'x' && static::$client->doesObjectExist($params['Bucket'], $params['Key'], $this->getOptions())) {
            $errors[] = "{$path} already exists on Amazon S3";
        }

        if (!$errors) {
            if ($mode == 'r') {
                $this->openReadStream($params, $errors);
            } elseif ($mode == 'a') {
                $this->openAppendStream($params, $errors);
            } else {
                $this->openWriteStream($params, $errors);
            }
        }

        return $errors ? $this->triggerError($errors) : true;
    }

    /**
     * @return bool
     */
    public function stream_eof()
    {
        return $this->body->feof();
    }

    /**
     * @return bool
     */
    public function stream_flush()
    {
        if ($this->mode == 'r') {
            return false;
        }

        $this->body->rewind();
        $params = $this->params;
        $params['Body'] = $this->body;

        // Attempt to guess the ContentType of the upload based on the
        // file extension of the key
        if (!isset($params['ContentType']) &&
            ($type = Mimetypes::getInstance()->fromFilename($params['Key']))
        ) {
            $params['ContentType'] = $type;
        }

        try {
            static::$client->putObject($params);
            return true;
        } catch (\Exception $e) {
            return $this->triggerError($e->getMessage());
        }
    }

    /**
     * Read data from the underlying stream
     *
     * @param int $count Amount of bytes to read
     *
     * @return string
     */
    public function stream_read($count)
    {
        return $this->body->read($count);
    }

    /**
     * Seek to a specific byte in the stream
     *
     * @param int $offset Seek offset
     * @param int $whence Whence (SEEK_SET, SEEK_CUR, SEEK_END)
     *
     * @return bool
     */
    public function stream_seek($offset, $whence = SEEK_SET)
    {
        return $this->body->seek($offset, $whence);
    }

    /**
     * Get the current position of the stream
     *
     * @return int Returns the current position in the stream
     */
    public function stream_tell()
    {
        return $this->body->ftell();
    }

    /**
     * Write data the to the stream
     *
     * @param string $data
     *
     * @return int Returns the number of bytes written to the stream
     */
    public function stream_write($data)
    {
        return $this->body->write($data);
    }

    /**
     * Delete a specific object
     *
     * @param string $path
     * @return bool
     */
    public function unlink($path)
    {
        try {
            $this->clearStatInfo($path);
            static::$client->deleteObject($this->getParams($path));
            return true;
        } catch (\Exception $e) {
            return $this->triggerError($e->getMessage());
        }
    }

    /**
     * @return array
     */
    public function stream_stat()
    {
        $stat = fstat($this->body->getStream());
        // Add the size of the underlying stream if it is known
        if ($this->mode == 'r' && $this->body->getSize()) {
            $stat[7] = $stat['size'] = $this->body->getSize();
        }

        return $stat;
    }

    /**
     * Provides information for is_dir, is_file, filesize, etc. Works on buckets, keys, and prefixes
     *
     * @param string $path
     * @param int    $flags
     *
     * @return array Returns an array of stat data
     * @link http://www.php.net/manual/en/streamwrapper.url-stat.php
     */
    public function url_stat($path, $flags)
    {
        // Check if this path is in the url_stat cache
        if (isset(static::$nextStat[$path])) {
            return static::$nextStat[$path];
        }

        $parts = $this->getParams($path);

        if (!$parts['Key']) {
            // Stat "directories": buckets, or "s3://"
            if (!$parts['Bucket'] || static::$client->doesBucketExist($parts['Bucket'])) {
                return $this->formatUrlStat($path);
            } else {
                return $this->triggerError("File or directory not found: {$path}", $flags);
            }
        }

        try {
            try {
                $result = static::$client->headObject($parts)->toArray();
                if (substr($parts['Key'], -1, 1) == '/' && $result['ContentLength'] == 0) {
                    // Return as if it is a bucket to account for console bucket objects (e.g., zero-byte object "foo/")
                    return $this->formatUrlStat($path);
                } else {
                    // Attempt to stat and cache regular object
                    return $this->formatUrlStat($result);
                }
            } catch (NoSuchKeyException $e) {
                // Maybe this isn't an actual key, but a prefix. Do a prefix listing of objects to determine.
                $result = static::$client->listObjects(array(
                    'Bucket'  => $parts['Bucket'],
                    'Prefix'  => rtrim($parts['Key'], '/') . '/',
                    'MaxKeys' => 1
                ));
                if (!$result['Contents'] && !$result['CommonPrefixes']) {
                    return $this->triggerError("File or directory not found: {$path}", $flags);
                }
                // This is a directory prefix
                return $this->formatUrlStat($path);
            }
        } catch (\Exception $e) {
            return $this->triggerError($e->getMessage(), $flags);
        }
    }

    /**
     * Support for mkdir().
     *
     * @param string $path    Directory which should be created.
     * @param int    $mode    Permissions. 700-range permissions map to ACL_PUBLIC. 600-range permissions map to
     *                        ACL_AUTH_READ. All other permissions map to ACL_PRIVATE. Expects octal form.
     * @param int    $options A bitwise mask of values, such as STREAM_MKDIR_RECURSIVE.
     *
     * @return bool
     * @link http://www.php.net/manual/en/streamwrapper.mkdir.php
     */
    public function mkdir($path, $mode, $options)
    {
        $params = $this->getParams($path);
        if (!$params['Bucket']) {
            return false;
        }

        if (!isset($params['ACL'])) {
            $params['ACL'] = $this->determineAcl($mode);
        }

        return !isset($params['Key']) || $params['Key'] === '/'
            ? $this->createBucket($path, $params)
            : $this->createPseudoDirectory($path, $params);
    }

    /**
     * Remove a bucket from Amazon S3
     *
     * @param string $path the directory path
     * @param int    $options A bitwise mask of values
     *
     * @return bool true if directory was successfully removed
     * @link http://www.php.net/manual/en/streamwrapper.rmdir.php
     */
    public function rmdir($path, $options)
    {
        $params = $this->getParams($path);
        if (!$params['Bucket']) {
            return $this->triggerError('You cannot delete s3://. Please specify a bucket.');
        }

        try {

            if (!$params['Key']) {
                static::$client->deleteBucket(array('Bucket' => $params['Bucket']));
                $this->clearStatInfo($path);
                return true;
            }

            // Use a key that adds a trailing slash if needed.
            $prefix = rtrim($params['Key'], '/') . '/';

            $result = static::$client->listObjects(array(
                'Bucket'  => $params['Bucket'],
                'Prefix'  => $prefix,
                'MaxKeys' => 1
            ));

            // Check if the bucket contains keys other than the placeholder
            if ($result['Contents']) {
                foreach ($result['Contents'] as $key) {
                    if ($key['Key'] == $prefix) {
                        continue;
                    }
                    return $this->triggerError('Psuedo folder is not empty');
                }
                return $this->unlink(rtrim($path, '/') . '/');
            }

            return $result['CommonPrefixes']
                ? $this->triggerError('Pseudo folder contains nested folders')
                : true;

        } catch (\Exception $e) {
            return $this->triggerError($e->getMessage());
        }
    }

    /**
     * Support for opendir().
     *
     * The opendir() method of the Amazon S3 stream wrapper supports a stream
     * context option of "listFilter". listFilter must be a callable that
     * accepts an associative array of object data and returns true if the
     * object should be yielded when iterating the keys in a bucket.
     *
     * @param string $path    The path to the directory (e.g. "s3://dir[</prefix>]")
     * @param string $options Whether or not to enforce safe_mode (0x04). Unused.
     *
     * @return bool true on success
     * @see http://www.php.net/manual/en/function.opendir.php
     */
    public function dir_opendir($path, $options)
    {
        // Reset the cache
        $this->clearStatInfo();
        $params = $this->getParams($path);
        $delimiter = $this->getOption('delimiter');
        $filterFn = $this->getOption('listFilter');

        if ($delimiter === null) {
            $delimiter = '/';
        }

        if ($params['Key']) {
            $params['Key'] = rtrim($params['Key'], $delimiter) . $delimiter;
        }

        $this->openedBucket = $params['Bucket'];
        $this->openedBucketPrefix = $params['Key'];
        $operationParams = array('Bucket' => $params['Bucket'], 'Prefix' => $params['Key']);

        if ($delimiter) {
            $operationParams['Delimiter'] = $delimiter;
        }

        $objectIterator = static::$client->getIterator('ListObjects', $operationParams, array(
            'return_prefixes' => true,
            'sort_results'    => true
        ));

        // Filter our "/" keys added by the console as directories, and ensure
        // that if a filter function is provided that it passes the filter.
        $this->objectIterator = new FilterIterator(
            $objectIterator,
            function ($key) use ($filterFn) {
                // Each yielded results can contain a "Key" or "Prefix"
                return (!$filterFn || call_user_func($filterFn, $key)) &&
                    (!isset($key['Key']) || substr($key['Key'], -1, 1) !== '/');
            }
        );

        $this->objectItevator->next();

`  $    betUrn tbue;
    }

    /**
     *`Blose tËe dir%b|ory lirtong haNd|es
    $*
    $. @return bool ¥rue on(3uccessX$    */
 $  publhc function dir_closedir()
    ;
0       $this-6gbjectIdeRator"Ω oull;ä
        zeturn true;
(0  }

    /**
     * This methmd is callud in response to rewin‰`ir()
     *
     * @ret}rn boolakn trug on su‚cÂss
  $ (,/
  † ublic fnction dir_rewiÓtdir()
"   {
†       $vhis->clearStatInfo();
2 `     $this->obÍectIterator->ze7ind();
*      " return tzue;
0$  }

    /**
 "$  * T`is method is called in response to readdir()
   $ *
     ™ @return strin' Shoul‰ “eturn a string cÂpresenting tle next filename,"op falce0if there is no next fYÏe.
     

     ™ @link†hutp://www.php..et/manual/en/fenotion.r%addir.yhp
     ™/
    public function ‰kr_reaedÈr()
 "  {
        // Skip empt1 besulp keys
   $†   ig ®)$this->objec4Hterator->ˆalid(/) {
           return fadse;
 %      

        $current = $thic->objeatIterator->curreop();
   †    if*(isset(,gurre.t['Prefi|'])) {
` †    `( † // Include "`ivector)es". Be sure to strip a Ùrailing "/"
 †" !       // on pzmfixe≥.
     "``    $pbefix = rprim($current['Prefix'^, '/');
`!         $result = suÚ_replace(&this->openedBucketPrefi¯, '',`prefix!;
    (       $Îey = "q1/{$this->open%dBucket}/{$prefix|";
   ∞        $stat 5 ,this/>normatUrlStat($pzefix);
†      "~†else ˚
      !     // Remove the prefiz from the result to eyulete other
    !†      o/†stream wrappers.
    "       $result = Str_r%pdace($vhks->openedBucketXrefix '', $current['Key']);
 `          $key#=("s3:/.s4this->opmnedBugkut}/{ gq‚rent['Key']}";
     8      $stat = $this->formatUrlS6at($current);
 ( $    }
        /' Cachu the o‚lect dati for qukcÎ url^stat loNkuxs useE with
        // PecursivdDirectoryIterator.
 †      staÙic::&nÂytStat 9 array9$+ey = $stat);
        $this->ob*ectItebator-?next();

(       return $resul4;
"   }
    /**
     * Ca¸led mn response to ren`me() to®zenam} !`file oz direCtkry. C5rrently mnly suports renaming odjects.
$    *
 `@  * @pazam striog $paTh_from the path‡tÔ the gmme to rename
     * @taram string $pat8_to   ThÂ new pauË to uhe file
     *
     * @reVurn bOol true if filedwew successfull renamut
     8 @link http://wwwéphp.ne4-manual/%f/function.rename.php
!(   */
 $  pubdic functiÓf rename®$path_f0om, $path_to)
    {
  a     $tqrtsFrom - $thÈs-~getPar`ms($path_fromk;
      ` part{Tn = $thiq=>getPa2Òms($ath_to);
 $    $ $This-:glearStatInfo($tith_frgÌ);
        $thas-6clearStatInfo($path_to);

  $"    if (!partsFrom['KUq'] ||  p`rtsTo[gKey']) {            reUurn $thiq->triwgmrError('The Amazon Ss stream wrapper Ônly suppoÚts clpying objects'):
      h u

        try {
        !   // Copy t*e _bject aÓd all/w overriding ddf!qlt par`oeters iÁ desirE`, but by defaqmT copy letadaT`J            sˆ!tyc::$#leent->coryObje#T)$this->getOptiol3() + !rsay(
                'Bucket' ?> $par4sTm['BucjeT'],
$  †     d      'Key' => $partsToK'Key'],
      $        `'CopySour#e' =: '/' . dpqrtsFrom['Buckev'] . '/' . ra7urlencoe5($partsfrom['Kdi#]),
 0              MetadataDirectivE' => 'GOPY'
  `       (¢	);
         0$0// DeletÂ the original Ôbject
         0  static::$clÈ'nt->deledeObjes‰(array(
$      (        'Buccet' => $partsFroM['Buckgt'],
                'Kei%$   => ,xartsFrom['Key'Y
            ) +`$this->getOptanns())+
     "  } catch!(\Excestion $e)0{
     $      rmturn $tjas->triggerErrkr($e->g%tNessage)+);
        }

!     $0return true;
    }

  ! -.*
  00 * Cast the stÚeam to peturn tËÂ underlying filu resource
     *J     * @paraÌ ift $cas4_as STREM_CAWU_FOR_SELDT or STREAM_CASV_AS_[REAM
     *
    0* @retuRO resource
     */
    public function†stream^cast($cast_as)
  † {
  `0"   redurn $thiq->body).gmtStr%am();
    ˝

    /®*
   00* Get the strea= cont%xı optiofs!avaim)ble to the cusrgÓt strEam
     *
    `*0@retu∞n†array
     */
$   protected funkTion g%VOptions*)
    {
        $contEht = $thes->contuxt ?: s4rgam_cntext_gÂt_defau$t");
        $oqÙions = 3tream_cojtext_Áet_optikns($coJtext);
 $      sgpurn is3Et($options['Ò3/]) ? $options['s3'] :`asray();
`   }
    /*.+ 0   *0Fet a spec©fic stream co.tÂxt option
   $ *
   & * @param string $name Jam% of the`option to retradve
  10 *
     * @ret}rn mixg|null
     */
  `"protect!d funcÙyon getOption(§j·me)
  ¢ {
        $oqdiOns = $this->getOptionc(!;

 0 0    r%tırn issed($optmons[$name]) ? $op0ions[$name] : n/ll;
`  $}

   %/**
     * Get†phe buc+ut and kdY fro, the passdd path (e.g. s3;//bucket/key)
     *
     * @p)ram stzinG $pa|j`Path pasred t the stzeam wrar er
     *
     * @retun0array0Xa{h of 'Bucketß, 'Key' ·nd cusTom parems
   ( */
   "prktected funct…on getPyvams($peth)
   `{
!    †` ,parts†<0explodE('/',`substr($path, 5). 2);

        ,tarams = $this->g%tOptions();
  `     unset($pavams['seekable']);

     b  retuÚn array(
            'Bucket' =>`$parts[p],
           7Omy'   0º> isset(dpartq€p]) ? $parts[1] :null*        )0+ $pariiÛ;
    }
    **
     ® SeriiliZe and sign a command. returnmno!a reque˜t object
     (
    †( @param commandIjterfaca"$comman$ Command to sionJ   0d*
     * Areturn*RequestInterfa#m
     */
    rRotectel(functi_n"getSisnedRequest($comland)
    {ä    "   $req5esT = $cogmand->prepare(+;   0`   $requ%st->diÛp·tch('beuuest6before_s%nd', ar2ay('requ!st' =: $request));

   !    return $ruÒuest;
 †  }

   ‡/**
     * Init)clize th% strtam wrapper for ! read ol,y°stream
     *
     *`@param awz·y $p`ri}s Opera4ion pErameters
     * param array $errors Anx encoentered errors t+ append Ùo
     *
     . @return bool
   !0*/
    0rotected function opEnReadStrea}(arra9 $paraosl array &$erroÚq)
    {
      ! / CreAte the cnmmand a~d serialqze the request
      ! $requÂwt = $t(as->getSigNedResuest(static::$cLIent->ge4Comman`('GetObje„t',  pIbams)(;
       ('/ Creava a str‰am that uses tha"EntitiBody object
  `°Å   $fastory ="$this->'etOptiol('streamOfactory#( ?: new PhpStreamReques4∆actory();
   ! (  $this->bodx 5"$factmr{->fromR!quest($requesu, array(*, arra9('streamblass' =º 'Guzjla\Htt0‹Entity@dy'));

†(    0 // Wrap txe bodX in a aaching entIty bmdy if sumking is†qnlowed$     0 if ($thisΩ>getKption('qeekable')) {
          " %this-<jody = new CachingEntityBoly($tHis->body);        }

        rgtırn true;
    |
    /**     : Ynitialize the stream wrapper fÔrba wrÈte onl9 ”tream     *
     * @PaRam array $par`ms Operation pazameters
     * @param arrQy $errors Any e.countere‰ errors to ax`end to0    *
 `   * @return bonlJ     */*    pro4ected function openWritEStreamjarray $rirams, array &$arrors-
    { !      $Ùhis->body = new"EntitqBody(fopen('php:/temp'"'r+'))9    }

    /**
  !  * InitialixÂ04he s|Ream wrapper for an app%nd$stream
     "
     * @param array $p!rams Operation pazameters
     * @xaram array $Ârrors Any encounÙmbed ervoss to append to
     *
(†   * @Úeturn bokl
     ¢/
    protecued!functkon opeÓ@ppendStream(arr!y $params, arraY &$errors)
    {
@       try {
0           // Ge‡ the ‚dy of t`e(object      "     $t(is->body = stauic::$clment->getO` ect($xaRams)->get('Body');
  (         $this/>Body->≤eek(0, SEEI_END)9      ` ˝ catc( (S3ExcFption $e) {
  $ !!      // The /Bject does not eyast, so wse a simple write stz!am
           †`this->/penWriueStream($params, $errors)3
        }

        retuRn trvu;
    }
    /**
     * trigge˜ Ône or iope errors
     (
     * @param suringlarray $errÔrs Errkrs to 4rigger
     * @param mixed    †   $flags †If set to STREAM_URL_QT¡T_QUIT, the~`lo erro2 r exceq`ion occurs
  $&*
     * @retırn bool P%turnS fqlse
     * @tJsows RuotimeE8ception if throWOevrors is true
     */
    proteCted function trkggerEbror($errorz, $flaes = nu,l)
    ™       !if ($Êlags & CtREAM_TRLSTATﬂUKET) {
        `// Thhs is triggered0with th)ngÛ likg"file_e|isps()

 $`       hf ($Êl`gs & STREAM_URL_”TAT_LI^K) {
           // T(iq is trhggered for things like is_link(-
     †  0   retırn $this->formavUrlStat(nalse);
         }
          return false;
 "      }	
 `     0// This 	s triggmred when doing things like lst`t*) orstqt()
        trigger_mr2or(imp|ote("\n"$ (arrAy)($errors), E_UR«R_WARNING);

 0      re‘urn filse;
    }

   0/**
   ` ™ Pretarg a url_stat rusult aÚr!y
   0 *
    "* @param string|aqray $result Data to addä     *
     * @return arbay Rdterns thE modifie``url_Stat resuÌt
     */
    prntected$Êunction formaturlStat($result = null)    {
 $      st`tic $stetTemplatg = aray(
           `0  => 0,0 'dev†    => 0,            90 => 0,! 'ino'     => 0,
@      "    2  Ω> 0, †'mode' `  => 0,
            3  =æ p,  'lÏhNk'   => 0,
    p    ∞  4  => 0,  'uidß     =~(0,
           `5$ => 0,  'gid'0    => 0å
    $†     04  => -1,†%rdev'    => -1,
     †      7  => 0,  'Ûize'  ( => 0,
!           8  => 0,  'atime' $ => 0,
  (       † 9  =æ 0,  'm‘ime'   6"0,
 (p0        10 => 0,  'ctimÂ'   => t,
    ,       11$=> -1, 'blksize' => -±-     (,     =r => -1,('flockr7 0=> -1,
        );

 (      $stat = $statTempl`te;
  `     $typa = gevtype($rfsult);

       †//†Deterline wh·t type gf ‰ata …s being"ceched
 !      hf *$type&}= 'NULL% || $type == 'string') {
   0  $     '/ DirektOry wiTh(2777 accEss - sed "man 2 stat".
       0    $stat['moda7] = $s|@t[2] = (0407579
        } enreif ($type == ß#rray' && )sset($rEsult['LastModigÈed'])™ {
            // List_bjects or Headobject rusult
   `        $rtat['mpime'] = $stat[9] = $stat€'ctime'] = $stat[10] = strtotime($restdt['LastModifiee']);
   "        $stat[ßsize'] Ω $stat[7] = (iswgt($resvlT['ContentLengthg]) ? $result[&COntentLength'O!z $resy|t'Size');
  (         /ø Regular filu wkth 077 acceqs†- see "man 2 s|at".
 $ (!      $$stat['oode'] = $stat[2] = 010077;
        }

        return $Stat;
†!  }

 ! `'**
 `   * Clear the next sta| rdsult`ÊrOm the cache
0    *
   ! * @param stryng $path 	f a pAth0is specific, c,earstatcache() wkll be called
 $   */
  ( protdcDed funcTion cleirStatInfo($pAtË = nuln)
    {
        static::$nextStat = arRa}*);
        if ($path	 {
    "(      glmarstatcaghe(tÚue, $path);
        }
    y

    //*
   d h Crekdes a bucket for uhe giVen para-eÙars.
 † " *
 (   * @param string $patx!  Stream"wrapper0path
!    * ‡param apray  $parcms A reÛult of CtreamWrcpper::ggtParams()
    0+
     * @return bool$returns tree on success!ob falsd on failWrÂ
     
'
    private fUnctioÓ create¬ucket(path, asra# $papam{)
   !{
    " 0!if ({tuic::$client-.doesBuc+etExist($irams[ßBucket'])) {
            return $this->tÚiggerError("Directory aÏready exists: {$Path}");
        }

 " `    try {
            ktatic::dc,ient->createBucket($qar·ms);
 `†     	°  $thhs->clear”uqtInfo($xath);
 $       †  reuurn trua;
        } catch(8\Exception $Â) ˚
            return %this->trÈcgerError($e->gedMessage());
        }
 0  }

    /**
     * Creates a pseudo-folder by`c2eating an emÒty "/" suffixed$iey
   $ *
     * @param wtring §path  !Stbeam wrapper path
     * @param`array" $`arams A result of StreimWrappar::getParams()
     *
     * @reTurn bogl     #/
    ppivate funstion(createPweudoDirectnry($path, arra9 $para}sÈ
    ˘*1    ê †// Ensure the path en,s jn "/" and the!body ks empty.
®       dparams{'ey'] =0rtrim(†rarams['Key'], 7/') & '-';
        $par`ms['Body'] Ω('';

   (    // Fail if this pweudo di2ectory kmy alreaÂy exists
        )f (stctic::$client->doeqObjectExist($params[Jucket'Y,†%paramsK/Key']) {
  "  ∞      rdturn $this->TviwgerErrob("DiresLory aLready eXists: {$path}")+J        }

        tr9 {
   $ $      static:8$blient9.putObjeCt($params);
    †       <this->„learStatI.fo($p!th);
        ! "return true;
        | catch (Exceptinn $e) {*            return $thÈs->tridgerError($e->getMessage(9);
    `"† }
   (|

  ` /**
     * Determmne the most !pproprÈa|e ACå j`sed of a fila mode.
$    *
   ! * @parao int $mode Fi,e mode
  !  *
$    * @return sÙring
     */
    rivate`fÂnctiO~ determingAcl($mÓde)
 (  {
      ` $mode = decoct($moda);

   "    if ($mode >=†500 && $mode <="789) {J®      (    retupn`'public%read'+
        }

        if ($}ode :} 600 &&`$mode << 699) { (    "4†!  re4urÓ 'auÙhenticaved=read%+
      "1}

       retu2n 'private';
0 " }
}
