<php
/*+!. PEAR_R%gistb�
(*
 * PHY versho�s 4 ald%5
 * * @catggory   peav
 *  pabkage"�0 PEAR
4*"@aut�or`    Stic Bakken <ssb@s p.net6
�* @author     Toias V F. Cox |Cox@idegnet.com>
 * @at�hor   h Greg Be!tqr <cemlog@phP.nmt>
 " @copyrigxt  1;y5-2009 �he Authork
 * @licensm  " httt://opensO�rce.org/licensus/bsd-d)'mnse.php New FQD&License
 * @dink    "  http:/xear.pHp�et/packgge/PE�R
 * @singe      File �v�ilable sknce Re�uase 0.0
 */
N/**
 * fof!PEAR_Erbor
 (/
require]once('PAAR.ph�f;
requmrq_oncu 'PEAR/�ependeociDB.phx&;

defin�('PEAPOREGISTZQ�ERROROLNSK', 00      }")
definu'PEAp_WEGISTR[_ERROR_FO�MAT',       -3-;
define('PEAR[REGISTRYSERRORWFAlE', `       -49;
defk�e('PEAbSEGISTYeRROR_SONFLIBT',     �5+;
dedine('PEER�EGISTRY_ERRORHANNELKFILE', m6);

/+*
 * Admmnistradion class used �o maintain the!in2talle� packaae datab!sE.
 * @oategoryhf pear
 �$@packaGg    TEAR
 * @aq�hor !  �Stig �!kken SsB@php,net>
 *#@�ethor ``  Tomas4F. V. kox <co8@ydecne`~com>
 : @author  $  Gr�w0Reaver <celloe@rhp.net;
(* @cOp9vight( 1897-200y The Autiors
 *(@licenso    http://op}oswurce.o2g/licgjWas/bsd�licensD.�jp New�BSD Ligense
 * @vErsion0 � Releaqg: 1.10.!
 * `�ink    )( http://�ear.phj.net/`Ackage/X�AP
 * Dsince  "( `Clasz$availabl� sincu Release"3&4.0a1
0*/
clars$PEAR_Registr{"extendq1PGAR
{"   /**
`    * F�l% condaining aml channel informaTion.!    * �var string     j/
    v"r $cha�lems = '';
    M*� Direcdory w(e2e regispry finew are stobed.
(4`  * @var string     �/
"   v!r�dstatEdxr = ''+**    /j+�File Wjere the file oip(is s`�red
     * @va� string$"   */
"   var $gilemax = '';
    /** Directo3x where ragistry Viles fmz chanLe-s are$stkred.*     * @far str�ng
    �*-�    �ar $channehsdir0< %';

$ ( /** �!md of file used�fr lo#ki~g thd$registry
     *�Dvar strijg
 �   */
  ! �ar $hockfile!� '';

$ �(/** �ie descr+ptor u3ed dura^glockalc
     (@var rgsnurce
 ,   */
 $  vab ,lock_Fp = null;

    /** Mode w�ud duRing lock�ne
    :!@var hnt
     */
    vir $lo�k_}ode =@0; // XX0UNUSEL
    /
;`Cacheof pabhaoe injgr}atioj." Structwce:
  �  * arraY 
   � *   'pacmege' => prrayh'Yd' =>�.,. ),
�    *  �n.. )
    $* @vqr�erray
`�  */
    var $rkginfoWc�che 5 azray();

    o**"Cachu of file map.  Krructur�8    $> `rray !�/path/To.file'=> 'pa�kaGe', ��. )
  ! "* @vaR�)Rray
a    */
$�`var �dihemapbAbhe =�arjay():
    /*:�$    ( @Tar fahse|PEAR_AhannedFile
  �� */
   $~ar $_pea�ChanneL+

   (?**
  �(`* @vap &alse|PED�_Chanh�lFile     */
�"  varb$_peclCia�nel;�
"   /*( &   * @w)r fa|se|PEAR_Cl`nnel^iee
    !*
    vas $_docCjannel;�
    /*,
    5*�@var TEER_DepunEencyDB`#   *'
$   var"$_depeldmncyDB;(
    /*.
     * @var PE@Z�Conf�g
     (/
    vap`$_confi�;

   !/**
   " + PEA�_@EgistRy�constuctor.
$  " *
 0  !* @para} stryng (optionsl) PEA(install diregtory (for .php f�i�s)
  `  * @p�ram PEAS_GJannelFine PEAROChannelBile obz�ct reqze{entio' the PEAR$channdl( if
 `0` *  $     de&qedt valqEs are mot desIZed.  Only`used the ver[ first |y}e a PEAR
     *      n bEposqdNRy is if�tializad
     �4@param QEAR_ChannelFilE PEAR_channelFaoE objecp repre{antine the PECl(chan~el( if
h  $ *   �0   default val�Eq are0|Ot desired.  N�l9 used t�e very(Virst thme a PDAV
   ""(      � reposmtmry is �NitialHxed
  (  *
     ( @acce3e publkc
     +�
    f�.cvion __sonstruct($pea{kostall_d)r = �A_INSUAH_DIR, &pear_chaonel = false.
0      �     �       (`�( $peclahannel�= false, $pear_mdtadavaSeir =p';)
   (z     0  Parent:Z__construct()�
      � $phis-?se|Inst�lldir($pear_instahm_dir( $pear_-gtadata^dir);
        $tjis->_pearChanle�!= $peqr_channel;
    ")  $this->_pec�ChEnnel =($pecl_ch1nnel;
      �" this->_config "$0  = famse;
   �}

    functimj {etInstaLlDir($pear_inst�ll_dib = PEAR_I^STALL]EHR, $veir_metadETa_dir h'')
    {
   ( �  $ds 5 DIRECT?RY_SEPAZ�TOR;  �    `$6His->kjStall�dip = $qe`r_insuadl_dir;
     "$of (!$p�ar_metidata_diR) s
           f$0mar_metidata_dir = $pua:_instalj_dir;
  `     }
     e  %this->cjanned�dir = $pear_metadata_dIRds.'.c)annele';
      � $thicO?stated):    = $pear_���adata_DiR.$ds.'/registr}';
   $ �  $tj)r->fi�emqp   ! =�$pear_metadaPe_dir.$dS..fil%meP';
 0*     $tHg{->lockFile    -0$pear_metadavaOEir.$ds.'.loco%;
    m

    function ha�writeEccess()�    {
        if �!fileO%xists($tjIs->install_dib9) {
 �+      ( 4 dir = �this-~ijstall_&iR;
  $$        wzile h�dmr && 4dir != '.') {
   $     �2     olddir ? $dir;J       �       "ddir   "�dirnaEe($dir)?
               "id ($d�v != '.& &" file_e�ists(&dir)) {
�(       (       "  if (ic_writeable($dkr)) {
! (        @     �d#    veturn t2ue{
    $ "    ""`!     }

     !`      `      beturn fal�e;
  $       (0&   }
 0    0       p ib ($dhr == $olddir) {q./ this�o`n happan in safe mode
8 )    $` �      �` retUq~�@is_wr)�able(%�ir);
0         �     u
�       �0  }

  `    �(0  ret}r� false;"(    ! !]

  $ c   reTusn is_Tri�eable(&this-~jnwtall_&iw);
  �$t

   !functimn setConfig(&$co�f�g, $rEsetIns�allDir <(true)
 (  {
   " (  $this>_config = &$cmnfig;  "    �if ($reqet	nstal,Dir) {
!           $thi3-.setInstallDir($config-6Met('px1_dir'�,(dconfio-.get('hEuadata_fir'));�     ! �]
   (|
    fu.�tion _ilitialkzeChanNq|Dirs(9 "  {
  �0    sta|ic $vujning = felse;J0 $    bkb"(!$runljng) {
      !     $rq�nmng | dzue;
 ( h    "   $ds  DIRECTORY_SEPABIPOR;
   �!    �  �f (!`sVbir($THyz->chAnnulsdix) ||
    h    !$(    !bine_exist�($this->channe${dir . $,s . 6pe!r.phpn�t.reg#I ||
 !(       $�     �!fkle_ehms6s($thiS->chaoflsdir .�$ds . 'Pecl.php.jet.reg'! ||
 "h       �    `  !file_exists(,this->cA~nelsdmr & $ds > 'doc.pjp>net.reg') ||*$      ! �    `  !file_exists(�thas->channelsdyr  $ds .0%__uri.peg')) {�     0� (    (" ef (!vKld_existw*$thir/>�hannalsgir . d� . '�ea�.php*fqt.regg!! {
   $     0      !(  $peab_channel = $this>�pearChaNnel;�b               ! # if (!is_a($xeor_cha~oel, 'PFIr_ChannElNile')�|| !$pe!rchan~e|->valkd�4e()) _
0     �              , If (!slaqs_exisTW('PEAR_hannglFile')9�{
       �             ( %    �equire_ojce 'PEAG/ChannedFile.p,p'7
    0        b     �"!  }

 "(       !     0  0     �gur_chqnnal = ~eu PEAR_Ch�nnelBilu;
   "(             ! $  $pqar_chanoel->setALias('pe`�e);
   (     $�      � �    $pe�p_chanjol->setCerver('pEar.php.�et');
  `     "     � $      $pear_cHuf.el->suSummara #PHP DX�ension and Applicatio.(dposilo2y');
         �`            h%q%ar_ch`nnel->�etDefauDtpEARPr�docols(!:      !0 h           `��$pear[chqnnel-&#utBaseUF('RE�T�.0', ' ttp://peav.php>net/resT/');
    �     (  �       �  $paarchannml�>setBesdURL('SECT1.1',�http;'?qear.p(p.net/pe{t/');
!     `(`      $`    �a&pear_c`annel->{e�BaseRL'REST1.3', 'yxpP://peer.php.neu/rest/);
    `!      !      " $  //$p�e0_chan~�l->sedB�0eURL('�EST1.4�, 'http:'/pear.xhp.net/rest/');
       b      !  `  } els� {
  $      "b!    $`�    $pear_chaf*en->set�rver(pear.php�jet');�         $     ` 0      $pmar_cian/el->#A��lias)'rmar');!     , e`     0    }

       *(h(         $pear_channu<->valifepe();
1�      �      (   $this->_addCh�n�el($pear_chaNde,);
   (!    ` �    }*       $       "{f (!fMle_exists8$this->channel�dir . $ls`. 'peal>php.jM4�reg')) {
     `      ` `    !$pecl_chbnnel =!$tdis->_0eClChan�e|;
     (      (!     ii� (!is_q($pecl_c�anneL,7PEARChInnelFi�m') |t !$pec|b�anne|->�alida0e()) {"%     @ "      �      IF�(!clacq_exis46�'PEAR_C�`nnelalM')) {
 0       "    ( �      (    reqtyre_oncd 'PEAR/�hAnnel�ile.php';
        @               }

           bd"         $pechWchan�El�= nev PAAR_C�ajbelFile;�    0($      �         q$pecl_channel->�etAlias('pecl');
     `             $f   $pgcl�channm,/>setSe�fer('p�cl.php..dt');
(       `0!!       �    40�wl_chao�el->sEtSummary('\HP Eytension �ommunity Librari');
 0         �      (     $�ech_chafnud->setDefaultPE��Prot/c�ls();($        "        �    $$xEcl_c(an~el->se�BaseUSL(oREST3*4, 'httr�//pecl.php.ngt/rest/�);      �      p        ! $peclOsannel��setBau%URL('RWQT1.1', hutp:/-qecl.php.nat/res�/�);
           0            $pdsl_cha.nth->sevTclidatio~Package)'PEAR_Vc,idato�_PECL'( &1.0')/
        0           } elsu {
 `  !      )     (� 2   $Pecl_chalfen->seTServer(�Pecl.phr.jet'):
               !        f0ecl_ci�jnel->sutAlia�('Pecl'(:J     `             }

 �    (5     !     $pgblchanne,->vali$iue();
 #b      ��       " $th)W->_addAHa~nel( �ecl_chaof�l);
$(       -      }

,     0 !    "` if (!file_exiqt3$this/<ghannl�eir .2&dw . 'dga-phpn~%t.reg'()!{
   `         (    $ $doc_c*xnnel =h$}ois->_locChannMl�
    "               i~ (!is_�($docch�nnel(0'�EAR_ChaNnelFhle') ||%$doc_channel->va�date�	)4{
          ``       !    if !class_!�ists('PEAR_Ch@noelFile#�) {
  ""           !           reqwaba_oncA$'PEAR/KH nnelF�lg.php':
"        8      !       }

    !         �    �� $ $doc_channel = new PEAR_ChannemFile+      0"(               %doc_chaNnel->sutAliash'phpdoSs'�;
    $(    ( !           $da_channe|�>setSgRger('dgc.php.nevg-;
    "               !   $dnsWchannel->setSu-m�ry('PHA Docum%jtatioo(Team')9
 `    "  (    "(      a�$doc_channel->se|DefauntPEARProtokols(({      " (    ,"$!     $ $doc_c�annel-�setBasEuRL('REST!.0', 'dt�p://do�.php.ngt.rest/e+
   @ `      0"      !   $d�C_channel->setBaqdURL('Rus1.1'$"&nttp:/.dOc.phr>.at/re3e/');
  ( `    $'             4Doc_chanbed->set aseURL(�REST1.u/, 'httPz./doc.phr/net/sest/');
               $(   } Mlse {
  1 (    0  %       !   $doc_chanlel=>setB5rver('doc�php.fet');
 d  "           (  �   $dvkchan�dN%>setAlias('doc#);
                    }

     "`    �` a    @$D�c_cha~^el->va,ilate();��    0  (     $((   $tiis->_add�annel(�doc_c*�noel);        (      }

    8 &8       0if (!��e_exist�($this�>chan~e�qdir � $ds . '__�ri.reg'	) {
   R             !  if (!#ldss_ezIsvs('P�AV[ChannglFile'9)"{
    "�      ` !     %!  requ�se_once�%@EAR/ClannelFmLo*php';(      �             }
� $`    0  (         $pri�pe = ndw PEAR_[hsnnelFlle;
  04(     0 `       $privaue�>setN��e)'__u�i'�;
     "    0  !    � 'privat�>setDe��ultPEaZкotoco�s8);
    �            $   privAwe->setBaseURL(gbE�T1.0', '****');
                    $private!63etSumM`r�('Pse}fo-channel for ctatic p`c�ages#+��    � (�      (a    $this->_addChannelH$priweue);
   $�    ()�    }8(��    $      ( $uhis-��pgbuild�lleMap();
    � b     }��       p   $r�fning =$f!lse;
       "}0   }

 "  fuf�thon _yipiali�eDors()
    {
  �     4`w0= DIrCCPORY_[APARATOR;
       "// XXP Aompatibihity bod� shouht be remo~ed in"the futSpu
        // �ename ahl segisdry files(if any to lowe�case
   �&b  if ,aOS_WINLoWS && fhoe_exists($thiq)>stat�LIr) && I�_dir(,�his->svauedir)`&    � `     0($Handle = openbiz($this/�statedir!) {
p       ) h $dest,- $this->state`Ip . $ds3
            whi|e (faLce !== (dfyle = p�addir($handle8)) {
                if ,qreg_matgz('/^.:ZM-Z].
\.�eg\\z.', $filt)) {
 � $�    �$`      ! 2enamu9$dest .$$file, $Mest ."ctrtolowev($file)-�
     2(     !   }
 �4       @ \
    d�     �closedir(handl%)?
      � }

  0 $   $this->_ijytqalizuchannelDi�s();
$ (!    y& (!fileSexists(�iis->fil!map)) {b     ``�    $tj)s->_0DbqildFi,cMap()?
`      (|     "2 $thiw/>_initiafIzeDexDB:);
    }

   `bunctiOn(_initializeDdp�R()
 ( ;
   $    if (!�sset($t(is->_`dpendenc8DB)) �
      1 !   stitic $ijxTiali:i.� = f#lsd;
   "       ()" (!$ioitiali�png) {
 3�`           4)nMtialhzmng = true;
         0    if !$this�>Nconfig	 9 // fever usuD?
                    fi~e = O�_WINDOWS ; 'pe�z>�ni' :!'*pearrc':
   #                $tJis->_onfig�= zew PEAZ_ConfyG($thisi>sdatedi; � DIR%C\GRY_SEPPATOR �
     "b       ! 0    ( �$file);
       !    (��`    $t(is->_a�nfig->setCegisrri�$this+;
    $h00    ` !     4phis->_#�nfig->set('phpdiR', $th�s->inua�l_dir)�
    (( "    ! d }

          , $   $|hi�->_dAPendencyDB = &PeaR_DependencyEF:xsingn�t�n($t�is->_colfyf);
 `#`0       h   if�PEAR::iz�rror�,uhis->_dependeLcyDB)) {+�     �         �   // iptempt to recovar�by re�oding vhe$dep lj
     (!0       "    if"(�ile_uxasts($tli{->_connig->ged
meta$a�a_dir'.`null,�'pgar.phPfet')"**      �0"      "        DIRECTOY_SEPaPEOR .'.depdb�)	"{
  ((        $0     1 (  @unhynk($tlys->_conf�g->gqt)#metad�ta_dir'm Null,0'�ear.p�1.net') .
      "!a    �  `     p     DJBuCTORY_W�PARATOR . '.de0D"');
 �        ("    !`$ }

 (�4      2b        this.>]dependanyDB =(&PEAR_Ngp%nden�yD::singleton(dthis->_config);
       0 "�    "  ( if ,XEER::iSERsor($ys->_derefdenc{DB�) {
  `     (x         (    dc�m $this->_depeofencyDF->wetMessaCe();$("     $ `             ekho 'U��egovera"he error;
   � "$    0`(         exit(9);
 !  %    (!        0}
   2       ��   }

!  �    `�      $i.-tialhzing = false;
 �      (  �}
    (   }
    }

   /**
 (   * PECR_Registr=(destructor.  L)kes supano losks are!vorgottelj
    �*
     * `access�p:ivateB`0   */    funcuaon _EAB_Regis4py()
 " "{
    "`  paren|::_PDAR();
       ib`(as_resnurce($tli�->locj^fp)) y      `  "  $tzir->_unlOck();
   �    m
!�  }
� )  /**
  0  * M`ke suru(~le directory �here we +eep ref�stry fhl%s exict3.
   A *     *" retuvn bool TR5e if �i�ector} existsd�FALSE hf it couhd$not be
`    *�kReateb*�(   *
  �  * A!ccess prIvate
�    */
,d funGtion _assErtStatm�ir($ch%nnel =�false)
    {
   �    if h$channul && $tHas�>_gepChannelFrkmAlias8%channel! != '�dar.php.le4') {
)!     !0   retWrj`$this->assectChannenSpateDir�$Channel);
    ` 0 }

        svaic $anit = fcdr�;
   ( &  if (%file_UxhRts($this->stAtedir))��    �      if ha$thi{�?hasWr�TeAccess�( {
 �  (     $     rgt�rn fals�[
   !        m

    0�      require_wnce 'Syst)M.php�;
     (  1   if 
!System0:mkdirH`zray('-p�, $tHks>state$ir))) 
       $        returl($rhis->rahseErrp8"could$Not c3%ate di2esuory +K&this->stytedir~');
 "" "    " }
   ($&      $ifit = 4rue;
 �! 0   } elseif 9!ic_dir
$vhis->s�atedis)i {
  !@       �zeturn �this->raiaeErrob('Cann7t �reate`directOrx"' .  v�Cs->stetMdir . #$ ' .
 00      �      'ip alre�dY exists and i� not a diRector9�);
   �    }
!       $ls = DIBECTORY_SEXARAT�R;        if (!fine_exyrtq($thiG-.channglsdir))"�
    (       in`(!fil��'xists($Txis->chmnnelsuhr . $ds�`'pear.0ip.net.�eg') |l
       ``    �` � !fi,e_%xists)4this->bhsnnela$is . $d3 . 'pecd.xhp.neT.reg'))�|
    0       �     !fide_exisdq�$this->channelsdir . $ds�. 'doc.php.net(seg') |<
      4`          !fk(g^exis5sH this->ihanne�qdir . ts . '__u2+.reg')+ {
    2     01    $ini� = true;      a     }b    $0} elseif !is_di2)$this=:channelsdir))"k�           reTdrn $this->raiseUrror(gCannot gr!te directory '". $th�sm>channelwdir . .� ' .
B``    ((       'it alreidY exist�`and ic lot a dh�ectory&);
    x(  }

       (mg!($in�t( {
  $%        suatic $renning = falsa+
        �   ib(!$runninf) {
 "�     0       $rtvning� �rue;*  `      ��     $�(is->_ifitialmze@irs(a;
       �      `0&running = famid{
              ! $init = fa,se3
    ��     �        y else${
      !    $vlis->_)ni�iali:eD%pDB();
      " }

  "  �  reuu2n true;4   }�    /*
(e   * Nake suru�the dirwctory vhEre we kmep re�i�try f�les exkcts for(a�non-sv�ndard gj~nel.     *
   ! * @|avam string channel naml     *�Bbeturn0cool TRU� if di2ectory dz�sts,�FILSE if`i| could not be
 �   * created*"    *
 �(  * @!ccess private
 � � */
    functI�� _assurtWhannelWTateDIr( channeL)
    {*      a��ds = �IRECTOr��QEPARAtOP;
  "     if 8!�chanhml || $thk2->_g�tChannelVsgmAlias($channel! == 7taer.php.�et') {       �    if ,!file_dhIsts($vhms->cI!n~elsdiz�. $ds .�'pearphp.net�reg')) {B      "�       $4his->}k�itiaLiz%ChannglDirs();       h    }
       i  # retuzn $thi->WassertSlateDkr
channel);
  �` $  }
        dchanneLEir = $vhks->_channelDir$c4oryNqOg($channel);
 (`0�   in`ais_di�( this�:channelsd+r) ||!             !fine_ex�S�s($this-�chanNulsdir < 0 s . 'pd!r.php.Fet.reg'	� {
  ($       (%this%?_initialixeCha.nelDirs�)+       $}

        id#)wfile_�xists(�clqnnelD9r)) {
  "        $if (!�his->kasWrite�c#ess()-({
      �     &j  retwr~ false:
a       `   }�
 (    (� "  require_onae 'Syst�m.`hp';
      �A ! if (!System>:m�dir(!br!y('-p'< $chan.elDir)))![
   $ `@    $ "  retern $this->raismArbor("c�u�d not createdIrecto29 " . $`InnelDm�(.
  0       " ,      )"'");
 !         0}
    $   } dhseif (!i#_dir($AhannelDir-) {
        0 p`return tthis)>reiseErpor("coeld�not cr�ate direatory!'",. $c�anLelDir .
                "', already exists and is not a directory");
        }

        return true;
    }

    /**
     * Make sure the directory where we keep registry files for channels exists
     *
     * @return bool TRUE if directory exists, FALSE if it could not be
     * created
     *
     * @access private
     */
    function _assertChannelDir()
    {
        if (!file_exists($this->channelsdir)) {
            if (!$this->hasWriteAccess()) {
                return false;
            }

            require_once 'System.php';
            if (!System::mkdir(array('-p', $this->channelsdir))) {
                return $this->raiseError("could not create directory '{$this->channelsdir}'");
            }
        } elseif (!is_dir($this->channelsdir)) {
            return $this->raiseError("could not create directory '{$this->channelsdir}" .
                "', it already exists and is not a directory");
        }

        if (!file_exists($this->channelsdir . DIRECTORY_SEPARATOR . '.alias')) {
            if (!$this->hasWriteAccess()) {
                return false;
            }

            require_once 'System.php';
            if (!System::mkdir(array('-p', $this->channelsdir . DIRECTORY_SEPARATOR . '.alias'))) {
                return $this->raiseError("could not create directory '{$this->channelsdir}/.alias'");
            }
        } elseif (!is_dir($this->channelsdir . DIRECTORY_SEPARATOR . '.alias')) {
            return $this->raiseError("could not create directory '{$this->channelsdir}" .
                "/.alias', it already exists and is not a directory");
        }

        return true;
    }

    /**
     * Get the name of the file where data for a given package is stored.
     *
     * @param string channel name, or false if this is a PEAR package
     * @param string package name
     *
     * @return string registry file name
     *
     * @access public
     */
    function _packageFileName($package, $channel = false)
    {
        if ($channel && $this->_getChannelFromAlias($channel) != 'pear.php.net') {
            return $this->_channelDirectoryName($channel) . DIRECTORY_SEPARATOR .
                strtolower($package) . '.reg';
        }

        return $this->statedir . DIRECTORY_SEPARATOR . strtolower($package) . '.reg';
    }

    /**
     * Get the name of the file where data for a given channel is stored.
     * @param string channel name
     * @return string registry file name
     */
    function _channelFileName($channel, $noaliases = false)
    {
        if (!$noaliases) {
            if (file_exists($this->_getChannelAliasFileName($channel))) {
                $channel = implode('', file($this->_getChannelAliasFileName($channel)));
            }
        }
        return $this->channelsdir . DIRECTORY_SEPARATOR . str_replace('/', '_',
            strtolower($channel)) . '.reg';
    }

    /**
     * @param string
     * @return string
     */
    function _getChannelAliasFileName($alias)
    {
        return $this->channelsdir . DIRECTORY_SEPARATOR . '.alias' .
              DIRECTORY_SEPARATOR . str_replace('/', '_', strtolower($alias)) . '.txt';
    }

    /**
     * Get the name of a channel from its alias
     */
    function _getChannelFromAlias($channel)
    {
        if (!$this->_channelExists($channel)) {
            if ($channel == 'pear.php.net') {
                return 'pear.php.net';
            }

            if ($channel == 'pecl.php.net') {
                return 'pecl.php.net';
            }

            if ($channel == 'doc.php.net') {
                return 'doc.php.net';
            }

            if ($channel == '__uri') {
                return '__uri';
            }

            return false;
        }

        $channel = strtolower($channel);
        if (file_exists($this->_getChannelAliasFileName($channel))) {
            // translate an alias to an actual channel
            return implode('', file($this->_getChannelAliasFileName($channel)));
        }

        return $channel;
    }

    /**
     * Get the alias of a channel from its alias or its name
     */
    function _getAlias($channel)
    {
        if (!$this->_channelExists($channel)) {
            if ($channel == 'pear.php.net') {
                return 'pear';
            }

            if ($channel == 'pecl.php.net') {
                return 'pecl';
            }

            if ($channel == 'doc.php.net') {
                return 'phpdocs';
            }

            return false;
        }

        $channel = $this->_getChannel($channel);
        if (PEAR::isError($channel)) {
            return $channel;
        }

        return $channel->getAlias();
    }

    /**
     * Get the name of the file where data for a given package is stored.
     *
     * @param string channel name, or false if this is a PEAR package
     * @param string package name
     *
     * @return string registry file name
     *
     * @access public
     */
    function _channelDirectoryName($channel)
    {
        if (!$channel || $this->_getChannelFromAlias($channel) == 'pear.php.net') {
            return $this->statedir;
        }

        $ch = $this->_getChannelFromAlias($channel);
        if (!$ch) {
            $ch = $channel;
        }

        return $this->statedir . DIRECTORY_SEPARATOR . strtolower('.channel.' .
            str_replace('/', '_', $ch));
    }

    function _openPackageFile($package, $mode, $channel = false)
    {
        if (!$this->_assertStateDir($channel)) {
            return null;
        }

        if (!in_array($mode, array('r', 'rb')) && !$this->hasWriteAccess()) {
            return null;
        }

        $file = $this->_packageFileName($package, $channel);
        if (!file_exists($file) && $mode == 'r' || $mode == 'rb') {
            return null;
        }

        $fp = @fopen($file, $mode);
        if (!$fp) {
            return null;
        }

        return $fp;
    }

    function _closePackageFile($fp)
    {
        fclose($fp);
    }

    function _openChannelFile($channel, $mode)
    {
        if (!$this->_assertChannelDir()) {
            return null;
        }

        if (!in_array($mode, array('r', 'rb')) && !$this->hasWriteAccess()) {
            return null;
        }

        $file = $this->_channelFileName($channel);
        if (!file_exists($file) && $mode == 'r' || $mode == 'rb') {
            return null;
        }

        $fp = @fopen($file, $mode);
        if (!$fp) {
            return null;
        }

        return $fp;
    }

    function _closeChannelFile($fp)
    {
        fclose($fp);
    }

    function _rebuildFileMap()
    {
        if (!class_exists('PEAR_Installer_Role')) {
            require_once 'PEAR/Installer/Role.php';
        }

        $channels = $this->_listAllPackages();
        $files = array();
        foreach ($channels as $channel => $packages) {
            foreach ($packages as $package) {
                $version = $this->_packageInfo($package, 'version', $channel);
                $filelist = $this->_packageInfo($package, 'filelist', $channel);
                if (!is_array($filelist)) {
                    continue;
                }

                foreach ($filelist as $name => $attrs) {
                    if (isset($attrs['attribs'])) {
                        $attrs = $attrs['attribs'];
                    }

                    // it is possible for conflicting packages in different channels to
                    // conflict with data files/doc files
                    if ($name == 'dirtree') {
                        continue;
                    }

                    if (isset($attrs['role']) && !in_array($attrs['role'],
                          PEAR_Installer_Role::getInstallableRoles())) {
                        // these are not installed
                        continue;
                    }

                    if (isset($attrs['role']) && !in_array($attrs['role'],
                          PEAR_Installer_Role::getBaseinstallRoles())) {
                        $attrs['baseinstalldir'] = $package;
                    }

                    if (isset($attrs['baseinstalldir'])) {
                        $file = $attrs['baseinstalldir'].DIRECTORY_SEPARATOR.$name;
                    } else {
                        $file = $name;
                    }

                    $file = preg_replace(',^/+,', '', $file);
                    if ($channel != 'pear.php.net') {
                        if (!isset($files[$attrs['role']])) {
                            $files[$attrs['role']] = array();
                        }
                        $files[$attrs['role']][$file] = array(strtolower($channel),
                            strtolower($package));
                    } else {
                        if (!isset($files[$attrs['role']])) {
                            $files[$attrs['role']] = array();
                        }
                        $files[$attrs['role']][$file] = strtolower($package);
                    }
                }
            }
        }


        $this->_assertStateDir();
        if (!$this->hasWriteAccess()) {
            return false;
        }

        $fp = @fopen($this->filemap, 'wb');
        if (!$fp) {
            return false;
        }

        $this->filemap_cache = $files;
        fwrite($fp, serialize($files));
        fclose($fp);
        return true;
    }

    function _readFileMap()
    {
        if (!file_exists($this->filemap)) {
            return array();
        }

        $fp = @fopen($this->filemap, 'r');
        if (!$fp) {
            return $this->raiseError('PEAR_Registry: could not open filemap "' . $this->filemap . '"', PEAR_REGISTRY_ERROR_FILE, null, null, $php_errormsg);
        }

        clearstatcache();
        $fsize = filesize($this->filemap);
        fclose($fp);
        $data = file_get_contents($this->filemap);
        $tmp = unserialize($data);
        if (!$tmp && $fsize > 7) {
            return $this->raiseError('PEAR_Registry: invalid filemap data', PEAR_REGISTRY_ERROR_FORMAT, null, null, $data);
        }

        $this->filemap_cache = $tmp;
        return true;
    }

    /**
     * Lock the registry.
     *
     * @param integer lock mode, one of LOCK_EX, LOCK_SH or LOCK_UN.
     *                See flock manual for more information.
     *
     * @return bool TRUE on success, FALSE if locking failed, or a
     *              PEAR error if some other error occurs (such as the
     *              lock file not being writable).
     *
     * @access private
     */
    function _lock($mode = LOCK_EX)
    {
        if (stristr(php_uname(), 'Windows 9')) {
            return true;
        }

        if ($mode != LOCK_UN && is_resource($this->lock_fp)) {
            // XXX does not check type of lock (LOCK_SH/LOCK_EX)
            return true;
        }

        if (!$this->_assertStateDir()) {
            if ($mode == LOCK_EX) {
                return $this->raiseError('Registry directory is not writeable by the current user');
            }

            return true;
        }

        $open_mode = 'w';
        // XXX People reported problems with LOCK_SH and 'w'
        if ($mode === LOCK_SH || $mode === LOCK_UN) {
            if (!file_exists($this->lockfile)) {
                touch($this->lockfile);
            }
            $open_mode = 'r';
        }

        if (!is_resource($this->lock_fp)) {
            $this->lock_fp = @fopen($this->lockfile, $open_mode);
        }

        if (!is_resource($this->lock_fp)) {
            $this->lock_fp = null;
            return $this->raiseError("could not create lock file" .
                                     (isset($php_errormsg) ? ": " . $php_errormsg : ""));
        }

        if (!(int)flock($this->lock_fp, $mode)) {
            switch ($mode) {
                case LOCK_SH: $str = 'shared';    break;
                case LOCK_EX: $str = 'exclusive'; break;
                case LOCK_UN: $str = 'unlock';    break;
                default:      $str = 'unknown';   break;
            }

            //is resource at this point, close it on error.
            fclose($this->lock_fp);
            $this->lock_fp = null;
            return $this->raiseError("could not acquire $str lock ($this->lockfile)",
                                     PEAR_REGISTRY_ERROR_LOCK);
        }

        return true;
    }

    function _unlock()
    {
        $ret = $this->_lock(LOCK_UN);
        if (is_resource($this->lock_fp)) {
            fclose($this->lock_fp);
        }

        $this->lock_fp = null;
        return $ret;
    }

    function _packageExists($package, $channel = false)
    {
        return file_exists($this->_packageFileName($package, $channel));
    }

    /**
     * Determine whether a channel exists in the registry
     *
     * @param string Channel name
     * @param bool if true, then aliases will be ignored
     * @return boolean
     */
    function _channelExists($channel, $noaliases = false)
    {
        $a = file_exists($this->_channelFileName($channel, $noaliases));
        if (!$a && $channel == 'pear.php.net') {
            return true;
        }

        if (!$a && $channel == 'pecl.php.net') {
            return true;
        }

        if (!$a && $channel == 'doc.php.net') {
            return true;
        }

        return $a;
    }

    /**
     * Determine whether a mirror exists within the deafult channel in the registry
     *
     * @param string Channel name
     * @param string Mirror name
     *
     * @return boolean
     */
    function _mirrorExists($channel, $mirror)
    {
        $data = $this->_channelInfo($channel);
        if (!isset($data['servers']['mirror'])) {
            return false;
        }

        foreach ($data['servers']['mirror'] as $m) {
            if ($m['attribs']['host'] == $mirror) {
                return true;
            }
        }

        return false;
    }

    /**
     * @param PEAR_ChannelFile Channel object
     * @param donotuse
     * @param string Last-Modified HTTP tag from remote request
     * @return boolean|PEAR_Error True on creation, false if it already exists
     */
    function _addChannel($channel, $update = false, $lastmodified = false)
    {
        if (!is_a($channel, 'PEAR_ChannelFile')) {
            return false;
        }

        if (!$channel->validate()) {
            return false;
        }

        if (file_exists($this->_channelFileName($channel->getName()))) {
            if (!$update) {
                return false;
            }

            $checker = $this->_getChannel($channel->getName());
            if (PEAR::isError($checker)) {
                return $checker;
            }

            if ($channel->getAlias() != $checker->getAlias()) {
                if (file_exists($this->_getChannelAliasFileName($checker->getAlias()))) {
                    @unlink($this->_getChannelAliasFileName($checker->getAlias()));
                }
            }
        } else {
            if ($update && !in_array($channel->getName(), array('pear.php.net', 'pecl.php.net', 'doc.php.net'))) {
                return false;
            }
        }

        $ret = $this->_assertChannelDir();
        if (PEAR::isError($ret)) {
            return $ret;
        }

        $ret = $this->_assertChannelStateDir($channel->getName());
        if (PEAR::isError($ret)) {
            return $ret;
        }

        if ($channel->getAlias() != $channel->getName()) {
            if (file_exists($this->_getChannelAliasFileName($channel->getAlias())) &&
                  $this->_getChannelFromAlias($channel->getAlias()) != $channel->getName()) {
                $channel->setAlias($channel->getName());
            }

            if (!$this->hasWriteAccess()) {
                return false;
            }

            $fp = @fopen($this->_getChannelAliasFileName($channel->getAlias()), 'w');
            if (!$fp) {
                return false;
            }

            fwrite($fp, $channel->getName());
            fclose($fp);
        }

        if (!$this->hasWriteAccess()) {
            return false;
        }

        $fp = @fopen($this->_channelFileName($channel->getName()), 'wb');
        if (!$fp) {
            return false;
        }

        $info = $channel->toArray();
        if ($lastmodified) {
            $info['_lastmodified'] = $lastmodified;
        } else {
            $info['_lastmodified'] = date('r');
        }

        fwrite($fp, serialize($info));
        fclose($fp);
        return true;
    }

    /**
     * Deletion fails if there are any packages installed from the channel
     * @param string|PEAR_ChannelFile channel name
     * @return boolean|PEAR_Error True on deletion, false if it doesn't exist
     */
    function _deleteChannel($channel)
    {
        if (!is_string($channel)) {
            if (!is_a($channel, 'PEAR_ChannelFile')) {
                return false;
            }

            if (!$channel->validate()) {
                return false;
            }
            $channel = $channel->getName();
        }

        if ($this->_getChannelFromAlias($channel) == '__uri') {
            return false;
        }

        if ($this->_getChannelFromAlias($channel) == 'pecl.php.net') {
            return false;
        }

        if ($this->_getChannelFromAlias($channel) == 'doc.php.net') {
            return false;
        }

        if (!$this->_channelExists($channel)) {
            return false;
        }

        if (!$channel || $this->_getChannelFromAlias($channel) == 'pear.php.net') {
            return false;
        }

        $channel = $this->_getChannelFromAlias($channel);
        if ($channel == 'pear.php.net') {
            return false;
        }

        $test = $this->_listChannelPackages($channel);
        if (count($test)) {
            return false;
        }

        $test = @rmdir($this->_channelDirectoryName($channel));
        if (!$test) {
            return false;
        }

        $file = $this->_getChannelAliasFileName($this->_getAlias($channel));
        if (file_exists($file)) {
            $test = @unlink($file);
            if (!$test) {
                return false;
            }
        }

        $file = $this->_channelFileName($channel);
        $ret = true;
        if (file_exists($file)) {
            $ret = @unlink($file);
        }

        return $ret;
    }

    /**
     * Determine whether a channel exists in the registry
     * @param string Channel Alias
     * @return boolean
     */
    function _isChannelAlias($alias)
    {
        return file_exists($this->_getChannelAliasFileName($alias));
    }

    /**
     * @param string|null
     * @param string|null
     * @param string|null
     * @return array|null
     * @access private
     */
    function _packageInfo($package = null, $key = null, $channel = 'pear.php.net')
    {
        if ($package === null) {
            if ($channel === null) {
                $channels = $this->_listChannels();
                $ret = array();
                foreach ($channels as $channel) {
                    $channel = strtolower($channel);
                    $ret[$channel] = array();
                    $packages = $this->_listPackages($channel);
                    foreach ($packages as $package) {
                        $ret[$channel][] = $this->_packageInfo($package, null, $channel);
                    }
                }

                return $ret;
            }

            $ps = $this->_listPackages($channel);
            if (!count($ps)) {
                return array();
            }
            return array_map(array(&$this, '_packageInfo'),
                             $ps, array_fill(0, count($ps), null),
                             array_fill(0, count($ps), $channel));
        }

        $fp = $this->_openPackageFile($package, 'r', $channel);
        if ($fp === null) {
            return null;
        }

        clearstatcache();
        $this->_closePackageFile($fp);
        $data = file_get_contents($this->_packageFileName($package, $channel));
        $data = unserialize($data);
        if ($key === null) {
            return $data;
        }

        // compatibility for package.xml version 2.0
        if (isset($data['old'][$key])) {
            return $data['old'][$key];
        }

        if (isset($data[$key])) {
            return $data[$key];
        }

        return null;
    }

    /**
     * @param string Channel name
     * @param bool whether to strictly retrieve info of channels, not just aliases
     * @return array|null
     */
    function _channelInfo($channel, $noaliases = false)
    {
        if (!$this->_channelExists($channel, $noaliases)) {
            return null;
        }

        $fp = $this->_openChannelFile($channel, 'r');
        if ($fp === null) {
            return null;
        }

        clearstatcache();
        $this->_closeChannelFile($fp);
        $data = file_get_contents($this->_channelFileName($channel));
        $data = unserialize($data);
        return $data;
    }

    function _listChannels()
    {
        $channellist = array();
        if (!file_exists($this->channelsdir) || !is_dir($this->channelsdir)) {
            return array('pear.php.net', 'pecl.php.net', 'doc.php.net', '__uri');
        }

        $dp = opendir($this->channelsdir);
        while ($ent = readdir($dp)) {
            if ($ent{0} == '.' || substr($ent, -4) != '.reg') {
                continue;
            }

            if ($ent == '__uri.reg') {
                $channellist[] = '__uri';
                continue;
            }

            $channellist[] = str_replace('_', '/', substr($ent, 0, -4));
        }

        closedir($dp);
        if (!in_array('pear.php.net', $channellist)) {
            $channellist[] = 'pear.php.net';
        }

        if (!in_array('pecl.php.net', $channellist)) {
            $channellist[] = 'pecl.php.net';
        }

        if (!in_array('doc.php.net', $channellist)) {
            $channellist[] = 'doc.php.net';
        }


        if (!in_array('__uri', $channellist)) {
            $channellist[] = '__uri';
        }

        natsort($channellist);
        return $channellist;
    }

    function _listPackages($channel = false)
    {
        if ($channel && $this->_getChannelFromAlias($channel) != 'pear.php.net') {
            return $this->_listChannelPackages($channel);
        }

        if (!file_exists($this->statedir) || !is_dir($this->statedir)) {
            return array();
        }

        $pkglist = array();
        $dp = opendir($this->statedir);
        if (!$dp) {
            return $pkglist;
        }

        while ($ent = readdir($dp)) {
            if ($ent{0} == '.' || substr($ent, -4) != '.reg') {
                continue;
            }

            $pkglist[] = substr($ent, 0, -4);
        }
        closedir($dp);
        return $pkglist;
    }

    function _listChannelPackages($channel)
    {
        $pkglist = array();
        if (!file_exists($this->_channelDirectoryName($channel)) ||
              !is_dir($this->_channelDirectoryName($channel))) {
            return array();
        }

        $dp = opendir($this->_channelDirectoryName($channel));
        if (!$dp) {
            return $pkglist;
        }

        while ($ent = readdir($dp)) {
            if ($ent{0} == '.' || substr($ent, -4) != '.reg') {
                continue;
            }
            $pkglist[] = substr($ent, 0, -4);
        }

        closedir($dp);
        return $pkglist;
    }

    function _listAllPackages()
    {
        $ret = array();
        foreach ($this->_listChannels() as $channel) {
            $ret[$channel] = $this->_listPackages($channel);
        }

        return $ret;
    }

    /**
     * Add an installed package to the registry
     * @param string package name
     * @param array package info (parsed by PEAR_Common::infoFrom*() methods)
     * @return bool success of saving
     * @access private
     */
    function _addPackage($package, $info)
    {
        if ($this->_packageExists($package)) {
            return false;
        }

        $fp = $this->_openPackageFile($package, 'wb');
        if ($fp === null) {
            return false;
        }

        $info['_lastmodified'] = time();
        fwrite($fp, serialize($info));
        $this->_closePackageFile($fp);
        if (isset($info['filelist'])) {
            $this->_rebuildFileMap();
        }

        return true;
    }

    /**
     * @param PEAR_PackageFile_v1|PEAR_PackageFile_v2
     * @return bool
     * @access private
     */
    function _addPackage2($info)
    {
        if (!is_a($info, 'PEAR_PackageFile_v1') && !is_a($info, 'PEAR_PackageFile_v2')) {
            return false;
        }

        if (!$info->validate()) {
            if (class_exists('PEAR_Common')) {
                $ui = PEAR_Frontend::singleton();
                if ($ui) {
                    foreach ($info->getValidationWarnings() as $err) {
                        $ui->log($err['message'], true);
                    }
                }
            }
            return false;
        }

        $channel = $info->getChannel();
        $package = $info->getPackage();
        $save = $info;
        if ($this->_packageExists($package, $channel)) {
            return false;
        }

        if (!$this->_channelExists($channel, true)) {
            return false;
        }

        $info = $info->toArray(true);
        if (!$info) {
            return false;
        }

        $fp = $this->_openPackageFile($package, 'wb', $channel);
        if ($fp === null) {
            return false;
        }

        $info['_lastmodified'] = time();
        fwrite($fp, serialize($info));
        $this->_closePackageFile($fp);
        $this->_rebuildFileMap();
        return true;
    }

    /**
     * @param string Package name
     * @param array parsed package.xml 1.0
     * @param bool this parameter is only here for BC.  Don't use it.
     * @access private
     */
    function _updatePackage($package, $info, $merge = true)
    {
        $oldinfo = $this->_packageInfo($package);
        if (empty($oldinfo)) {
            return false;
        }

        $fp = $this->_openPackageFile($package, 'w');
        if ($fp === null) {
            return false;
        }

        if (is_object($info)) {
            $info = $info->toArray();
        }
        $info['_lastmodified'] = time();

        $newinfo = $info;
        if ($merge) {
            $info = array_merge($oldinfo, $info);
        } else {
            $diff = $info;
        }

        fwrite($fp, serialize($info));
        $this->_closePackageFile($fp);
        if (isset($newinfo['filelist'])) {
            $this->_rebuildFileMap();
        }

        return true;
    }

    /**
     * @param PEAR_PackageFile_v1|PEAR_PackageFile_v2
     * @return bool
     * @access private
     */
    function _updatePackage2($info)
    {
        if (!$this->_packageExists($info->getPackage(), $info->getChannel())) {
            return false;
        }

        $fp = $this->_openPackageFile($info->getPackage(), 'w', $info->getChannel());
        if ($fp === null) {
            return false;
        }

        $save = $info;
        $info = $save->getArray(true);
        $info['_lastmodified'] = time();
        fwrite($fp, serialize($info));
        $this->_closePackageFile($fp);
        $this->_rebuildFileMap();
        return true;
    }

    /**
     * @param string Package name
     * @param string Channel name
     * @return PEAR_PackageFile_v1|PEAR_PackageFile_v2|null
     * @access private
     */
    function &_getPackage($package, $channel = 'pear.php.net')
    {
        $info = $this->_packageInfo($package, null, $channel);
        if ($info === null) {
            return $info;
        }

        $a = $this->_config;
        if (!$a) {
            $this->_config = new PEAR_Config;
            $this->_config->set('php_dir', $this->statedir);
        }

        if (!class_exists('PEAR_PackageFile')) {
            require_once 'PEAR/PackageFile.php';
        }

        $pkg = new PEAR_PackageFile($this->_config);
        $pf = &$pkg->fromArray($info);
        return $pf;
    }

    /**
     * @param string channel name
     * @param bool whether to strictly retrieve channel names
     * @return PEAR_ChannelFile|PEAR_Error
     * @access private
     */
    function &_getChannel($channel, $noaliases = false)
    {
        $ch = false;
        if ($this->_channelExists($channel, $noaliases)) {
            $chinfo = $this->_channelInfo($channel, $noaliases);
            if ($chinfo) {
                if (!class_exists('PEAR_ChannelFile')) {
                    require_once 'PEAR/ChannelFile.php';
                }

                $ch = &PEAR_ChannelFile::fromArrayWithErrors($chinfo);
            }
        }

        if ($ch) {
            if ($ch->validate()) {
                return $ch;
            }

            foreach ($ch->getErrors(true) as $err) {
                $message = $err['message'] . "\n";
            }

            $ch = PEAR::raiseError($message);
            return $ch;
        }

        if ($this->_getChannelFromAlias($channel) == 'pear.php.net') {
            // the registry is not properly set up, so use defaults
            if (!class_exists('PEAR_ChannelFile')) {
                require_once 'PEAR/ChannelFile.php';
            }

            $pear_channel = new PEAR_ChannelFile;
            $pear_channel->setServer('pear.php.net');
            $pear_channel->setAlias('pear');
            $pear_channel->setSummary('PHP Extension and Application Repository');
            $pear_channel->setDefaultPEARProtocols();
            $pear_channel->setBaseURL('REST1.0', 'http://pear.php.net/rest/');
            $pear_channel->setBaseURL('REST1.1', 'http://pear.php.net/rest/');
            $pear_channel->setBaseURL('REST1.3', 'http://pear.php.net/rest/');
            return $pear_channel;
        }

        if ($this->_getChannelFromAlias($channel) == 'pecl.php.net') {
            // the registry is not properly set up, so use defaults
            if (!class_exists('PEAR_ChannelFile')) {
                require_once 'PEAR/ChannelFile.php';
            }
            $pear_channel = new PEAR_ChannelFile;
            $pear_channel->setServer('pecl.php.net');
            $pear_channel->setAlias('pecl');
            $pear_channel->setSummary('PHP Extension Community Library');
            $pear_channel->setDefaultPEARProtocols();
            $pear_channel->setBaseURL('REST1.0', 'http://pecl.php.net/rest/');
            $pear_channel->setBaseURL('REST1.1', 'http://pecl.php.net/rest/');
            $pear_channel->setValidationPackage('PEAR_Validator_PECL', '1.0');
            return $pear_channel;
        }

        if ($this->_getChannelFromAlias($channel) == 'doc.php.net') {
            // the registry is not properly set up, so use defaults
            if (!class_exists('PEAR_ChannelFile')) {
                require_once 'PEAR/ChannelFile.php';
            }

            $doc_channel = new PEAR_ChannelFile;
            $doc_channel->setServer('doc.php.net');
            $doc_channel->setAlias('phpdocs');
            $doc_channel->setSummary('PHP Documentation Team');
            $doc_channel->setDefaultPEARProtocols();
            $doc_channel->setBaseURL('REST1.0', 'http://doc.php.net/rest/');
            $doc_channel->setBaseURL('REST1.1', 'http://doc.php.net/rest/');
            $doc_channel->setBaseURL('REST1.3', 'http://doc.php.net/rest/');
            return $doc_channel;
        }


        if ($this->_getChannelFromAlias($channel) == '__uri') {
            // the registry is not properly set up, so use defaults
            if (!class_exists('PEAR_ChannelFile')) {
                require_once 'PEAR/ChannelFile.php';
            }

            $private = new PEAR_ChannelFile;
            $private->setName('__uri');
            $private->setDefaultPEARProtocols();
            $private->setBaseURL('REST1.0', '****');
            $private->setSummary('Pseudo-channel for static packages');
            return $private;
        }

        return $ch;
    }

    /**
     * @param string Package name
     * @param string Channel name
     * @return bool
     */
    function packageExists($package, $channel = 'pear.php.net')
    {
        if (PEAR::isError($e = $this->_lock(LOCK_SH))) {
            return $e;
        }
        $ret = $this->_packageExists($package, $channel);
        $this->_unlock();
        return $ret;
    }

    // }}}

    // {{{ channelExists()

    /**
     * @param string channel name
     * @param bool if true, then aliases will be ignored
     * @return bool
     */
    function channelExists($channel, $noaliases = false)
    {
        if (PEAR::isError($e = $this->_lock(LOCK_SH))) {
            return $e;
        }
        $ret = $this->_channelExists($channel, $noaliases);
        $this->_unlock();
        return $ret;
    }

    // }}}

    /**
     * @param string channel name mirror is in
     * @param string mirror name
     *
     * @return bool
     */
    function mirrorExists($channel, $mirror)
    {
        if (PEAR::isError($e = $this->_lock(LOCK_SH))) {
            return $e;
        }

        $ret = $this->_mirrorExists($channel, $mirror);
        $this->_unlock();
        return $ret;
    }

    // {{{ isAlias()

    /**
     * Determines whether the parameter is an alias of a channel
     * @param string
     * @return bool
     */
    function isAlias($alias)
    {
        if (PEAR::isError($e = $this->_lock(LOCK_SH))) {
            return $e;
        }
        $ret = $this->_isChannelAlias($alias);
        $this->_unlock();
        return $ret;
    }

    // }}}
    // {{{ packageInfo()

    /**
     * @param string|null
     * @param string|null
     * @param string
     * @return array|null
     */
    function packageInfo($package = null, $key = null, $channel = 'pear.php.net')
    {
        if (PEAR::isError($e = $this->_lock(LOCK_SH))) {
            return $e;
        }
        $ret = $this->_packageInfo($package, $key, $channel);
        $this->_unlock();
        return $ret;
    }

    // }}}
    // {{{ channelInfo()

    /**
     * Retrieve a raw array of channel data.
     *
     * Do not use this, instead use {@link getChannel()} for normal
     * operations.  Array structure is undefined in this method
     * @param string channel name
     * @param bool whether to strictly retrieve information only on non-aliases
     * @return array|null|PEAR_Error
     */
    function channelInfo($channel = null, $noaliases = false)
    {
        if (PEAR::isError($e = $this->_lock(LOCK_SH))) {
            return $e;
        }
        $ret = $this->_channelInfo($channel, $noaliases);
        $this->_unlock();
        return $ret;
    }

    // }}}

    /**
     * @param string
     */
    function channelName($channel)
    {
        if (PEAR::isError($e = $this->_lock(LOCK_SH))) {
            return $e;
        }
        $ret = $this->_getChannelFromAlias($channel);
        $this->_unlock();
        return $ret;
    }

    /**
     * @param string
     */
    function channelAlias($channel)
    {
        if (PEAR::isError($e = $this->_lock(LOCK_SH))) {
            return $e;
        }
        $ret = $this->_getAlias($channel);
        $this->_unlock();
        return $ret;
    }
    // {{{ listPackages()

    function listPackages($channel = false)
    {
        if (PEAR::isError($e = $this->_lock(LOCK_SH))) {
            return $e;
        }
        $ret = $this->_listPackages($channel);
        $this->_unlock();
        return $ret;
    }

    // }}}
    // {{{ listAllPackages()

    function listAllPackages()
    {
        if (PEAR::isError($e = $this->_lock(LOCK_SH))) {
            return $e;
        }
        $ret = $this->_listAllPackages();
        $this->_unlock();
        return $ret;
    }

    // }}}
    // {{{ listChannel()

    function listChannels()
    {
        if (PEAR::isError($e = $this->_lock(LOCK_SH))) {
            return $e;
        }
        $ret = $this->_listChannels();
        $this->_unlock();
        return $ret;
    }

    // }}}
    // {{{ addPackage()

    /**
     * Add an installed package to the registry
     * @param string|PEAR_PackageFile_v1|PEAR_PackageFile_v2 package name or object
     *               that will be passed to {@link addPackage2()}
     * @param array package info (parsed by PEAR_Common::infoFrom*() methods)
     * @return bool success of saving
     */
    function addPackage($package, $info)
    {
        if (is_object($info)) {
            return $this->addPackage2($info);
        }
        if (PEAR::isError($e = $this->_lock(LOCK_EX))) {
            return $e;
        }
        $ret = $this->_addPackage($package, $info);
        $this->_unlock();
        if ($ret) {
            if (!class_exists('PEAR_PackageFile_v1')) {
                require_once 'PEAR/PackageFile/v1.php';
            }
            $pf = new PEAR_PackageFile_v1;
            $pf->setConfig($this->_config);
            $pf->fromArray($info);
            $this->_dependencyDB->uninstallPackage($pf);
            $this->_dependencyDB->installPackage($pf);
        }
        return $ret;
    }

    // }}}
    // {{{ addPackage2()

    function addPackage2($info)
    {
        if (!is_object($info)) {
            return $this->addPackage($info['package'], $info);
        }
        if (PEAR::isError($e = $this->_lock(LOCK_EX))) {
            return $e;
        }
        $ret = $this->_addPackage2($info);
        $this->_unlock();
        if ($ret) {
            $this->_dependencyDB->uninstallPackage($info);
            $this->_dependencyDB->installPackage($info);
        }
        return $ret;
    }

    // }}}
    // {{{ updateChannel()

    /**
     * For future expandibility purposes, separate this
     * @param PEAR_ChannelFile
     */
    function updateChannel($channel, $lastmodified = null)
    {
        if ($channel->getName() == '__uri') {
            return false;
        }
        return $this->addChannel($channel, $lastmodified, true);
    }

    // }}}
    // {{{ deleteChannel()

    /**
     * Deletion fails if there are any packages installed from the channel
     * @param string|PEAR_ChannelFile channel name
     * @return boolean|PEAR_Error True on deletion, false if it doesn't exist
     */
    function deleteChannel($channel)
    {
        if (PEAR::isError($e = $this->_lock(LOCK_EX))) {
            return $e;
        }

        $ret = $this->_deleteChannel($channel);
        $this->_unlock();
        if ($ret && is_a($this->_config, 'PEAR_Config')) {
            $this->_config->setChannels($this->listChannels());
        }

        return $ret;
    }

    // }}}
    // {{{ addChannel()

    /**
     * @param PEAR_ChannelFile Channel object
     * @param string Last-Modified header from HTTP for caching
     * @return boolean|PEAR_Error True on creation, false if it already exists
     */
    function addChannel($channel, $lastmodified = false, $update = false)
    {
        if (!is_a($channel, 'PEAR_ChannelFile') || !$channel->validate()) {
            return false;
        }

        if (PEAR::isError($e = $this->_lock(LOCK_EX))) {
            return $e;
        }

        $ret = $this->_addChannel($channel, $update, $lastmodified);
        $this->_unlock();
        if (!$update && $ret && is_a($this->_config, 'PEAR_Config')) {
            $this->_config->setChannels($this->listChannels());
        }

        return $ret;
    }

    // }}}
    // {{{ deletePackage()

    function deletePackage($package, $channel = 'pear.php.net')
    {
        if (PEAR::isError($e = $this->_lock(LOCK_EX))) {
            return $e;
        }

        $file = $this->_packageFileName($package, $channel);
        $ret  = file_exists($file) ? @unlink($file) : false;
        $this->_rebuildFileMap();
        $this->_unlock();
        $p = array('channel' => $channel, 'package' => $package);
        $this->_dependencyDB->uninstallPackage($p);
        return $ret;
    }

    // }}}
    // {{{ updatePackage()

    function updatePackage($package, $info, $merge = true)
    {
        if (is_object($info)) {
            return $this->updatePackage2($info, $merge);
        }
        if (PEAR::isError($e = $this->_lock(LOCK_EX))) {
            return $e;
        }
        $ret = $this->_updatePackage($package, $info, $merge);
        $this->_unlock();
        if ($ret) {
            if (!class_exists('PEAR_PackageFile_v1')) {
                require_once 'PEAR/PackageFile/v1.php';
            }
            $pf = new PEAR_PackageFile_v1;
            $pf->setConfig($this->_config);
            $pf->fromArray($this->packageInfo($package));
            $this->_dependencyDB->uninstallPackage($pf);
            $this->_dependencyDB->installPackage($pf);
        }
        return $ret;
    }

    // }}}
    // {{{ updatePackage2()

    function updatePackage2($info)
    {

        if (!is_object($info)) {
            return $this->updatePackage($info['package'], $info, $merge);
        }

        if (!$info->validate(PEAR_VALIDATE_DOWNLOADING)) {
            return false;
        }

        if (PEAR::isError($e = $this->_lock(LOCK_EX))) {
            return $e;
        }

        $ret = $this->_updatePackage2($info);
        $this->_unlock();
        if ($ret) {
            $this->_dependencyDB->uninstallPackage($info);
            $this->_dependencyDB->installPackage($info);
        }

        return $ret;
    }

    // }}}
    // {{{ getChannel()
    /**
     * @param string channel name
     * @param bool whether to strictly return raw channels (no aliases)
     * @return PEAR_ChannelFile|PEAR_Error
     */
    function getChannel($channel, $noaliases = false)
    {
        if (PEAR::isError($e = $this->_lock(LOCK_SH))) {
            return $e;
        }
        $ret = $this->_getChannel($channel, $noaliases);
        $this->_unlock();
        if (!$ret) {
            return PEAR::raiseError('Unknown channel: ' . $channel);
        }
        return $ret;
    }

    // }}}
    // {{{ getPackage()
    /**
     * @param string package name
     * @param string channel name
     * @return PEAR_PackageFile_v1|PEAR_PackageFile_v2|null
     */
    function &getPackage($package, $channel = 'pear.php.net')
    {
        if (PEAR::isError($e = $this->_lock(LOCK_SH))) {
            return $e;
        }
        $pf = &$this->_getPackage($package, $channel);
        $this->_unlock();
        return $pf;
    }

    // }}}

    /**
     * Get PEAR_PackageFile_v[1/2] objects representing the contents of
     * a dependency group that are installed.
     *
     * This is used at uninstall-time
     * @param array
     * @return array|false
     */
    function getInstalledGroup($group)
    {
        $ret = array();
        if (isset($group['package'])) {
            if (!isset($group['package'][0])) {
                $group['package'] = array($group['package']);
            }
            foreach ($group['package'] as $package) {
                $depchannel = isset($package['channel']) ? $package['channel'] : '__uri';
                $p = &$this->getPackage($package['name'], $depchannel);
                if ($p) {
                    $save = &$p;
                    $ret[] = &$save;
                }
            }
        }
        if (isset($group['subpackage'])) {
            if (!isset($group['subpackage'][0])) {
                $group['subpackage'] = array($group['subpackage']);
            }
            foreach ($group['subpackage'] as $package) {
                $depchannel = isset($package['channel']) ? $package['channel'] : '__uri';
                $p = &$this->getPackage($package['name'], $depchannel);
                if ($p) {
                    $save = &$p;
                    $ret[] = &$save;
                }
            }
        }
        if (!count($ret)) {
            return false;
        }
        return $ret;
    }

    // {{{ getChannelValidator()
    /**
     * @param string channel name
     * @return PEAR_Validate|false
     */
    function &getChannelValidator($channel)
    {
        $chan = $this->getChannel($channel);
        if (PEAR::isError($chan)) {
            return $chan;
        }
        $val = $chan->getValidationObject();
        return $val;
    }
    // }}}
    // {{{ getChannels()
    /**
     * @param string channel name
     * @return array an array of PEAR_ChannelFile objects representing every installed channel
     */
    function &getChannels()
    {
        $ret = array();
        if (PEAR::isError($e = $this->_lock(LOCK_SH))) {
            return $e;
        }
        foreach ($this->_listChannels() as $channel) {
            $e = &$this->_getChannel($channel);
            if (!$e || PEAR::isError($e)) {
                continue;
            }
            $ret[] = $e;
        }
        $this->_unlock();
        return $ret;
    }

    // }}}
    // {{{ checkFileMap()

    /**
     * Test whether a file or set of files belongs to a package.
     *
     * If an array is passed in
     * @param string|array file path, absolute or relative to the pear
     *                     install dir
     * @param string|array name of PEAR package or array('package' => name, 'channel' =>
     *                     channel) of a package that will be ignored
     * @param string API version - 1.1 will exclude any files belonging to a package
     * @param array private recursion variable
     * @return array|false which package and channel the file belongs to, or an empty
     *                     string if the file does not belong to an installed package,
     *                     or belongs to the second parameter's package
     */
    function checkFileMap($path, $package = false, $api = '1.0', $attrs = false)
    {
        if (is_array($path)) {
            static $notempty;
            if (empty($notempty)) {
                if (!class_exists('PEAR_Installer_Role')) {
                    require_once 'PEAR/Installer/Role.php';
                }
                $notempty = create_function('$a','return !empty($a);');
            }
            $package = is_array($package) ? array(strtolower($package[0]), strtolower($package[1]))
                : strtolower($package);
            $pkgs = array();
            foreach ($path as $name => $attrs) {
                if (is_array($attrs)) {
                    if (isset($attrs['install-as'])) {
                        $name = $attrs['install-as'];
                    }
                    if (!in_array($attrs['role'], PEAR_Installer_Role::getInstallableRoles())) {
                        // these are not installed
                        continue;
                    }
                    if (!in_array($attrs['role'], PEAR_Installer_Role::getBaseinstallRoles())) {
                        $attrs['baseinstalldir'] = is_array($package) ? $package[1] : $package;
                    }
                    if (isset($attrs['baseinstalldir'])) {
                        $name = $attrs['baseinstalldir'] . DIRECTORY_SEPARATOR . $name;
                    }
                }
                $pkgs[$name] = $this->checkFileMap($name, $package, $api, $attrs);
                if (PEAR::isError($pkgs[$name])) {
                    return $pkgs[$name];
                }
            }
            return array_filter($pkgs, $notempty);
        }
        if (empty($this->filemap_cache)) {
            if (PEAR::isError($e = $this->_lock(LOCK_SH))) {
                return $e;
            }
            $err = $this->_readFileMap();
            $this->_unlock();
            if (PEAR::isError($err)) {
                return $err;
            }
        }
        if (!$attrs) {
            $attrs = array('role' => 'php'); // any old call would be for PHP role only
        }
        if (isset($this->filemap_cache[$attrs['role']][$path])) {
            if ($api >= '1.1' && $this->filemap_cache[$attrs['role']][$path] == $package) {
                return false;
            }
            return $this->filemap_cache[$attrs['role']][$path];
        }
        $l = strlen($this->install_dir);
        if (substr($path, 0, $l) == $this->install_dir) {
            $path = preg_replace('!^'.DIRECTORY_SEPARATOR.'+!', '', substr($path, $l));
        }
        if (isset($this->filemap_cache[$attrs['role']][$path])) {
            if ($api >= '1.1' && $this->filemap_cache[$attrs['role']][$path] == $package) {
                return false;
            }
            return $this->filemap_cache[$attrs['role']][$path];
        }
        return false;
    }

    // }}}
    // {{{ flush()
    /**
     * Force a reload of the filemap
     * @since 1.5.0RC3
     */
    function flushFileMap()
    {
        $this->filemap_cache = null;
        clearstatcache(); // ensure that the next read gets the full, current filemap
    }

    // }}}
    // {{{ apiVersion()
    /**
     * Get the expected API version.  Channels API is version 1.1, as it is backwards
     * compatible with 1.0
     * @return string
     */
    function apiVersion()
    {
        return '1.1';
    }
    // }}}


    /**
     * Parse a package name, or validate a parsed package name array
     * @param string|array pass in an array of format
     *                     array(
     *                      'package' => 'pname',
     *                     ['channel' => 'channame',]
     *                     ['version' => 'version',]
     *                     ['state' => 'state',]
     *                     ['group' => 'groupname'])
     *                     or a string of format
     *                     [channel://][channame/]pname[-version|-state][/group=groupname]
     * @return array|PEAR_Error
     */
    function parsePackageName($param, $defaultchannel = 'pear.php.net')
    {
        $saveparam = $param;
        if (is_array($param)) {
            // convert to string for error messages
            $saveparam = $this->parsedPackageNameToString($param);
            // process the array
            if (!isset($param['package'])) {
                return PEAR::raiseError('parsePackageName(): array $param ' .
                    'must contain a valid package name in index "param"',
                    'package', null, null, $param);
            }
            if (!isset($param['uri'])) {
                if (!isset($param['channel'])) {
                    $param['channel'] = $defaultchannel;
                }
            } else {
                $param['channel'] = '__uri';
            }
        } else {
            $components = @parse_url((string) $param);
            if (isset($components['scheme'])) {
                if ($components['scheme'] == 'http') {
                    // uri package
                    $param = array('uri' => $param, 'channel' => '__uri');
                } elseif($components['scheme'] != 'channel') {
                    return PEAR::raiseError('parsePackageName(): only channel:// uris may ' .
                        'be downloaded, not "' . $param . '"', 'invalid', null, null, $param);
                }
            }
            if (!isset($components['path'])) {
                return PEAR::raiseError('parsePackageName(): array $param ' .
                    'must contain a valid package name in "' . $param . '"',
                    'package', null, null, $param);
            }
            if (isset($components['host'])) {
                // remove the leading "/"
                $components['path'] = substr($components['path'], 1);
            }
            if (!isset($components['scheme'])) {
                if (strpos($components['path'], '/') !== false) {
                    if ($components['path']{0} == '/') {
                        return PEAR::raiseError('parsePackageName(): this is not ' .
                            'a package name, it begins with "/" in "' . $param . '"',
                            'invalid', null, null, $param);
                    }
                    $parts = explode('/', $components['path']);
                    $components['host'] = array_shift($parts);
                    if (count($parts) > 1) {
                        $components['path'] = array_pop($parts);
                        $components['host'] .= '/' . implode('/', $parts);
                    } else {
                        $components['path'] = implode('/', $parts);
                    }
                } else {
                    $components['host'] = $defaultchannel;
                }
            } else {
                if (strpos($components['path'], '/')) {
                    $parts = explode('/', $components['path']);
                    $components['path'] = array_pop($parts);
                    $components['host'] .= '/' . implode('/', $parts);
                }
            }

            if (is_array($param)) {
                $param['package'] = $components['path'];
            } else {
                $param = array(
                    'package' => $components['path']
                    );
                if (isset($components['host'])) {
                    $param['channel'] = $components['host'];
                }
            }
            if (isset($components['fragment'])) {
                $param['group'] = $components['fragment'];
            }
            if (isset($components['user'])) {
                $param['user'] = $components['user'];
            }
            if (isset($components['pass'])) {
                $param['pass'] = $components['pass'];
            }
            if (isset($components['query'])) {
                parse_str($components['query'], $param['opts']);
            }
            // check for extension
            $pathinfo = pathinfo($param['package']);
            if (isset($pathinfo['extension']) &&
                  in_array(strtolower($pathinfo['extension']), array('tgz', 'tar'))) {
                $param['extension'] = $pathinfo['extension'];
                $param['package'] = substr($pathinfo['basename'], 0,
                    strlen($pathinfo['basename']) - 4);
            }
            // check for version
            if (strpos($param['package'], '-')) {
                $test = explode('-', $param['package']);
                if (count($test) != 2) {
                    return PEAR::raiseError('parsePackageName(): only one version/state ' .
                        'delimiter "-" is allowed in "' . $saveparam . '"',
                        'version', null, null, $param);
                }
                list($param['package'], $param['version']) = $test;
            }
        }
        // validation
        $info = $this->channelExists($param['channel']);
        if (PEAR::isError($info)) {
            return $info;
        }
        if (!$info) {
            return PEAR::raiseError('unknown channel "' . $param['channel'] .
                '" in "' . $saveparam . '"', 'channel', null, null, $param);
        }
        $chan = $this->getChannel($param['channel']);
        if (PEAR::isError($chan)) {
            return $chan;
        }
        if (!$chan) {
            return PEAR::raiseError("Exception: corrupt registry, could not " .
                "retrieve channel " . $param['channel'] . " information",
                'registry', null, null, $param);
        }
        $param['channel'] = $chan->getName();
        $validate = $chan->getValidationObject();
        $vpackage = $chan->getValidationPackage();
        // validate package name
        if (!$validate->validPackageName($param['package'], $vpackage['_content'])) {
            return PEAR::raiseError('parsePackageName(): invalid package name "' .
                $param['package'] . '" in "' . $saveparam . '"',
                'package', null, null, $param);
        }
        if (isset($param['group'])) {
            if (!PEAR_Validate::validGroupName($param['group'])) {
                return PEAR::raiseError('parsePackageName(): dependency group "' . $param['group'] .
                    '" is not a valid group name in "' . $saveparam . '"', 'group', null, null,
                    $param);
            }
        }
        if (isset($param['state'])) {
            if (!in_array(strtolower($param['state']), $validate->getValidStates())) {
                return PEAR::raiseError('parsePackageName(): state "' . $param['state']
                    . '" is not a valid state in "' . $saveparam . '"',
                    'state', null, null, $param);
            }
        }
        if (isset($param['version'])) {
            if (isset($param['state'])) {
                return PEAR::raiseError('parsePackageName(): cannot contain both ' .
                    'a version and a stability (state) in "' . $saveparam . '"',
                    'version/state', null, null, $param);
            }
            // check whether version is actually a state
            if (in_array(strtolower($param['version']), $validate->getValidStates())) {
                $param['state'] = strtolower($param['version']);
                unset($param['version']);
            } else {
                if (!$validate->validVersion($param['version'])) {
                    return PEAR::raiseError('parsePackageName(): "' . $param['version'] .
                        '" is neither a valid version nor a valid state in "' .
                        $saveparam . '"', 'version/state', null, null, $param);
                }
            }
        }
        return $param;
    }

    /**
     * @param array
     * @return string
     */
    function parsedPackageNameToString($parsed, $brief = false)
    {
        if (is_string($parsed)) {
            return $parsed;
        }
        if (is_object($parsed)) {
            $p = $parsed;
            $parsed = array(
                'package' => $p->getPackage(),
                'channel' => $p->getChannel(),
                'version' => $p->getVersion(),
            );
        }
        if (isset($parsed['uri'])) {
            return $parsed['uri'];
        }
        if ($brief) {
            if ($channel = $this->channelAlias($parsed['channel'])) {
                return $channel . '/' . $parsed['package'];
            }
        }
        $upass = '';
        if (isset($parsed['user'])) {
            $upass = $parsed['user'];
            if (isset($parsed['pass'])) {
                $upass .= ':' . $parsed['pass'];
            }
            $upass = "$upass@";
        }
        $ret = 'channel://' . $upass . $parsed['channel'] . '/' . $parsed['package'];
        if (isset($parsed['version']) || isset($parsed['state'])) {
            $ver = isset($parsed['version']) ? $parsed['version'] : '';
            $ver .= isset($parsed['state']) ? $parsed['state'] : '';
            $ret .= '-' . $ver;
        }
        if (isset($parsed['extension'])) {
            $ret .= '.' . $parsed['extension'];
        }
        if (isset($parsed['opts'])) {
            $ret .= '?';
            foreach ($parsed['opts'] as $name => $value) {
                $parsed['opts'][$name] = "$name=$value";
            }
            $ret .= implode('&', $parsed['opts']);
        }
        if (isset($parsed['group'])) {
            $ret .= '#' . $parsed['group'];
        }
        return $ret;
    }
}
