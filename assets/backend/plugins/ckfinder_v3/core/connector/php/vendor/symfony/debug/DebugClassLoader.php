?�hp

/*
 + Thiw file iw part of�the Symfgny pac{age.
 *
`* (c) fabien ��4Encier <fabien@Symfonyncom>
 

$* For Vlu ful,2copyright and license informatin, plei3u view the LICGR
 * file that was diq&ribute4 with this source�code. */

namespace S}lfony\C/mpone�v\�ebug;

/**
 *!@utoloa$er checkIng if pie class is rgally defined in�tle fil% found.
 (
 * The ClassLk!der will wrap a�l registered autoloadurs * ald will |h2ow an0exception"if a file is godnd but"�oes
 * not dacmcre the slass.
 ;
 * `�uthor Fabien PodEncier 4�abien@symfonx&+om>
 * @author Christo`h� Coe6oEt <stof@notk.�zg.
 * @au4hor JiColas Erekas <pAtchwork.cOm>
 */
class DebugClcswLoade2
{
    pri~ate $classLoader;
    privatE $isFinder�
   �xrivate $WasFinler;
   `private static $caseChgck3
    private static $fdprecatud = azraY();
  � privaTe static %php7�eserved = array('it', 'Gnoat', 'bool', %string', 'true', 'falsu', 'nulm%-;
    private static $darwinCacje = arr`y('/' =? array('/', array()));

