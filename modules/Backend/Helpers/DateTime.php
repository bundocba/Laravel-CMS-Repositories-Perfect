<?php

namespace Modules\Backend\Helpers;

class DateTime
{

    /**
     * Get first day of month
     * @param Integer $month
     * @param Integer $year
     * @return Date
     */
    public static function getFirstday($month, $year)
    {
        return $year . '-' . ($month < 10 ? '0' . $month : $month) . '-01' . ' ' . '00:00';
    }

    /**
     * Get last day of month
     * @param Integer $month
     * @param Integer $year
     * @return Date
     */
    public static function getLastday($month, $year)
    {
        $monthDays = $this->getDays($month, $year);
        return $year . '-' . ($month < 10 ? '0' . $month : $month) . '-' . $monthDays . ' ' . '23:59';
    }

    /**
     * Get the number of days in the month
     * @param Integer $month
     * @param Integer $year
     * @return Integer
     */
    function getDays($month, $year)
    {
        if (is_callable('cal_days_in_month')) {
            return cal_days_in_month(CAL_GREGORIAN, $month, $year);
        } else {
            return date('d', mktime(0, 0, 0, $month + 1, 0, $year));
        }
    }

    /**
     * Get date difference
     * @param String $date1
     * @param String $date2
     * @return Integer
     */
    public static function dateDiff($date1, $date2)
    {
        $timestamp1 = strtotime($date1);
        $timestamp2 = strtotime($date2);

        return $timestamp1 - $timestamp2;
    }

    /**
     * Date add
     * @param String $date
     * @param Integer $hour
     * @param Integer $minute
     * @param Integer $second
     * @param Integer $month
     * @param Integer $day
     * @param Integer $year
     * @return String
     */
    public static function dateAdd($date, $hour = 0, $minute = 0, $second = 0, $month = 0, $day = 0, $year = 0)
    {
        $timestamp = strtotime($date);

        $arr = getdate($timestamp);

        return date('Y-m-d H:i:s', mktime($arr['hours'] + $hour, $arr['minutes'] + $minute, $arr['seconds'] + $second, $arr['mon'] + $month, $arr['mday'] + $day, $arr['year'] + $year));
    }

}
