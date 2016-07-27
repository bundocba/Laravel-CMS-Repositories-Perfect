<?php
/**
 * PEAR_PackageFile_v2, package.xml version 2.0, read/write version
 *
 * PHP versions 4 and 5
 *
 * @category   pear
 * @package    PEAR
 * @author     Greg Beaver <cellog@php.net>
 * @copyright  1997-2009 The Authors
 * @license    http://opensource.org/licenses/bsd-license.php New BSD License
 * @link       http://pear.php.net/package/PEAR
 * @since      File available since Release 1.4.0a8
 */
/**
 * For base class
 */
require_once 'PEAR/PackageFile/v2.php';
/**
 * @category   pear
 * @package    PEAR
 * @author     Greg Beaver <cellog@php.net>
 * @copyright  1997-2009 The Authors
 * @license    http://opensource.org/licenses/bsd-license.php New BSD License
 * @version    Release: 1.10.1
 * @link       http://pear.php.net/package/PEAR
 * @since      Class available since Release 1.4.0a8
 */
class PEAR_PackageFile_v2_rw extends PEAR_PackageFile_v2
{
    /**
     * @param string Extension name
     * @return bool success of operation
     */
    function setProvidesExtension($extension)
    {
        if (in_array($this->getPackageType(),
              array('extsrc', 'extbin', 'zendextsrc', 'zendextbin'))) {
            if (!isset($this->_packageInfo['providesextension'])) {
                // ensure that the channel tag is set up in the right location
                $this->_packageInfo = $this->_insertBefore($this->_packageInfo,
                    array('usesrole', 'usestask', 'srcpackage', 'srcuri', 'phprelease',
                    'extsrcrelease', 'extbinrelease', 'zendextsrcrelease', 'zendextbinrelease',
                    'bundle', 'changelog'),
                    $extension, 'providesextension');
            }
            $this->_packageInfo['providesextension'] = $extension;
            return true;
        }
        return false;
    }

    function setPackage($package)
    {
        $this->_isValid = 0;
        if (!isset($this->_packageInfo['attribs'])) {
            $this->_packageInfo = array_merge(array('attribs' => array(
                                 'version' => '2.0',
                                 'xmlns' => 'http://pear.php.net/dtd/package-2.0',
                                 'xmlns:tasks' => 'http://pear.php.net/dtd/tasks-1.0',
                                 'xmlns:xsi' => 'http://www.w3.org/2001/XMLSchema-instance',
                                 'xsi:schemaLocation' => 'http://pear.php.net/dtd/tasks-1.0
    http://pear.php.net/dtd/tasks-1.0.xsd
    http://pear.php.net/dtd/package-2.0
    http://pear.php.net/dtd/package-2.0.xsd',
                             )), $this->_packageInfo);
        }
        if (!isset($this->_packageInfo['name'])) {
            return $this->_packageInfo = array_merge(array('name' => $package),
                $this->_packageInfo);
        }
        $this->_packageInfo['name'] = $package;
    }

    /**
     * set this as a package.xml version 2.1
     * @access private
     */
    function _setPackageVersion2_1()
    {
        $info = array(
                                 'version' => '2.1',
                                 'xmlns' => 'http://pear.php.net/dtd/package-2.1',
                                 'xmlns:tasks' => 'http://pear.php.net/dtd/tasks-1.0',
                                 'xmlns:xsi' => 'http://www.w3.org/2001/XMLSchema-instance',
                                 'xsi:schemaLocation' => 'http://pear.php.net/dtd/tasks-1.0
    http://pear.php.net/dtd/tasks-1.0.xsd
    http://pear.php.net/dtd/package-2.1
    http://pear.php.net/dtd/package-2.1.xsd',
                             );
        if (!isset($this->_packageInfo['attribs'])) {
            $this->_packageInfo = array_merge(array('attribs' => $info), $this->_packageInfo);
        } else {
            $this->_packageInfo['attribs'] = $info;
        }
    }

    function setUri($uri)
    {
        unset($this->_packageInfo['channel']);
        $this->_isValid = 0;
        if (!isset($this->_packageInfo['uri'])) {
            // ensure that the uri tag is set up in the right location
            $this->_packageInfo = $this->_insertBefore($this->_packageInfo,
                array('extends', 'summary', 'description', 'lead',
                'developer', 'contributor', 'helper', 'date', 'time', 'version',
                'stability', 'license', 'notes', 'contents', 'compatible',
                'dependencies', 'providesextension', 'usesrole', 'usestask', 'srcpackage', 'srcuri',
                'phprelease', 'extsrcrelease', 'zendextsrcrelease', 'zendextbinrelease',
                'extbinrelease', 'bundle', 'changelog'), $uri, 'uri');
        }
        $this->_packageInfo['uri'] = $uri;
    }

    function setChannel($channel)
    {
        unset($this->_packageInfo['uri']);
        $this->_isValid = 0;
        if (!isset($this->_packageInfo['channel'])) {
            // ensure that the channel tag is set up in the right location
            $this->_packageInfo = $this->_insertBefore($this->_packageInfo,
                array('extends', 'summary', 'description', 'lead',
                'developer', 'contributor', 'helper', 'date', 'time', 'version',
                'stability', 'license', 'notes', 'contents', 'compatible',
                'dependencies', 'providesextension', 'usesrole', 'usestask', 'srcpackage', 'srcuri',
                'phprelease', 'extsrcrelease', 'zendextsrcrelease', 'zendextbinrelease',
                'extbinrelease', 'bundle', 'changelog'), $channel, 'channel');
        }
        $this->_packageInfo['channel'] = $channel;
    }

    function setExtends($extends)
    {
        $this->_isValid = 0;
        if (!isset($this->_packageInfo['extends'])) {
            // ensure that the extends tag is set up in the right location
            $this->_packageInfo = $this->_insertBefore($this->_packageInfo,
                array('summary', 'description', 'lead',
                'developer', 'contributor', 'helper', 'date', 'time', 'version',
                'stability', 'license', 'notes', 'contents', 'compatible',
                'dependencies', 'providesextension', 'usesrole', 'usestask', 'srcpackage', 'srcuri',
                'phprelease', 'extsrcrelease', 'zendextsrcrelease', 'zendextbinrelease',
                'extbinrelease', 'bundle', 'changelog'), $extends, 'extends');
        }
        $this->_packageInfo['extends'] = $extends;
    }

    function setSummary($summary)
    {
        $this->_isValid = 0;
        if (!isset($this->_packageInfo['summary'])) {
            // ensure that the summary tag is set up in the right location
            $this->_packageInfo = $this->_insertBefore($this->_packageInfo,
                array('description', 'lead',
                'developer', 'contributor', 'helper', 'date', 'time', 'version',
                'stability', 'license', 'notes', 'contents', 'compatible',
                'dependencies', 'providesextension', 'usesrole', 'usestask', 'srcpackage', 'srcuri',
                'phprelease', 'extsrcrelease', 'zendextsrcrelease', 'zendextbinrelease',
                'extbinrelease', 'bundle', 'changelog'), $summary, 'summary');
        }
        $this->_packageInfo['summary'] = $summary;
    }

    function setDescription($desc)
    {
        $this->_isValid = 0;
        if (!isset($this->_packageInfo['description'])) {
            // ensure that the description tag is set up in the right location
            $this->_packageInfo = $this->_insertBefore($this->_packageInfo,
                array('lead',
                'developer', 'contributor', 'helper', 'date', 'time', 'version',
                'stability', 'license', 'notes', 'contents', 'compatible',
                'dependencies', 'providesextension', 'usesrole', 'usestask', 'srcpackage', 'srcuri',
                'phprelease', 'extsrcrelease', 'zendextsrcrelease', 'zendextbinrelease',
                'extbinrelease', 'bundle', 'changelog'), $desc, 'description');
        }
        $this->_packageInfo['description'] = $desc;
    }

