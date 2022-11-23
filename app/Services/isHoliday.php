<?php


namespace App\Services;

use Illuminate\Support\Str;

class isHoliday
{
    function checkHoliday($date)
    {


        $t = Carbon::now();
        $date = "0" . $t->day . "-0" . $t->month;
        $receivedDate = $date;
        $holiday = array(
            '01-01' => 'New Year Day',
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
                return $value;
            }
        }
    }
}
