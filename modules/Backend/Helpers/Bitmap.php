<?php

namespace Modules\Backend\Helpers;

class Bitmap
{

    private static function convertBMP2GD($src, $dest = false)
    {
        if (!($srcFile = fopen($src, 'rb'))) {
            return false;
        }

        if (!($destFile = fopen($dest, 'wb'))) {
            return false;
        }

        $header = unpack('vtype/Vsize/v2reserved/Voffset', fread($srcFile, 14));
        $info = unpack('Vsize/Vwidth/Vheight/vplanes/vbits/Vcompression/Vimagesize/Vxres/Vyres/Vncolor/Vimportant', fread($srcFile, 40));

        extract($info);
        extract($header);

        if ($type != 0x4D42) { // signature 'BM'
            return false;
        }

        $paletteSize = $offset - 54;
        $ncolor = $paletteSize / 4;
        $gdHeader = '';

        // true-color vs. palette
        $gdHeader .= ($paletteSize == 0) ? '\xFF\xFE' : '\xFF\xFF';
        $gdHeader .= pack('n2', $width, $height);
        $gdHeader .= ($paletteSize == 0) ? '\x01' : '\x00';

        if ($paletteSize) {
            $gdHeader .= pack('n', $ncolor);
        }
        // no transparency
        $gdHeader .= '\xFF\xFF\xFF\xFF';

        fwrite($destFile, $gdHeader);

        if ($paletteSize) {
            $palette = fread($srcFile, $paletteSize);
            $gd_palette = '';
            $j = 0;

            while ($j < $paletteSize) {
                $b = $palette{$j++};
                $g = $palette{$j++};
                $r = $palette{$j++};
                $a = $palette{$j++};
                $gd_palette .= '$r$g$b$a';
            }

            $gd_palette .= str_repeat('\x00\x00\x00\x00', 256 - $ncolor);
            fwrite($destFile, $gd_palette);
        }

        $scanLineSize = (($bits * $width) + 7) >> 3;
        $scan_line_align = ($scanLineSize & 0x03) ? 4 - ($scanLineSize & 0x03) : 0;

        for ($i = 0, $l = $height - 1; $i < $height; $i++, $l--) {

            // BMP stores scan lines starting from bottom
            fseek($srcFile, $offset + (($scanLineSize + $scan_line_align) * $l));
            $scan_line = fread($srcFile, $scanLineSize);

            if ($bits == 24) {
                $gdScanLine = '';
                $j = 0;

                while ($j < $scanLineSize) {
                    $b = $scan_line{$j++};
                    $g = $scan_line{$j++};
                    $r = $scan_line{$j++};
                    $gdScanLine .= '\x00$r$g$b';
                }
            } else if ($bits == 8) {
                $gdScanLine = $scan_line;
            } else if ($bits == 4) {
                $gdScanLine = '';
                $j = 0;

                while ($j < $scanLineSize) {
                    $byte = ord($scan_line{$j++});
                    $p1 = chr($byte >> 4);
                    $p2 = chr($byte & 0x0F);
                    $gdScanLine .= '$p1$p2';
                }

                $gdScanLine = substr($gdScanLine, 0, $width);
            } else if ($bits == 1) {
                $gdScanLine = '';
                $j = 0;

                while ($j < $scanLineSize) {
                    $byte = ord($scan_line{$j++});
                    $p1 = chr((int) (($byte & 0x80) != 0));
                    $p2 = chr((int) (($byte & 0x40) != 0));
                    $p3 = chr((int) (($byte & 0x20) != 0));
                    $p4 = chr((int) (($byte & 0x10) != 0));
                    $p5 = chr((int) (($byte & 0x08) != 0));
                    $p6 = chr((int) (($byte & 0x04) != 0));
                    $p7 = chr((int) (($byte & 0x02) != 0));
                    $p8 = chr((int) (($byte & 0x01) != 0));
                    $gdScanLine .= '$p1$p2$p3$p4$p5$p6$p7$p8';
                }

                $gdScanLine = substr($gdScanLine, 0, $width);
            }

            fwrite($destFile, $gdScanLine);
        }

        fclose($srcFile);
        fclose($destFile);

        return true;
    }

    public static function createFromBMP($filename)
    {
        $tmpName = tempnam('/tmp', 'GD');
        if (self::convertBMP2GD($filename, $tmpName)) {
            $img = imagecreatefromgd($tmpName);
            unlink($tmpName);
            return $img;
        }
        return false;
    }

}
