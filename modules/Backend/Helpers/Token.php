<?php

namespace Modules\Backend\Helpers;

class Token
{

    public static function genToken()
    {
        $text = '';
        $text = Guid::generateGuid();
        $text = str_replace('-', '', strtolower($text));
        return $text;
    }

    public static function genRnd($length = 32, $data = 'abcdefghijklmnopqrstuvxyz0123456789')
    {
        $text = '';
        for ($i = 0; $i < $length; $i++) {
            $text .= $data[rand(0, strlen($data) - 1)];
        }
        return $text;
    }

}
