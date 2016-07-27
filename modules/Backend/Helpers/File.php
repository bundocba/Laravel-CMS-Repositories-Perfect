<?php

namespace Modules\Backend\Helpers;

class File
{

    public static function getFileExt($filePath)
    {
        return substr($filePath, strrpos($filePath, '.', 0) + 1);
    }

    public static function getDirPath($filePath)
    {
        preg_replace('/[\/\\\\]/', DIRECTORY_SEPARATOR, $filePath);
        return substr($filePath, 0, strrpos($filePath, DIRECTORY_SEPARATOR, 0));
    }

    public static function getFileName($filePath)
    {
        preg_replace('/[\/\\\\]/', DIRECTORY_SEPARATOR, $filePath);
        return substr($filePath, strrpos($filePath, DIRECTORY_SEPARATOR, 0) + 1);
    }

    public static function genFileName($filePath)
    {
        $dirPath = self::getDirPath($filePath);
        $fileName = self::getFileName($filePath);

        if (!file_exists($filePath)) {
            return $fileName;
        }

        $ext = self::getFileExt($fileName);
        $name = substr($fileName, 0, strpos($fileName, '.'));

        $i = 2;
        do {

            $fileName = $name . '(' . $i . ').' . $ext;

            if (!file_exists($dirPath . DIRECTORY_SEPARATOR . $fileName))
                return $fileName;

            $i++;
        } while ($i < 255);

        return $name . '.' . $ext;
    }

    public static function getSubDir($dir)
    {
        if (!file_exists($dir))
            return array();

        $subDirs = array();
        $dirIterator = new DirectoryIterator($dir);

        foreach ($dirIterator as $dir) {
            if ($dir->isDot() || !$dir->isDir()) {
                continue;
            }
            $dir = $dir->getFilename();

            if ($dir == '.svn')
                continue;
            $subDirs[] = $dir;
        }
        return $subDirs;
    }

    public static function deleteRescursiveDir($dir)
    {
        if (is_dir($dir)) {

            $dir = (substr($dir, -1) != DIRECTORY_SEPARATOR) ? $dir . DIRECTORY_SEPARATOR : $dir;
            $openDir = opendir($dir);

            while ($file = readdir($openDir)) {
                if (!in_array($file, array('.', '..'))) {
                    if (!is_dir($dir . $file))
                        @unlink($dir . $file);
                    else
                        self::deleteRescursiveDir($dir . $file);
                }
            }

            closedir($openDir);
            @rmdir($dir);
        }

        return true;
    }

    public static function copyRescursiveDir($source, $dest)
    {
        $openDir = opendir($source);

        if (!file_exists($dest))
            @mkdir($dest);

        while ($file = readdir($openDir)) {
            if (!in_array($file, array('.', '..'))) {
                if (is_dir($source . DIRECTORY_SEPARATOR . $file))
                    self::copyRescursiveDir($source . DIRECTORY_SEPARATOR . $file, $dest . DIRECTORY_SEPARATOR . $file);
                else
                    copy($source . DIRECTORY_SEPARATOR . $file, $dest . DIRECTORY_SEPARATOR . $file);
            }
        }

        closedir($openDir);

        return true;
    }

    public static function createDirs($root, $path)
    {
        $root = rtrim($root, DIRECTORY_SEPARATOR);
        $subDirs = explode(DIRECTORY_SEPARATOR, $path);

        if ($subDirs == null)
            return;

        $currDir = $root;
        foreach ($subDirs as $dir) {

            $currDir = $currDir . DIRECTORY_SEPARATOR . $dir;

            if (!file_exists($currDir))
                mkdir($currDir);
        }
    }

    public static function getMimeContentType($filename)
    {

        $mimeTypes = array(
            'txt' => 'text/plain',
            'htm' => 'text/html',
            'html' => 'text/html',
            'php' => 'text/html',
            'css' => 'text/css',
            'js' => 'application/javascript',
            'json' => 'application/json',
            'xml' => 'application/xml',
            'swf' => 'application/x-shockwave-flash',
            'flv' => 'video/x-flv',
            // images
            'png' => 'image/png',
            'jpe' => 'image/jpeg',
            'jpeg' => 'image/jpeg',
            'jpg' => 'image/jpeg',
            'gif' => 'image/gif',
            'bmp' => 'image/bmp',
            'ico' => 'image/vnd.microsoft.icon',
            'tiff' => 'image/tiff',
            'tif' => 'image/tiff',
            'svg' => 'image/svg+xml',
            'svgz' => 'image/svg+xml',
            // archives
            'zip' => 'application/zip',
            'rar' => 'application/x-rar-compressed',
            'exe' => 'application/x-msdownload',
            'msi' => 'application/x-msdownload',
            'cab' => 'application/vnd.ms-cab-compressed',
            // audio/video
            'mp3' => 'audio/mpeg',
            'qt' => 'video/quicktime',
            'mov' => 'video/quicktime',
            // adobe
            'pdf' => 'application/pdf',
            'psd' => 'image/vnd.adobe.photoshop',
            'ai' => 'application/postscript',
            'eps' => 'application/postscript',
            'ps' => 'application/postscript',
            // ms office
            'doc' => 'application/msword',
            'rtf' => 'application/rtf',
            'xls' => 'application/vnd.ms-excel',
            'ppt' => 'application/vnd.ms-powerpoint',
            // open office
            'odt' => 'application/vnd.oasis.opendocument.text',
            'ods' => 'application/vnd.oasis.opendocument.spreadsheet',
        );

        $arr = explode('.', $filename);
        $ext = array_pop($arr);
        $ext = strtolower($ext);

        if (array_key_exists($ext, $mimeTypes)) {
            return $mimeTypes[$ext];
        } elseif (function_exists('finfo_open')) {
            $finfo = finfo_open(FILEINFO_MIME);
            $mimetype = finfo_file($finfo, $filename);
            finfo_close($finfo);
            return $mimetype;
        } else {
            return 'application/octet-stream';
        }
    }

}