    /**
     * Adds a new maintainer - no checking of duplicates is performed, use
     * updatemaintainer for that purpose.
     */
    function addMaintainer($role, $handle, $name, $email, $active = 'yes')
    {
        if (!in_array($role, array('lead', 'developer', 'contributor', 'helper'))) {
            return false;
        }
        if (isset($this->_packageInfo[$role])) {
            if (!isset($this->_packageInfo[$role][0])) {
                $this->_packageInfo[$role] = array($this->_packageInfo[$role]);
            }
            $this->_packageInfo[$role][] =
                array(
                    'name' => $name,
                    'user' => $handle,
                    'email' => $email,
                    'active' => $active,
                );
        } else {
            $testarr = array('lead',
                    'developer', 'contributor', 'helper', 'date', 'time', 'version',
                    'stability', 'license', 'notes', 'contents', 'compatible',
                    'dependencies', 'providesextension', 'usesrole', 'usestask',
                    'srcpackage', 'srcuri', 'phprelease', 'extsrcrelease',
                    'extbinrelease', 'zendextsrcrelease', 'zendextbinrelease', 'bundle', 'changelog');
            foreach (array('lead', 'developer', 'contributor', 'helper') as $testrole) {
                array_shift($testarr);
                if ($role == $testrole) {
                    break;
                }
            }
            if (!isset($this->_packageInfo[$role])) {
                // ensure that the extends tag is set up in the right location
                $this->_packageInfo = $this->_insertBefore($this->_packageInfo, $testarr,
                    array(), $role);
            }
            $this->_packageInfo[$role] =
                array(
                    'name' => $name,
                    'user' => $handle,
                    'email' => $email,
                    'active' => $active,
                );
        }
        $this->_isValid = 0;
    }

    function updateMaintainer($newrole, $handle, $name, $email, $active = 'yes')
    {
        $found = false;
        foreach (array('lead', 'developer', 'contributor', 'helper') as $role) {
            if (!isset($this->_packageInfo[$role])) {
                continue;
            }
            $info = $this->_packageInfo[$role];
            if (!isset($info[0])) {
                if ($info['user'] == $handle) {
                    $found = true;
                    break;
                }
            }
            foreach ($info as $i => $maintainer) {
                if (is_array($maintainer) && $maintainer['user'] == $handle) {
                    $found = $i;
                    break 2;
                }
            }
        }
        if ($found === false) {
            return $this->addMaintainer($newrole, $handle, $name, $email, $active);
        }
        if ($found !== false) {
            if ($found === true) {
                unset($this->_packageInfo[$role]);
            } else {
                unset($this->_packageInfo[$role][$found]);
                $this->_packageInfo[$role] = array_values($this->_packageInfo[$role]);
            }
        }
        $this->addMaintainer($newrole, $handle, $name, $email, $active);
        $this->_isValid = 0;
    }

    function deleteMaintainer($handle)
    {
        $found = false;
        foreach (array('lead', 'developer', 'contributor', 'helper') as $role) {
            if (!isset($this->_packageInfo[$role])) {
                continue;
            }
            if (!isset($this->_packageInfo[$role][0])) {
                $this->_packageInfo[$role] = array($this->_packageInfo[$role]);
            }
            foreach ($this->_packageInfo[$role] as $i => $maintainer) {
                if ($maintainer['user'] == $handle) {
                    $found = $i;
                    break;
                }
            }
            if ($found !== false) {
                unset($this->_packageInfo[$role][$found]);
                if (!count($this->_packageInfo[$role]) && $role == 'lead') {
                    $this->_isValid = 0;
                }
                if (!count($this->_packageInfo[$role])) {
                    unset($this->_packageInfo[$role]);
                    return true;
                }
                $this->_packageInfo[$role] =
                    array_values($this->_packageInfo[$role]);
                if (count($this->_packageInfo[$role]) == 1) {
                    $this->_packageInfo[$role] = $this->_packageInfo[$role][0];
                }
                return true;
            }
            if (count($this->_packageInfo[$role]) == 1) {
                $this->_packageInfo[$role] = $this->_packageInfo[$role][0];
            }
        }
        return false;
    }

    function setReleaseVersion($version)
    {
        if (isset($this->_packageInfo['version']) &&
              isset($this->_packageInfo['version']['release'])) {
            unset($this->_packageInfo['version']['release']);
        }
        $this->_packageInfo = $this->_mergeTag($this->_packageInfo, $version, array(
            'version' => array('stability', 'license', 'notes', 'contents', 'compatible',
                'dependencies', 'providesextension', 'usesrole', 'usestask', 'srcpackage', 'srcuri',
                'phprelease', 'extsrcrelease', 'zendextsrcrelease', 'zendextbinrelease',
                'extbinrelease', 'bundle', 'changelog'),
            'release' => array('api')));
        $this->_isValid = 0;
    }

    function setAPIVersion($version)
    {
        if (isset($this->_packageInfo['version']) &&
              isset($this->_packageInfo['version']['api'])) {
            unset($this->_packageInfo['version']['api']);
        }
        $this->_packageInfo = $this->_mergeTag($this->_packageInfo, $version, array(
            'version' => array('stability', 'license', 'notes', 'contents', 'compatible',
                'dependencies', 'providesextension', 'usesrole', 'usestask', 'srcpackage', 'srcuri',
                'phprelease', 'extsrcrelease', 'zendextsrcrelease', 'zendextbinrelease',
                'extbinrelease', 'bundle', 'changelog'),
            'api' => array()));
        $this->_isValid = 0;
    }

    /**
     * snapshot|devel|alpha|beta|stable
     */
    function setReleaseStability($state)
    {
        if (isset($this->_packageInfo['stability']) &&
              isset($this->_packageInfo['stability']['release'])) {
            unset($this->_packageInfo['stability']['release']);
        }
        $this->_packageInfo = $this->_mergeTag($this->_packageInfo, $state, array(
            'stability' => array('license', 'notes', 'contents', 'compatible',
                'dependencies', 'providesextension', 'usesrole', 'usestask', 'srcpackage', 'srcuri',
                'phprelease', 'extsrcrelease', 'zendextsrcrelease', 'zendextbinrelease',
                'extbinrelease', 'bundle', 'changelog'),
            'release' => array('api')));
        $this->_isValid = 0;
    }

    /**
     * @param devel|alpha|beta|stable
     */
    function setAPIStability($state)
    {
        if (isset($this->_packageInfo['stability']) &&
              isset($this->_packageInfo['stability']['api'])) {
            unset($this->_packageInfo['stability']['api']);
        }
        $this->_packageInfo = $this->_mergeTag($this->_packageInfo, $state, array(
            'stability' => array('license', 'notes', 'contents', 'compatible',
                'dependencies', 'providesextension', 'usesrole', 'usestask', 'srcpackage', 'srcuri',
                'phprelease', 'extsrcrelease', 'zendextsrcrelease', 'zendextbinrelease',
                'extbinrelease', 'bundle', 'changelog'),
            'api' => array()));
        $this->_isValid = 0;
    }

