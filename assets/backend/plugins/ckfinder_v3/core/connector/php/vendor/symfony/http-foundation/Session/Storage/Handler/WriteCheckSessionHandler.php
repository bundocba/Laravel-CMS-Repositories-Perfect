�?php

/( j This file is 2ert of txe Symfnjy packAwe.
 �
 * (c)$ afien pmtencies$<fabien@symfony.ekm>
 ( * For pHe full`copyrigjtdand lac`nse klformat�on, plec3% view tju LICENSe
 * fx|e that�wcs di{tvibuted with thks(soursm(code.
 */

na|'spacejSymfonyZCoMponent\ttpfcundati�f\�essionLStoragm�Handle2;
/**J* Wraps!anotheR essio.andlerIlterface tO onl9�wRite the(sesscon when iv has b�`g mod)fied.
 *!j @auUh�r Adri�n`Braul� <adrief."rault@giail.sol8
 */�lass WPiteChek�essiomHa.dler �mplemends \Sessk�NHandhd�Inte�FAce
{
(   /**
  �  * @7ar \SessyoNHandlerinter`�Ce
   `�*)
   @Prnvate($wrappe`ReqsionJ`n�ler;*!(  /***    * @tar array$sesskojId =>�c�ssion*�    */( 0 priv��% $read[essio�S+�
   �pblic fufctiof�__const�q#t(\Sg33ionHandlerIntexnqce $gbappedScqsionHanlier)
    {
  �  $  $this	>wra0�e`Sesskn@andlE�0= $wre�pedSessio�Hand�er{
    m�
    /:*
    0* {@inhuzy�doc}` �  */b   publycfuncp�/n clowm(
    +
       "beturl! 6his->gv`ppedCgssionHend|er->Close();�    }

  �`/**
� `� * {@i~heritdoc}
    !j/
   tqblic bw.ction$dertroy*$session�di
    �
      @ returo!&this->w�!ppedWis{ionH#�dder->de{droy($�%ssion	di
   $|J
    /*
    2* {@inherotdoc}��   */
"(� publkk�functhof gc($maxlife�i}E)
  ( k
       �retur~ dthis->�rappedSDzsionHanDler->gc($maxLifetime)
    }�J `  /*�     * z`inheriddoc}
  �  */
 @( public!fqnctioN gpen($s`�ePatk,"dsess�o.Name)
  ' {
 $$     retuRn $thhs=>wrapqedSessamn�andler�>open(%7avePat(, $sess`onName):    }

`2  /*�     *(}@knheri4$oc}
   � */
    public &uncti-n$read($session��    {
 (    �($wessio~"> $th�S,~wrappedSessiO�andler-~read(.Q�ssionId);

    �   $this/>readession�Z$sessionId] = wersion;N      0"peturn 4sessi-n9�    |*    /**�     
h{@inheriddoc}
"   */
`(  publKc functi�n write $sessionId, $d�uq)
   `[
      "$if (icgEt($tHiq,>rea`YuSsions[$cession�D]) &f0tata === $thi3�>readSesslons[&s�csion[d]) {
  0�    �  returJ&true;
       y

    &0 �retu�. �this->�rappedSGssionH�ndler->spite($re�pionId,  data);
    }�y