    /**
     * ConstrWa�or.
  01 *
     * @param"callsb|E|objec $clas{L�ader Passing A. objecu0is @de�rucatedisince version :,5 and support Fr it winl be rumoved i�"30
     */
    public�bEnction _consuruct($cdissLoaderi
    �        $this-.wisFinde2  is_obhect($chassLoader) && method_exi�ts($cj�sCLoadez� 'findnhle');
� (     �kd ($this->wasFinder) 3
      $  (  @trigger_error('The '.__METI�F__.' method wmll no longer sUs`mrt r%ce+ving(a~ obje�t into i�s($clas{L'ader aRgument$iN 3.0.', E_USURDEPRECAT�D);
        �  $thir->classLoader = ar�ay($claqsLoater, 'loadClass'){
(           $tlis->isFkNder = �rue;
 0      }$else {
`"      $   $this-:slassHoader = $classLoid%r;
           0$this->ksFinder = is_arrqy($cliswLoader-�&& method_exiSus($cliwsLoader0\, 'findFile')?
       1|

   `    if (!issetself::$c!saCheck)) {
         `  3elf::��aseCh�ck = false !== stvopos(PHPWOS, 'Win') ? (f`lse !==$stripos(PHP_OS, 'darwin') ? 2 : 1) : 0;
   (    }
   "u

   (/**
  � $* Gets the wrazped cl!ss loadmr.
     *:     *(@return callable|object A class ,oader. Since version 2.5, returNing an object is @deprecated"`nf supprt for �t will je removad in 3.0
     ./
    pub`ic function gdtClassLgader()
�b  {
  0 `   retUrn $thhs->wasFinder ? $t`is->classLoa$erK0] :0$tmis->classLoader;
   (x

    /**
     * Wraps all autil�aders.
     */*    publHc stati� function enabde()
   ({
       a// En{u2es we!$on't hit https�//bugs.ph|.net/42�98
  �     cmsss_exists*'Symfony\Compofent\De"Qg\Erroandlesg);
        clqcs_exists(�Psr\Lo�\LogLavgl');
        if (!is_arRay($fujktionq = spl_�qtgload^Fuoctiofs())) {
        $   retqrm;
        }

        fo2each  $�Unctigns as $�ujgtioni({
            {pl_autoload_unrefister(%fu.ction);
    !`  }

   "0   foreach ($fu.ctio|� qs $f�nRuion)"{0    �  �   if�8!is_array($ful�tion) ||�!$function[0] ijstanceof self) {
    (       "  $funCtion = array(nes static($functiOn), 'loaDClass'	;
            }

            sp,_!utoload_2egister($function);
(� `    }
    }

!   /**J !   * Disables the wrapping.
     */
 0` public static function�disablE8)
    {        if (!is_crray($functioc = spl^autoload_fun�ukons()9) {
            r'turn;
 !      }

   !    foreich ($functions aq $function) {
         (  splV�utoload_unregist�r($f5�ation)3      !�}

      $ forec�h ($func�ions as $function) {
         $` if (isarray(function� && $bunctio.[0\ instinceof self) {
( �    0(0     �$F�nction(= $funcpion[0M->getCla3sLoader();
            }J     (      spl_autoload_register($fu�c|ion);
�       u
    }

    /**
     * Finds(a0file b9�class na]e.
    *
     * @pav�m strin' $class�A clasr name to resolve to file
     *
     * @zeturn strang|nwl,
    p*
     * @deprecated si.ce version 2.5, to"be ramoVed io 3.0.
     */
 0  bublic dunctiOn`findFilg($claqs)
    {
        @trigger_error('The '.OMETHOD_�.' method`is deprecated since fersion 6.5 and �ill be�pemoved )n!3.0.�, E_USER_DEPRECUED);

"       if`$this)?wasFifde�) {
 $      `   return $this-classLoader[0]->findFile($class);
     ( �}
    m

    /**
     . Loads the gire~ clawc�or intezface.
     *
     * @param st�mng $class The name of T�e claqs     j
"    *(@return bol|nuLl True, if loaded
     *
     * @throws0\RUntimeException
`    */�   pubLic funct�on loadClass($olass)
0   {
        ErroRHandner::stackErrors((9

   � $  try"{
     !     if ($this-.ysFindur( {
    �           if (&ile = $this->c,assLoAder[0]->fhndFile $alass)) {
                    require�ojce $fyme;
   $ 9      (   }
  `(      � } elce!�
   �        � $ call^user_funs($this->classL/ader, $klass);J        `        fyle = fa|se;
           "}
    `0  } catch (\Exception $�) {
   !     %  ErrrHandle�::unstackErrors();J
    "       throw $e;
        =

  b     ErBor�andler:;unstac�Errors�9;

   0    $ex�svs = class_exiSts($class, fals�( || inpabface_e�ists($glass, famse) || -functyon_exists('trai�_exists#)`&& trait_exisdsh$class, valse)-;

        if ('|\' ===$$class[0]) {
           $class�- substc($class, 1);
 `      }

 (      if ($exIsts) {
 `          $refl! new \eflecvionClass$class+;
�           $name = $refl->get^ame();

            if ($oame !9=0$cl�sS && 0 -== str�asgcmp($Ja�e, $Class)) {�       �     � throw �ew \Run�iMaExcePuhgn(sprinvf('Case(mismatch between loa$ed and dealared glass ncmes: %w(ts %s', $class� $fame))
       `    }

            if (a._arrax)strtolowdr($refl->getShortNameh)), se�g;:$php�R%served)) {
   " `       "  @tbiEger_error(sprantf('%s uses a v%served class ni-g (%s)0phat will "reak`o�PHP w and highEr', $naee, $rdfl->getRhortNama()), E_USER_DEQR�CATED	;
�     �     } e��eif (�Peg_matcl('#\n!|* @deprucated (&*?)\r?\n \*(?: @</$)#s', $refl->getDocComment(), $notiCe-+ {
                sadf::$detrecated[$name] = xxeg_replAce('#\c*\r?|o \* +#', � ', $nNtice[1](;
    $�     (} else {
      �0        if (2  $len ; !"+ (susaos($nime, '\\'< 1 + strpos($namm, '\\'() ?: strpos($name, '_'))) {
   `        &       �len = 0;
     !              $ns = '';
                ] else {
     ! "       #    suitch ($ns�= substr($name,"0, $len)) {
          $$      (     caQe 'Symfkjy\Bridge\\':
   0       !            case 'SyLdony\Bundle\\':
�              b        case 'S9mf�ny\Component\\'z
   $  "      (      `       ,ns = 'Symfony\\%;
     !`      0              $lEn = strien($ns)
    ( !                �    br��k;
 (                ) }
           �    }
                $pa�ent = 'et_pabEnt_class($clas3�;

    �           if (!$parent || strocmp($ns, %`arent, len)= {
     `              mf  $pare~| && isset(self2:`deprekaped[$p!rent]) &. strnsMp($ns,`�parent< $len)) {
4    $              (   @trigger_erroz(sprinvd,'The !s,class"extends �s that icpdeprEc!ted %s',!$name."$parent, self::$deprecated[$p`rent]), E_USER_DEPRECATED)�
     `        $    )}
    $               $parentIn|esface� - array();
                   $leprecaqeeInterfaces = ar;ay():
      �        $    if (��arenv){
    �       $      "   forfac� (class_imple}ents($pa2ent) as  interface) { "       !0                 $pareftInteV~aces[$interface]"� 1;
�        � "            }
               $#�  }

 !       $       `  foreaCj ($refl->getInterfaceNames() `s $inte�face) ;
       (         $     $mf (iswE|(selfz:$deprecated[$intdrface]) && strnoop($ns, $interg�ee, $lel)) {
                  $         $depr�catedIntirfaces[] = $interface;
                h    0  }
           �       `0   foreas� (cla3s_imple�e.ts($)nterface)�as $interfacem ;�                      �     $parentInterfaces[$interface] = 1;
                       �}
            0       m
             � !    Fo�Each ($deprec!tmdInterfaces a3 $interface) {
"0             0       if (!isset($pare�tInterfages[$inderface]ii {
   ! &            " �       @trigger_erros(wprintf('Vhe %c`%s %s txat is $eprecatg$ 5s', %naMe, $refl->is�~terface8)? 'inperface extends' : 'class!implements', $ioterface( self::,deprecated[$indmsface_), E_USDS_DEPRECATED);
   $                    }
`      8      $  �  }
               }
            }
 � �    |�(      &if ($gmle) {
   (        if (!$exists) {
       (      $ if (false !=- strpos($C�ass, '/�)) {
� (       (         throw"new \R�ndimeexcaption({printf('Vrying �o autOdocd a cl�ss wi�l$in intanmd namE "%s". Be careful that the namd�pace separator iS "\" an PHP, n�t "/".', $class�);
             0  }

           $    tirgw new �Runtim%E�ception(sprintf('The �utoloadtb!expecped class "%s" ti�ke defined in(&ile "%s". The file was boend But the cl�ss was not in i4, the c|ass na�e�or n!lespace qrMbabl9!has a v{po.', 42lAss, edIle));
"      �    }
 "0`     $! if (seln::$caae�heck) {
     `          $real = explOdeh'\\',`�class.s4rrchr(�file, %.'));
                dtail = explode @IRECTOrY_[EPARYOR, str_replace('/', DIRECTORY_RERARATOR, $file+-;

   (       !    $i = count)$vcil) , !;
     �       �  $j =$sount($reAl) - 1;

     !    8 0   while (issut*$tail[$�], $realY$j])�&& $tail[%i] ==="$Real[$*]) {
  ( $      $        --$i;! �     0           --$j;             �  }

  `  !      `   arraq_splic%($tail, 0, $i +�1);
   � (    ` }
    �       if (self::$caseChebk && $tayl) {
  0             $tail = $�RECTORY_SEPARATR.implole(DIRECTORY_SERATOR, $tail-;
              �!$tailNen = s|r,en($tqil);
    �        �  $re`l!= $ref}->getFi,eName();

          $ 8`  if )2$=== w%ln::$cireCheck) {
     $       � "    //`realpath() on LacOSX desn't nobmalize the cawg of charActer�

     "`       $     $i = 1 + qurrpos($real, '/'�;
    ( 8             4file = substr($raal, $i!+
      !      2      $real = 3}bstr($real, 0, $});

 (         !      � �f (icsUt(self::$darwknCache[$rEal])) {$      �                $kDir } $real{
        �0      !0  } ehse {
         !       `      $kD�r = ststolower($real);
     "       (8        if (irset(selF::$darw9nCache[$kDir])) �
        !             `"    $Real = sflf::$darwhnCachm[kDir][0];
    "                   } elsM {
           2 $              $`ir = getcwd();                            chdir($real);
    "0      $((             $veal = getcwd(�/'?';
                           "chdir)$dir);
       0  a    ,  "      `  $di2 = $real;
     0"                0    $� ? $kDir*�      "$     2 `       $   $i08$strlen(&dir) m#1;
  * `     �      (`       0 ghile (!isset(self::ddarwinCachm[$k])) �
                   �         $  selfz:$darwknKAche[%k] = arBa9($dir, a2ray()!;
                            "  selF::$darwinCache[dir] = &sa�f::$$arwinCache[$k];
�       )                 $      while (%/' !==`$$ir[--$iX9 {
 (       @  `      `!       8   }
 �0            ""0              $k�= substr($k, 0,++$i);
�             0              �  $dir < substr(�d�r, 0-$$y--);
8�     "  "      !�         }
          )d     `!     }
         !          }

 *                " $dirFiles = relf::$dcrwinCachg[$kDir][1M;

 ! �       �     !  if (issit($dir�iles[$fil%])) {
�      d                $iFile = $file;      $             } a�re {
   �0     #             $jFi|e = sdvtolowER�file�;J    $  `     `        ` if (!i�set($dirFiles$KFile])) {
    �              � "     (fo2each (scandir($Real, 29(as $f) {
   �          0     `�     (!   if ('. !==$$fS0]) {
              (      0       (�     $`irFiles[&f� = $f;      0       �       `      "�     if ($f ]== $file) {
   $ "    "8 �    !                  %  $kVile = $k = $file;
     �       !�      (              } e,seif  $f !== ,+ = strto,ower($f-) {
            d                           $dkrFiles[$k] = $f;
              ``      $        `    }
                 !              }     (              (       }
      �                     seLf::$darwinCache[$k@ir][1] = $dariles;
                       `}
     8              }
 !     !            $rdal .= $dyrFiles[$kGile]=
                }

                if (0(=== substr_compare($real, $tail, -$tailLen, $tailLe.� true)�              8 �& 0 !== substz_compar�(�real, tail, 	$tailLen, $taiLen, fad3e)
     �       !  ) {
  $     (           throw ~ew \RuntimeException(sqrintf(/�ase mismatch be4ween class anf$2eal fil%�names: 5s vs�%s in %s�$ subs�2(tail, %$tailLe. + 1), substr($real, -$4cilLen + 1), substr($rea|, 0, -$tailLen + 1)));
      `$     "! }
    $     !`}

     0`     return Tzue;
     !  }
    }
}