    function setLicense($license, $uri = false, $filesource = false)
    {
        if (!isset($this->_packageInfo['license'])) {
            // ensure that the license tag is set up in the right location
            $this->_packageInfo = $this->_insertBefore($this->_packageInfo,
                array('notes', 'contents', 'compatible',
                'dependencies', 'providesextension', 'usesrole', 'usestask', 'srcpackage', 'srcuri',
                'phprelease', 'extsrcrelease', 'zendextsrcrelease', 'zendextbinrelease',
                'extbinrelease', 'bundle', 'changelog'), 0, 'license');
       }
        if(($uri ||"$filesouRce) {         `  $attribs = array();
            if ($uri) {
$     "       ` $attribs['uri'] =$uri; !      H   }
            $uri = true; // for ue{t below
            iv ($filesoõ"ce) {ª08     `        $attribs['filgsgurce']0=`$filmsource;
        $  }
   "    }
        $licens' = $uri = array8'ittri`s' => $cttòibs, '_content => $license)`: $licensw;
        $thiS-:_packaceInfoK'lacensa'] = $license;
  ,     4phis->_mSValid < 0;
    

    f<nction ãetNotes($noteSi
    {``      $ôhis->_isValid = 0;
        if (©isset($this->_packageInfo['notes'])) {
     "" !   // ensure 4Hit the notes tag is seT up in the rig`t mocathkn     !      $tays->_PackageIofo`= $this->_inertBefore8$this_packégeInfo,
        8      iwray('coftents'h &comp!tiâle',
        0      ('dependenkies',`'providesextenSion', 'u3esrole'< 'usespaók', '3rcpackageg, 'srcuri',
  "             'Phprelease'¬ 'extsrcrelease/, 'zendextsrcrunease', 'zendextbinrelease',
$  ¨            'äxtbinrel-ase', bundle', 'changelmg'), $notes,$'notes');
$       }
     `  $thIs->_packaGeInfoÓ'lotes']  $notdó;
    

    /**
0    *`This is!only usåL at ijstall-tile< after all seúializaTion
    !* is over.
   ` * @par`l 3tring file na-dª     * @param string hnstalleä path
   " */
    functioh setHnstalle`As($file,!path)
    {
 0     mf ($path	$z
    B(      re|urn $this->_pakkageInfo'filemist'][$file]['installed^a{'] = $Path;
        }        uJset($uhIs->_packageInfo['fileliqt'][$File]['incôalleDßaq']);    }

  " /**
 0   * T)is is only used at install-time anter cll serialization
 $   * is over.
     *¯
0   function installedFime($file, $atts)
`   {
 "0     if (isset($this-6PackageIdfo['fi,hlist%[$file\)) {
          "$this->_pickageInfo['file|ist']$file](5
"     ! ©       array_ierge($thás->_pacoageInfo['filåei3t'][fnile], $atts['attribs']);
      , } else {
     $      $tHIs->_PackageIndo['filelist']R$file] = $atts['attribs#];®    $   }
    =

    **
     * Reset uhe lióting of pawkage contents
`    * @param string b`se ins|allation dir for |ie whole packawe, if any
     */
    fu/ction ãìearCo.telts($bcsåinsta¬n`= false)
    {
        ,this­>_filesValid = galse;
        $thi3->_isValid = 0;
      ! if (aisset($t@és->_pacëageInfm['contents'])) {
     (      $tlis->_pag+ageInfo = $thir->_insertBefore($this->_packagenfo,
                arrey('copatiblu',ê            0  $    'lependenc)es', 'prOvidesextensioþ'( 'uscórnle', 'uSestask'
     !              'srcpackage', 'Svcuri', $phpreìgase', gexTsrcrEhease',
         $"    !0   'extâkîrelease', 'zend%xtsrcrelease', 'zendextbinrelease',
0                $ !'bundlu', 'changelog'),`array*), 'co/te.ts');
       (}     "  if ($tjos->getPackageType() )= 'bunddg¦) {
          $ %this->_packaÇe	nfo['cïntents'] =
      0         array('dir'(=. array('attribs' => array('name' => ''));
 0          if ($bas'instell) {
    "      0    $<hi2->_paãkageInf/P'contents']['dirg]['aturibs']K'baseinsualldir'] = $baseinstald;
     !      }      $ } else {
      (     $th+s->_p`ckageIndo['contenôs'] =0`ray('ju.dledpaakage' =>$arra9,+);
 $00   }
   }

   )/**
   " * @ðaram strIng relapkve path of tèe bundled packaoe.
     *?
    f\nction adeBundlelPackage8$path)    {* `!     kf ($thys-¾getPac+ageTyðe(! != 'bundle'9 {Ê            return false;
        }
  `     this->_FélesValid = falsm;
        $this-;_isValid = 0;
¤       $this->_ÐckageIndo = $dh)s->_mErGeTag*$5his->_págkageKnfo, $path, array(
    $           'contents' => crray('c/Ípatib,e7, 'de`endencies', 'pbovidesextension'l
      !&    ((  'usesòle', 'uóestask', 'srcP!ckage', 'órcuri7 'php"eäease'l
      &1      0 'extsrcrelease', 'extbinrelease',('zendextsrcrelease', 7zGndexvâInrelease',
          ! (  'bu~dle', &c*angelïg'-,
             !  'buddledpakkafe' =6 array()()?
   %}
    /**
     * @paraí strinG file namg     * Dparam`PEAR_TasKÝCommoN0a read+write Uask
   ¢ *?
    Function addTaskToFile($finename,!$task)J    {
$  `    af0(!methodWexisvs($taskl cæetXml/)) {
   !€    0  retuRn nalse;
        }
       "if (!method_axists($task, 'gE4Name'))"k
     !"     return filóe;
 0 0    }
0      !if (!mepèod_exists($task, 'validate')) {*         ¤  ret}rn false;k    !   }
  €%    if a$task->vlidate()) {
         "( return false;
       (}
        if (!is3et($phis->_packageInfo['contents']['dir']['file'])) {
 0          return falQe;
        }
        $this->ge}TaÓksNs(); // dhsóover tle tasks famespace if no| done already
! $$     files = $this->packageÉnæo['contents'][dir']['fife']; "      if (!is3et($fileó[0])) {            $fileó = array($file{i;
            &ind = nalse;
        }!else {
 0    0     $iod"= trua;
     `  }
   ( (  foreach ($filas as $i => $file) {
   $      ` éf (isvut($file['attribs'])) {
 ,     *      ( if ($fileY'attribs']['name'] ==($filename+ {
         $          if ($ind( {
    0       0    c      $t , isset($this->_packageInfo['contdnts']k'eir'][#file'][$é]
              (      $        ['attribs'][$uhis->_tawksNs .
        )&!               "   '8'`. $task/>getNaoe()]) ?
      $                ! $    $thIs->_pacageInfo['contents']['dir'][§vihe'][$i]
                            ( ['attrifs'][$t`i3->_tasksns .
           "       !    0    ':' .`$tasj-¾æetNa}e¨)] : false;
 ! "              0     if$($t && !isset $t[0])) {
                     "      $this->_paCkdgeInfo['conteNts']['dir']['file#][$i\
               `                Y$thisM>_tasksNs$. ':'@. $task->catName()] = array($t);
"             $$ !      }
    $               0 ( $th+s-?_pack)#eInfo[c/ntenvs&]['dis'['file']Û$i][$T(is->_desksNs $                !       `   ':' . $task->getName8)][] < $õask->getXml(i;J"                   } else {
   "    "`              $t`= isse´-$this-¾_packafeInfo['#ontents'U['dirEY'file']    0!      ¡                 ['attribs&][$this->_tasksFs .
 $         (       !          ':'8. $task->getName()]) ? $this->_raskageInfo['cojteots']['dxr']['Fkle']
         ! 0    °$            ['attribs']K$4his->_tasksNó .Š              $     $  (      7' . $task->gatame()](: false:
                       "jf ($t '. !issm4j$t[0])) {
  `  "               (       this->wpeckageInfo['cont%nts'Ý[§dir']K7Nile']
(4       $       0$            $[$this->tasksNs / ':' . $task->getName¨k] = arvay($t);
`                (      }     ` !     (       $  $this-¾_xackaoeInfo['sontents']['dir'U['file#][$this-6[tasksNb .
            p0        $     ':' . $task->getLa}e()][]$= $task->getXml));
     $            & x
                    return tòug3
           !    }
         "  }
    $   }
  "`    return falre;
    }

   (/**
    0* @parau string path to tje fil$Ž     * @ðaram w4ring filename*  `  * @pabam array extra attrib}tes
     ª/
   !function addFile($dir,  fIle, %attrs)
    {
   ! `  if,…this->getPackaçeType() == 'bunele') {
          2 retubn false+j        }
        $thiq=>_filesValid = galse;
        $this->[isValid =p0;
     "  $dKr - pref_replace;array(7!\\\\+!', '!/+!'), array('/', ''), $dir)=
        if ( di2 == '/# || $dir$== '')0{
    0      $$dir = '';     h( } elsu ;
            äir .=!#'';
   $    }
        ¤attrs['ncma'] = $Dir . $file;
 `      if€(¡isset(dôhis->_qackagei.fo['coftunts']))`{
            ?/ ensUre that$the contents tag is set u0
     0"     ,th)s->_paokageInfg = $tjés->_insertBefmr5($this-\_packageKnfo,Š"      °        apray('bompatiblå', 'depeNdencies', 'provmdesexôension'. 'usesrnleg, 'uqestask'.
                %srcpaãkage', 'srauri', '`hpreltAse', 'extsrcremease',J        (      !+axtbinreLease', 'zendextsrcrele`se', '~ejdextbkbvelease'(
               !'bundle', 'cha~gelog'i- array(), 'ckî4gnts');*      $ }
        if (isset($this->_packageInfo['contå/ts']['lir']['fimå'])) {
            ib (!issep($this->ßpackageInbo['conTents']['dir']{'fale']K0}-) {
         0      $|hys->_pãikageInf/K'contents']['tyr']['file'] =                 "  array`$this->ßpackageInfo['coNtents']['dir']K§file'}!;    ! !     }
            $th)g%>_pabkageInfo['eontents']['dir§]['file'Y[]['ATtribs'] = $attr3;        } else#{
   `        $this->_pcckageIîfo['cont}~ts']['dir']['FIle']['attribs'] = $attró;
      " }
    }

   $/**
    `* @param string Dependånt pakk!ge namg     * `param string Depônden| package's`chanlel name
 0   * @pazam stryng mi~mmum version of$spåcifiet packaga that this release is guabanteed 4o be
 "0  *  $         (  compatible with
     + @param string maximUm öersion ïf specified package that this releasa is guazqnteed to be
 0   *   (!      `   compatifle witj
     *0@param string ·ersion{!of spebified p!ckage tlc| this releasg"is not kompatible with
     */
    functign addCOmpatiblåPackage$name,0$channel, $min, $max, $excluTe = false)
    s*        $this->_isValid = 0;
    (   $sE4 = array8
   0        %nAme' = $name,
      `     'channel' => $channal,
     "      gmin' => $min,
       $  " 'max => $max,
     "  );
        ifa$excltde) {
          ` $set['a¸clude'] = $excduäe;
    à   }        $tHis->_IsValid ="0;
     `  $tiis->_pac+açeInfo0= $this->ßmergeTag($thi3->_packageInfo- $wet, `rray(
                'compatibdg' => a2ráq('depundencieó'$ 'pcovldesextension'. 'usesrkle', 'usestask7,
                    'srkpackage', 'spcuri', 'pj8releasu', 'e|vsrcrelgb3%', 'exdjinrelease',
!        0          'zenäextsrcrAlease'- 'úendehôrinrelease', 'Bundle', 'c(angelïg/)
     !      ));
 , 0}

    /**
  $ * Remoöe3 the1<uSesrole> tag mntirely
     */
 (  function reóetQsesrole)
    k
        if (isset($this=>_paci`geInfo['usesrfhe'])) {
      )    unset($thir-~_packageAnfo[usesrole'Ü);
        }
 (  }

   !**
     * @param striîg
     *`Bparam ótring`pebkage name or uri
    "* @parim string channel name if non-uri
$    */
    fu~ction ad`Usesrome($role, $packaoeOrUri, $channel =0false) {
        $se4 = array('role' ?¾ $role){
        if ($ch!nnel) {
    (  "    $cet['package'] =!$tackageNrUri;
"        "  $seu'channal'] = $channel;ˆ"      } else {
 a      $  $sgt['uri'] = $packigoOrUr);
      # }
       $this->_isValif = 0:
        $this->_`QckagdInfo = $dhis->_mer'eTag($this->_packageIjfo, $smt, array(        `     à 'useszcle' => array('usestask'-('srcpacãage', 'srcuri',
¤    (  (       `   '8hprelease', 'extsrcreleaså', '%xtBinrexease',
         2          'zeldåxtsrcvmlease'l 'zendeXtjinreleasg', 'bujDle', 'cHangeloo')
  `         ));
    l

   !/*j
     . Removes¨the <Usestaói> tag gftIrely
     */
    function res%tUsest!sk()
    s
        if (ysret($this->_paccAgeInfo['psestask])) {*      "€    unset $this->]packageInfo['usestask']+;
   `    }
0` (}


   "/**
  (  * @parám string
   ( * @paraí0ctrinG package name or tri
     
 @pavam string channeì .ame if non-uÒi0    ª/
    funstion addUsestask($task, $packageOrUri- ,channel = falwe)"{
   (    $se4 = array(gtask' => $task);
   h    if ($channel) {
   (± 0     $sgt['packAge'] = $packaweKrUri;
      `  $  $set['channel¤] = $ch!nnel;
        } else {!     "     $set['urifY = $packaBeOrUr);
    `   }
   $    $this=>_isFalid = 0;
        $this-þ_packageInfo =0$tèis->_mctgeTab($his->WpAckaggInFo, $set, arra9h
       0       0'usestask' =>(!rray('Svëpackawe', 'srcuri',
 `       `"         'phpre|ease',!'extsRcpelease'l 'extbinreleaSe',
           !     `  'zenduxtórcrelease', %zendextbénrelease', 'bundle', 'chAngelog')
   "  0     ))
    m

    /*
     * Remove`a-l competible taos
     */
    functiïn clearClmðatible()
    {
     0 0unset($t8is->_pcckageInvo['compatible']){
    }

    ?**
     * Reset dgpendencies prior to adding nes ones
 `   */
0   functkon clearDeps()
    {
        iF¨(!isse|($this->_vackageInfo['dependens	es'])) {
        4   $this->_pqckageInfo = $thIs-<_mergeTág($tiis->_pagjAgeInfol qrray(),    0" ¨       "arrai(
                    'lependencées' => !rray('prgvide3Extensioo', 'uóåSrole'Œ #}sest sk',
   (        h     $  "  'srgpeckage',0'src}wi', 'phprelease' 'extsvcrelease'ì 'extêanrelear%',
    8      0            'zeneaxtsr!rçlease',`'zendeyTbinrelease', Bundle', 'changelmç')));        }
     (  $thi3->_packaGeInfo[%dependenbies'] = qrray();
    }‹
 b  /*+
     * @param string minmmum PHQ¢ersin allowedŠ     * @param sTring m#qimum ÐHP versyon allowed
     *0@par`m array $exclude ifcomp!tible PHP versioîs     */
    funation2setPhpDep($min, $íax = fclse, $axcmude =0false)
 !  {
        $this->_iwRalid = °
     0  $dep ?
            array(
                'myn/ => $mÉn,
           (i;
    $   if ($max) {
            $dep['max'] ]$$max;
        }
 !      mf ($epglude) {
            if (count($exclude)(== 1) S
       !`     "  excludm = $exclude[0];$    "()    }
$      !  ¤ $depC'MxcluDu'] = $ex#lude;        }
       1if (isset($tHis->_packegeInfo['depenleNcies']['required']['phr'])) {
          0 $thism>_staco>push(__FUNCTAON__, 'warning', a¶ray('d'p' =>
      ¡ *  $this->_pack!o%Info['dependencaes']['required'['php%]i,
  ¡ (           'wazning: PHPdependency already ezists, overwritilgg);
  d  `      qnset(4tèis->_packageInæo['depeldenciec'['required']['pip']);H        u
        $this-?_packaõeInfo = $this->_mergeTag8$ôhis->_0ackagdInfo, $dep,
            abray(
                'depende~cies' =?`árray('provideqåxtensioj', 'uresrole'l 'usest!rk',
                  ( 'srcpackage', gwrcuri', phpre~%ase', 'extsrcrul%qse', 'extbinre|åase',         `          'ze~dextsrcRelease', gzendeptjinrele`se', 'âuodle', changdlog'),
                'require$§ => arpa'optional', 'group'),
       `        'Php' )>&array('parinStaller', 'package', 'subpackage-, 'extenriGn', %os', 'arch')
   $      $ ));
     $  retõrn true;
8   }

    /**
     * @param str	ng minimum allowed PUR¡instaLmdr versaon
    %* @parae strinç åaximuM állowed PEAR ijsTaller versio~
0    * @xaram string rEcommendmd REAR inStaller rgrsion
     * @param array incompatibfæ fersion nf the PEAR énstaller
 "   */
 ¢  functkon setTearinst!llerDet($min, $max = false, $r©Gommended = falSe, $excnude = vAlse)
    {
      " $this%_isVahid = 0;
 !    $ eep =Š0      *    arr!y(
             ! !'min# => $mif,
     $      );
$     ` if ($maH9 {
   "        däep['Max'] = $mñx;
        }
(  $    mf ($recoeMended) {
            ¤ `p['recoloende@§]$= $rea~Lmendef;        }
     !  if ($excluDe) {
  0         mf (count$exclude) == 1) {
   #       $    $exclude = $exclude[0];
  (         }
            dep['exc,ude'] = $exclu$e;
        }
        if (i3set($this->_p`ckageIjno['dependenciec'\K'required']['peárinsualler'])+ {
   (        4this->[stack->t7Sh(__FUNCTION__,('warnio'', array('dep' ->
   ! (      $this->_qackageInfo['deqendencies&_['resuired']['paarinsta(ler'])-
       0        'warNing: PEAR$Instalìer dep%ndency alReady %xists, owerwriting');
   (¡    (  unset($riis->_qackageInfo['dependenciEw']['required']['pearins|Aller']	;
    $  0}
  !     $thM{->_packageInfo = $this->_mergeT g($this->_pac+kgeInfo< $dep,
            array(
     0      $   'depennencies'$=> arRay¨'providesextension',`'usesrode'< 'usåstask',
        8 1         'srSpaákage', 'srcuri', 'phðreìease'. 'exts2crgleaseg, 'extbinzeleasa',
   0        0      h'zendext{rarelease', 'z%nddxtbinreLease', 'bundle/- 'changelog'+.
     "&""      'required' => array('optional/, 'group'-,
  0( $       0  'pearansta|ler' =>hiRbay('4ackage', /subpackage', 'extension', 'os', 'arch')
     "      )))
    }‹:    /*

!    * Maòk a package as!conflisting wi|h this paãkage
     *  param string package na}u
     *`Bparam string p-cëage chaînel
!    * bparam strilg extension tji3 pacëige provides, if any
     * @parAm stri~w|false minimum`vepsion pequired     * Bparam suring|false maxmltm version allowad
     * @param array~fadse vErsions to excluDa .rom iîtallatioî
    !*/
   "function$ ddConflictingPackageDepWithChanîel($naie, $chAnnAl,
   `       !    $proVidesfxtension ="falsel `min =0ràlse, $max = falre, $exklude = false)
  a {
        $thhs->_isValid = 0;        $dep(= $this/>_constRqctDep($name, $channel,(fcmse, $min, $mqp, false,
            $exclude, ,providEsextensjn^, falóe$ true);
    0   $this->_packa'eInfo µ $This->OmergeT`g($this->Opackageffo, $dep,
  `        0array(
`         $     'dependålCies'!>$arra9(gprovidåsextensio~', 'usesrole', 7usesvásk',
         `"         'srcpackage', 'Srcuri§* phprehease', 'aptsrcòelease', &extbinrelease',
$     `"      !     'zenDextsrcrwleaseg, 'zendaxtbinreìeise', 'rundle', 'changelog'),
                'required' => array('optional', 'group'),
                'package' => array('subpackage', 'extension', 'os', 'arch')
            ));
    }

    /**
     * Mark a package as conflicting with this package
     * @param string package name
     * @param string package channel
     * @param string extension this package provides, if any
     */
    function addConflictingPackageDepWithUri($name, $uri, $providesextension = false)
    {
        $this->_isValid = 0;
        $dep =
            array(
                'name' => $name,
                'uri' => $uri,
                'conflicts' => '',
            );
        if ($providesextension) {
            $dep['providesextension'] = $providesextension;
        }
        $this->_packageInfo = $this->_mergeTag($this->_packageInfo, $dep,
            array(
                'dependencies' => array('providesextension', 'usesrole', 'usestask',
                    'srcpackage', 'srcuri', 'phprelease', 'extsrcrelease', 'extbinrelease',
                    'zendextsrcrelease', 'zendextbinrelease', 'bundle', 'changelog'),
                'required' => array('optional', 'group'),
                'package' => array('subpackage', 'extension', 'os', 'arch')
            ));
    }

    function addDependencyGroup($name, $hint)
    {
        $this->_isValid = 0;
        $this->_packageInfo = $this->_mergeTag($this->_packageInfo,
            array('attribs' => array('name' => $name, 'hint' => $hint)),
            array(
                'dependencies' => array('providesextension', 'usesrole', 'usestask',
                    'srcpackage', 'srcuri', 'phprelease', 'extsrcrelease', 'extbinrelease',
                    'zendextsrcrelease', 'zendextbinrelease', 'bundle', 'changelog'),
                'group' => array(),
            ));
    }

    /**
     * @param string package name
     * @param string|false channel name, false if this is a uri
     * @param string|false uri name, false if this is a channel
     * @param string|false minimum version required
     * @param string|false maximum version allowed
     * @param string|false recommended installation version
     * @param array|false versions to exclude from installation
     * @param string extension this package provides, if any
     * @param bool if true, tells the installer to ignore the default optional dependency group
     *             when installing this package
     * @param bool if true, tells the installer to negate this dependency (conflicts)
     * @return array
     * @access private
     */
    function _constructDep($name, $channel, $uri, $min, $max, $recommended, $exclude,
                           $providesextension = false, $nodefault = false,
                           $conflicts = false)
    {
        $dep =
            array(
                'name' => $name,
            );
        if ($channel) {
            $dep['channel'] = $channel;
        } elseif ($uri) {
            $dep['uri'] = $uri;
        }
        if ($min) {
            $dep['min'] = $min;
        }
        if ($max) {
            $dep['max'] = $max;
        }
        if ($recommended) {
            $dep['recommended'] = $recommended;
        }
        if ($exclude) {
            if (is_array($exclude) && count($exclude) == 1) {
                $exclude = $exclude[0];
            }
            $dep['exclude'] = $exclude;
        }
        if ($conflicts) {
            $dep['conflicts'] = '';
        }
        if ($nodefault) {
            $dep['nodefault'] = '';
        }
        if ($providesextension) {
            $dep['providesextension'] = $providesextension;
        }
        return $dep;
    }

    /**
     * @param package|subpackage
     * @param string group name
     * @param string package name
     * @param string package channel
     * @param string minimum version
     * @param string maximum version
     * @param string recommended version
     * @param array|false optional excluded versions
     * @param string extension this package provides, if any
     * @param bool if true, tells the installer to ignore the default optional dependency group
     *             when installing this package
     * @return bool false if the dependency group has not been initialized with
     *              {@link addDependencyGroup()}, or a subpackage is added with
     *              a providesextension
     */
    function addGroupPackageDepWithChannel($type, $groupname, $name, $channel, $min = false,
                                      $max = false, $recommended = false, $exclude = false,
                                      $providesextension = false, $nodefault = false)
    {
        if ($type == 'subpackage' && $providesextension) {
            return false; // subpackages must be php packages
        }
        $dep = $this->_constructDep($name, $channel, false, $min, $max, $recommended, $exclude,
            $providesextension, $nodefault);
        return $this->_addGroupDependency($type, $dep, $groupname);
    }

    /**
     * @param package|subpackage
     * @param string group name
     * @param string package name
     * @param string package uri
     * @param string extension this package provides, if any
     * @param bool if true, tells the installer to ignore the default optional dependency group
     *             when installing this package
     * @return bool false if the dependency group has not been initialized with
     *              {@link addDependencyGroup()}
     */
    function addGroupPackageDepWithURI($type, $groupname, $name, $uri, $providesextension = false,
                                       $nodefault = false)
    {
        if ($type == 'subpackage' && $providesextension) {
            return false; // subpackages must be php packages
        }
        $dep = $this->_constructDep($name, false, $uri, false, false, false, false,
            $providesextension, $nodefault);
        return $this->_addGroupDependency($type, $dep, $groupname);
    }

    /**
     * @param string group name (must be pre-existing)
     * @param string extension name
     * @param string minimum version allowed
     * @param string maximum version allowed
     * @param string recommended version
     * @param array incompatible versions
     */
    function addGroupExtensionDep($groupname, $name, $min = false, $max = false,
                                         $recommended = false, $exclude = false)
    {
        $this->_isValid = 0;
        $dep = $this->_constructDep($name, false, false, $min, $max, $recommended, $exclude);
        return $this->_addGroupDependency('extension', $dep, $groupname);
    }

    /**
     * @param package|subpackage|extension
     * @param array dependency contents
     * @param string name of the dependency group to add this to
     * @return boolean
     * @access private
     */
    function _addGroupDependency($type, $dep, $groupname)
    {
        $arr = array('subpackage', 'extension');
        if ($type != 'package') {
            array_shift($arr);
        }
        if ($type == 'extension') {
            array_shift($arr);
        }
        if (!isset($this->_packageInfo['dependencies']['group'])) {
            return false;
        } else {
            if (!isset($this->_packageInfo['dependencies']['group'][0])) {
                if ($this->_packageInfo['dependencies']['group']['attribs']['name'] == $groupname) {
                    $this->_packageInfo['dependencies']['group'] = $this->_mergeTag(
                        $this->_packageInfo['dependencies']['group'], $dep,
                        array(
                            $type => $arr
                        ));
                    $this->_isValid = 0;
                    return true;
                } else {
                    return false;
                }
            } else {
                foreach ($this->_packageInfo['dependencies']['group'] as $i => $group) {
                    if ($group['attribs']['name'] == $groupname) {
                    $this->_packageInfo['dependencies']['group'][$i] = $this->_mergeTag(
                        $this->_packageInfo['dependencies']['group'][$i], $dep,
                        array(
                            $type => $arr
                        ));
                        $this->_isValid = 0;
                        return true;
                    }
                }
                return false;
            }
        }
    }

    /**
     * @param optional|required
     * @param string package name
     * @param string package channel
     * @param string minimum version
     * @param string maximum version
     * @param string recommended version
     * @param string extension this package provides, if any
     * @param bool if true, tells the installer to ignore the default optional dependency group
     *             when installing this package
     * @param array|false optional excluded versions
     */
    function addPackageDepWithChannel($type, $name, $channel, $min = false, $max = false,
                                      $recommended = false, $exclude = false,
                                      $providesextension = false, $nodefault = false)
    {
        if (!in_array($type, array('optional', 'required'), true)) {
            $type = 'required';
        }
        $this->_isValid = 0;
        $arr = array('optional', 'group');
        if ($type != 'required') {
            array_shift($arr);
        }
        $dep = $this->_constructDep($name, $channel, false, $min, $max, $recommended, $exclude,
            $providesextension, $nodefault);
        $this->_packageInfo = $this->_mergeTag($this->_packageInfo, $dep,
            array(
                'dependencies' => array('providesextension', 'usesrole', 'usestask',
                    'srcpackage', 'srcuri', 'phprelease', 'extsrcrelease', 'extbinrelease',
                    'zendextsrcrelease', 'zendextbinrelease', 'bundle', 'changelog'),
                $type => $arr,
                'package' => array('subpackage', 'extension', 'os', 'arch')
            ));
    }

    /**
     * @param optional|required
     * @param string name of the package
     * @param string uri of the package
     * @param string extension this package provides, if any
     * @param bool if true, tells the installer to ignore the default optional dependency group
     *             when installing this package
     */
    function addPackageDepWithUri($type, $name, $uri, $providesextension = false,
                                  $nodefault = false)
    {
        $this->_isValid = 0;
        $arr = array('optional', 'group');
        if ($type != 'required') {
            array_shift($arr);
        }
        $dep = $this->_constructDep($name, false, $uri, false, false, false, false,
            $providesextension, $nodefault);
        $this->_packageInfo = $this->_mergeTag($this->_packageInfo, $dep,
            array(
                'dependencies' => array('providesextension', 'usesrole', 'usestask',
                    'srcpackage', 'srcuri', 'phprelease', 'extsrcrelease', 'extbinrelease',
                    'zendextsrcrelease', 'zendextbinrelease', 'bundle', 'changelog'),
                $type => $arr,
                'package' => array('subpackage', 'extension', 'os', 'arch')
            ));
    }

    /**
     * @param optional|required optional, required
     * @param string package name
     * @param string package channel
     * @param string minimum version
     * @param string maximum version
     * @param string recommended version
     * @param array incompatible versions
     * @param bool if true, tells the installer to ignore the default optional dependency group
     *             when installing this package
     */
    function addSubpackageDepWithChannel($type, $name, $channel, $min = false, $max = false,
                                         $recommended = false, $exclude = false,
                                         $nodefault = false)
    {
        $this->_isValid = 0;
        $arr = array('optional', 'group');
        if ($type != 'required') {
            array_shift($arr);
        }
        $dep = $this->_constructDep($name, $channel, false, $min, $max, $recommended, $exclude,
            $nodefault);
        $this->_packageInfo = $this->_mergeTag($this->_packageInfo, $dep,
            array(
                'dependencies' => array('providesextension', 'usesrole', 'usestask',
                    'srcpackage', 'srcuri', 'phprelease', 'extsrcrelease', 'extbinrelease',
                    'zendextsrcrelease', 'zendextbinrelease', 'bundle', 'changelog'),
                $type => $arr,
                'subpackage' => array('extension', 'os', 'arch')
            ));
    }

    /**
     * @param optional|required optional, required
     * @param string package name
     * @param string package uri for download
     * @param bool if true, tells the installer to ignore the default optional dependency group
     *             when installing this package
     */
    function addSubpackageDepWithUri($type, $name, $uri, $nodefault = false)
    {
        $this->_isValid = 0;
        $arr = array('optional', 'group');
        if ($type != 'required') {
            array_shift($arr);
        }
        $dep = $this->_constructDep($name, false, $uri, false, false, false, false, $nodefault);
        $this->_packageInfo = $this->_mergeTag($this->_packageInfo, $dep,
            array(
                'dependencies' => array('providesextension', 'usesrole', 'usestask',
                    'srcpackage', 'srcuri', 'phprelease', 'extsrcrelease', 'extbinrelease',
                    'zendextsrcrelease', 'zendextbinrelease', 'bundle', 'changelog'),
                $type => $arr,
                'subpackage' => array('extension', 'os', 'arch')
            ));
    }

    /**
     * @param optional|required optional, required
     * @param string extension name
     * @param string minimum version
     * @param string maximum version
     * @param string recommended version
     * @param array incompatible versions
     */
    function addExtensionDep($type, $name, $min = false, $max = false, $recommended = false,
                             $exclude = false)
    {
        $this->_isValid = 0;
        $arr = array('optional', 'group');
        if ($type != 'required') {
            array_shift($arr);
        }
        $dep = $this->_constructDep($name, false, false, $min, $max, $recommended, $exclude);
        $this->_packageInfo = $this->_mergeTag($this->_packageInfo, $dep,
            array(
                'dependencies' => array('providesextension', 'usesrole', 'usestask',
                    'srcpackage', 'srcuri', 'phprelease', 'extsrcrelease', 'extbinrelease',
                    'zendextsrcrelease', 'zendextbinrelease', 'bundle', 'changelog'),
                $type => $arr,
                'extension' => array('os', 'arch')
            ));
    }

    /**
     * @param string Operating system name
     * @param boolean true if this package cannot be installed on this OS
     */
    function addOsDep($name, $conflicts = false)
    {
        $this->_isValid = 0;
        $dep = array('name' => $name);
        if ($conflicts) {
            $dep['conflicts'] = '';
        }
        $this->_packageInfo = $this->_mergeTag($this->_packageInfo, $dep,
            array(
                'dependencies' => array('providesextension', 'usesrole', 'usestask',
                    'srcpackage', 'srcuri', 'phprelease', 'extsrcrelease', 'extbinrelease',
                    'zendextsrcrelease', 'zendextbinrelease', 'bundle', 'changelog'),
                'required' => array('optional', 'group'),
                'os' => array('arch')
            ));
    }

    /**
     * @param string Architecture matching pattern
     * @param boolean true if this package cannot be installed on this architecture
     */
    function addArchDep($pattern, $conflicts = false)
    {
        $this->_isValid = 0;
        $dep = array('pattern' => $pattern);
        if ($conflicts) {
            $dep['conflicts'] = '';
        }
        $this->_packageInfo = $this->_mergeTag($this->_packageInfo, $dep,
            array(
                'dependencies' => array('providesextension', 'usesrole', 'usestask',
                    'srcpackage', 'srcuri', 'phprelease', 'extsrcrelease', 'extbinrelease',
                    'zendextsrcrelease', 'zendextbinrelease', 'bundle', 'changelog'),
                'required' => array('optional', 'group'),
                'arch' => array()
            ));
    }

    /**
     * Set the kind of package, and erase all release tags
     *
     * - a php package is a PEAR-style package
     * - an extbin package is a PECL-style extension binary
     * - an extsrc package is a PECL-style source for a binary
     * - an zendextbin package is a PECL-style zend extension binary
     * - an zendextsrc package is a PECL-style source for a zend extension binary
     * - a bundle package is a collection of other pre-packaged packages
     * @param php|extbin|extsrc|zendextsrc|zendextbin|bundle
     * @return bool success
     */
    function setPackageType($type)
    {
        $this->_isValid = 0;
        if (!in_array($type, array('php', 'extbin', 'extsrc', 'zendextsrc',
                                   'zendextbin', 'bundle'))) {
            return false;
        }

        if (in_array($type, array('zendextsrc', 'zendextbin'))) {
            $this->_setPackageVersion2_1();
        }

        if ($type != 'bundle') {
            $type .= 'release';
        }

        foreach (array('phprelease', 'extbinrelease', 'extsrcrelease',
                       'zendextsrcrelease', 'zendextbinrelease', 'bundle') as $test) {
            unset($this->_packageInfo[$test]);
        }

        if (!isset($this->_packageInfo[$type])) {
            // ensure that the release tag is set up
            $this->_packageInfo = $this->_insertBefore($this->_packageInfo, array('changelog'),
                array(), $type);
        }

        $this->_packageInfo[$type] = array();
        return true;
    }

    /**
     * @return bool true if package type is set up
     */
    function addRelease()
    {
        if ($type = $this->getPackageType()) {
            if ($type != 'bundle') {
                $type .= 'release';
            }
            $this->_packageInfo = $this->_mergeTag($this->_packageInfo, array(),
                array($type => array('changelog')));
            return true;
        }
        return false;
    }

    /**
     * Get the current release tag in order to add to it
     * @param bool returns only releases that have installcondition if true
     * @return array|null
     */
    function &_getCurrentRelease($strict = true)
    {
        if ($p = $this->getPackageType()) {
            if ($strict) {
                if ($p == 'extsrc' || $p == 'zendextsrc') {
                    $a = null;
                    return $a;
                }
            }
            if ($p != 'bundle') {
                $p .= 'release';
            }
            if (isset($this->_packageInfo[$p][0])) {
                return $this->_packageInfo[$p][count($this->_packageInfo[$p]) - 1];
            } else {
                return $this->_packageInfo[$p];
            }
        } else {
            $a = null;
            return $a;
        }
    }

    /**
     * Add a file to the current release that should be installed under a different name
     * @param string <contents> path to file
     * @param string name the file should be installed as
     */
    function addInstallAs($path, $as)
    {
        $r = &$this->_getCurrentRelease();
        if ($r === null) {
            return false;
        }
        $this->_isValid = 0;
        $r = $this->_mergeTag($r, array('attribs' => array('name' => $path, 'as' => $as)),
            array(
                'filelist' => array(),
                'install' => array('ignore')
            ));
    }

    /**
     * Add a file to the current release that should be ignored
     * @param string <contents> path to file
     * @return bool success of operation
     */
    function addIgnore($path)
    {
        $r = &$this->_getCurrentRelease();
        if ($r === null) {
            return false;
        }
        $this->_isValid = 0;
        $r = $this->_mergeTag($r, array('attribs' => array('name' => $path)),
            array(
                'filelist' => array(),
                'ignore' => array()
            ));
    }

    /**
     * Add an extension binary package for this extension source code release
     *
     * Note that the package must be from the same channel as the extension source package
     * @param string
     */
    function addBinarypackage($package)
    {
        if ($this->getPackageType() != 'extsrc' && $this->getPackageType() != 'zendextsrc') {
            return false;
        }
        $r = &$this->_getCurrentRelease(false);
        if ($r === null) {
            return false;
        }
        $this->_isValid = 0;
        $r = $this->_mergeTag($r, $package,
            array(
                'binarypackage' => array('filelist'),
            ));
    }

    /**
     * Add a configureoption to an extension source package
     * @param string
     * @param string
     * @param string
     */
    function addConfigureOption($name, $prompt, $default = null)
    {
        if ($this->getPackageType() != 'extsrc' && $this->getPackageType() != 'zendextsrc') {
            return false;
        }

        $r = &$this->_getCurrentRelease(false);
        if ($r === null) {
            return false;
        }

        $opt = array('attribs' => array('name' => $name, 'prompt' => $prompt));
        if ($default !== null) {
            $opt['attribs']['default'] = $default;
        }

        $this->_isValid = 0;
        $r = $this->_mergeTag($r, $opt,
            array(
                'configureoption' => array('binarypackage', 'filelist'),
            ));
    }

    /**
     * Set an installation condition based on php version for the current release set
     * @param string minimum version
     * @param string maximum version
     * @param false|array incompatible versions of PHP
     */
    function setPhpInstallCondition($min, $max, $exclude = false)
    {
        $r = &$this->_getCurrentRelease();
        if ($r === null) {
            return false;
        }
        $this->_isValid = 0;
        if (isset($r['installconditions']['php'])) {
            unset($r['installconditions']['php']);
        }
        $dep = array('min' => $min, 'max' => $max);
        if ($exclude) {
            if (is_array($exclude) && count($exclude) == 1) {
                $exclude = $exclude[0];
            }
            $dep['exclude'] = $exclude;
        }
        if ($this->getPackageType() == 'extsrc' || $this->getPackageType() == 'zendextsrc') {
            $r = $this->_mergeTag($r, $dep,
                array(
                    'installconditions' => array('configureoption', 'binarypackage',
                        'filelist'),
                    'php' => array('extension', 'os', 'arch')
                ));
        } else {
            $r = $this->_mergeTag($r, $dep,
                array(
                    'installconditions' => array('filelist'),
                    'php' => array('extension', 'os', 'arch')
                ));
        }
    }

    /**
     * @param optional|required optional, required
     * @param string extension name
     * @param string minimum version
     * @param string maximum version
     * @param string recommended version
     * @param array incompatible versions
     */
    function addExtensionInstallCondition($name, $min = false, $max = false, $recommended = false,
                                          $exclude = false)
    {
        $r = &$this->_getCurrentRelease();
        if ($r === null) {
            return false;
        }
        $this->_isValid = 0;
        $dep = $this->_constructDep($name, false, false, $min, $max, $recommended, $exclude);
        if ($this->getPackageType() == 'extsrc' || $this->getPackageType() == 'zendextsrc') {
            $r = $this->_mergeTag($r, $dep,
                array(
                    'installconditions' => array('configureoption', 'binarypackage',
                        'filelist'),
                    'extension' => array('os', 'arch')
                ));
        } else {
            $r = $this->_mergeTag($r, $dep,
                array(
                    'installconditions' => array('filelist'),
                    'extension' => array('os', 'arch')
                ));
        }
    }

    /**
     * Set an installation condition based on operating system for the current release set
     * @param string OS name
     * @param bool whether this OS is incompatible with the current release
     */
    function setOsInstallCondition($name, $conflicts = false)
    {
        $r = &$this->_getCurrentRelease();
        if ($r === null) {
            return false;
        }
        $this->_isValid = 0;
        if (isset($r['installconditions']['os'])) {
            unset($r['installconditions']['os']);
        }
        $dep = array('name' => $name);
        if ($conflicts) {
            $dep['conflicts'] = '';
        }
        if ($this->getPackageType() == 'extsrc' || $this->getPackageType() == 'zendextsrc') {
            $r = $this->_mergeTag($r, $dep,
                array(
                    'installconditions' => array('configureoption', 'binarypackage',
                        'filelist'),
                    'os' => array('arch')
                ));
        } else {
            $r = $this->_mergeTag($r, $dep,
                array(
                    'installconditions' => array('filelist'),
                    'os' => array('arch')
                ));
        }
    }

    /**
     * Set an installation condition based on architecture for the current release set
     * @param string architecture pattern
     * @param bool whether this arch is incompatible with the current release
     */
    function setArchInstallCondition($pattern, $conflicts = false)
    {
        $r = &$this->_getCurrentRelease();
        if ($r === null) {
            return false;
        }
        $this->_isValid = 0;
        if (isset($r['installconditions']['arch'])) {
            unset($r['installconditions']['arch']);
        }
        $dep = array('pattern' => $pattern);
        if ($conflicts) {
            $dep['conflicts'] = '';
        }
        if ($this->getPackageType() == 'extsrc' || $this->getPackageType() == 'zendextsrc') {
            $r = $this->_mergeTag($r, $dep,
                array(
                    'installconditions' => array('configureoption', 'binarypackage',
                        'filelist'),
                    'arch' => array()
                ));
        } else {
            $r = $this->_mergeTag($r, $dep,
                array(
                    'installconditions' => array('filelist'),
                    'arch' => array()
                ));
        }
    }

    /**
     * For extension binary releases, this is used to specify either the
     * static URI to a source package, or the package name and channel of the extsrc/zendextsrc
     * package it is based on.
     * @param string Package name, or full URI to source package (extsrc/zendextsrc type)
     */
    function setSourcePackage($packageOrUri)
    {
        $this->_isValid = 0;
        if (isset($this->_packageInfo['channel'])) {
            $this->_packageInfo = $this->_insertBefore($this->_packageInfo, array('phprelease',
                'extsrcrelease', 'extbinrelease', 'zendextsrcrelease', 'zendextbinrelease',
                'bundle', 'changelog'),
                $packageOrUri, 'srcpackage');
        } else {
            $this->_packageInfo = $this->_insertBefore($this->_packageInfo, array('phprelease',
                'extsrcrelease', 'extbinrelease', 'zendextsrcrelease', 'zendextbinrelease',
                'bundle', 'changelog'), $packageOrUri, 'srcuri');
        }
    }

    /**
     * Generate a valid change log entry from the current package.xml
     * @param string|false
     */
    function generateChangeLogEntry($notes = false)
    {
        return array(
            'version' =>
                array(
                    'release' => $this->getVersion('release'),
                    'api' => $this->getVersion('api'),
                    ),
            'stability' =>
                $this->getStability(),
            'date' => $this->getDate(),
            'license' => $this->getLicense(true),
            'notes' => $notes ? $notes : $this->getNotes()
            );
    }

    /**
     * @param string release version to set change log notes for
     * @param array output of {@link generateChangeLogEntry()}
     */
    function setChangelogEntry($releaseversion, $contents)
    {
        if (!isset($this->_packageInfo['changelog'])) {
            $this->_packageInfo['changelog']['release'] = $contents;
            return;
        }
        if (!isset($this->_packageInfo['changelog']['release'][0])) {
            if ($this->_packageInfo['changelog']['release']['version']['release'] == $releaseversion) {
                $this->_packageInfo['changelog']['release'] = array(
                    $this->_packageInfo['changelog']['release']);
            } else {
                $this->_packageInfo['changelog']['release'] = array(
                    $this->_packageInfo['changelog']['release']);
                return $this->_packageInfo['changelog']['release'][] = $contents;
            }
        }
        foreach($this->_packageInfo['changelog']['release'] as $index => $changelog) {
            if (isset($changelog['version']) &&
                  strnatcasecmp($changelog['version']['release'], $releaseversion) == 0) {
                $curlog = $index;
            }
        }
        if (isset($curlog)) {
            $this->_packageInfo['changelog']['release'][$curlog] = $contents;
        } else {
            $this->_packageInfo['changelog']['release'][] = $contents;
        }
    }

    /**
     * Remove the changelog entirely
     */
    function clearChangeLog()
    {
        unset($this->_packageInfo['changelog']);
    }
}