<?php
/**
 * Created by PhpStorm.
 * User: mamareza
 * Date: 12/24/16
 * Time: 5:26 PM
 */

namespace App\Utils\Services\RoutineServices;


use App\Utils\Jalali\jDate;

class DateService
{
    public static function todayDate(){
        return jDate::forge()->format('%A %d %B %Y');
    }

    public static function isPassed($date){
        $now = time();
        $time = strtotime($date);
        return $time < $now;
    }

    public static function compareRemainDays($date, $remainDays){
        // build period and length arrays
        $lengths = array(60, 60, 24, 7, 4.35, 12, 10);

        $now = time();
        $time = strtotime($date);

        // get difference
        $difference = $time - $now;
        if ($difference < 0)
            return false;

        // computing difference
        for ($i = 0; $difference >= $lengths[$i] and $i < count($lengths) - 1; $i++)
            $difference /= $lengths[$i];

        // round difference
        $difference = intval(round($difference));

        if ($i <= 2 or ($i == 3 and $difference <= $remainDays))
            return true;
        return false;
    }
}