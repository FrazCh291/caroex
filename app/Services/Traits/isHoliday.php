<?php
/**
 * Created by PhpStorm.
 * User: HP
 * Date: 10/22/2020
 * Time: 4:13 PM
 */

namespace App\Services\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;

trait isHoliday
{
    function checkHoliday($date)
    {
        $original = $date;

        $t = $date;
        $date = "0" . $t->day . "-0" . $t->month;

        $receivedDate = $date;

        $holiday = array(
            '08-09' => 'New Year Day',
            '18-02' => 'Martin Luther King Day',
            '22-02' => 'Washington\'s Birthday',
            '05-07' => 'Independence Day',
            '11-11' => 'Veterans Day',
            '24-12' => 'Christmas Eve',
            '25-12' => 'Christmas Day',
            '31-12' => 'New Year Eve'
        );

        foreach ($holiday as $key => $value) {
            if ($receivedDate == $key) {
                return $original->addDay();
            } else {
                return $original;
            }
        }
    }
}
