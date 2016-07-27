<?php

namespace Modules\Backend\Helpers;

class Validation
{

    public static function IsInteger($text)
    {
        $regex = "/(^(\-?)([1-9])([0-9])*$)|(^0$)/";
        return preg_match($regex, $text);
    }

    public static function IsNumeric($text)
    {
        $regex = "/^[0-9]*$/";
        return preg_match($regex, $text);
    }

    public static function IsAlphabet($text)
    {
        $regex = "/^([a-zA-Z])*$/";
        return preg_match($regex, $text);
    }

    public static function IsAlphaNumeric($text)
    {
        $regex = "^([a-zA-Z0-9])*$";
        return preg_match($regex, $text);
    }

    public static function IsHour($text)
    {
//        $regex = "/^(20|21|22|23|1\d|0?\d)(([:][0-5]\d){1,2})(([:][0-5]\d){1,2})$/";
        $regex = "/^(20|21|22|23|1\d|0?\d)(([:][0-5]\d){1,2})$/";
        return preg_match($regex, $text);
    }

    public static function IsEmail($text)
    {
        $regex = "/^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/";
        return preg_match($regex, $text);
    }

    public static function IsPhone($text)
    {
        $regex = "/^(\d{8,12})$/";
        return preg_match($regex, $text);
    }

    public static function IsImage($text)
    {
        $regex = "/\.(jpg|jpeg|png|gif)(?:[\?\#].*)?$/i";
        return preg_match($regex, $text);
    }

    public static function isDate($text, $type)
    {
        $text = str_replace('-', '/', $text);
        if ($type == 1) {
            $regex = "/^(((0?[1-9]|[12]\d|3[01])\/(0?[13578]|1[02])\/((1[6-9]|[2-9]\d)\d{2}))|((0?[1-9]|[12]\d|30)\/(0?[13456789]|1[012])\/((1[6-9]|[2-9]\d)\d{2}))|((0?[1-9]|1\d|2[0-8])\/0?2\/((1[6-9]|[2-9]\d)\d{2}))|(29\/0?2\/((1[6-9]|[2-9]\d)(0[48]|[2468][048]|[13579][26])|((16|[2468][048]|[3579][26])00))))$/";
        } else if ($type == 2) {
            $regex = "/^(((0?[13578]|1[02])\/(0?[1-9]|[12]\d|3[01])\/((1[6-9]|[2-9]\d)\d{2}))|((0?[13456789]|1[012])\/(0?[1-9]|[12]\d|30)\/((1[6-9]|[2-9]\d)\d{2}))|(0?2\/(0?[1-9]|1\d|2[0-8])\/((1[6-9]|[2-9]\d)\d{2}))|(0?2\/29\/((1[6-9]|[2-9]\d)(0[48]|[2468][048]|[13579][26])|((16|[2468][048]|[3579][26])00))))$/";
        } else {
            $regex = "/^((((1[6-9]|[2-9]\d)\d{2})\/(0?[13578]|1[02])\/(0?[1-9]|[12]\d|3[01]))|(((1[6-9]|[2-9]\d)\d{2})\/(0?[13456789]|1[012])\/(0?[1-9]|[12]\d|30))|(((1[6-9]|[2-9]\d)\d{2})\/0?2\/(0?[1-9]|1\d|2[0-8]))|(((1[6-9]|[2-9]\d)(0[48]|[2468][048]|[13579][26])|((16|[2468][048]|[3579][26])00))\/0?2\/29))$/";
        }

        return preg_match($regex, $text);
    }

}
