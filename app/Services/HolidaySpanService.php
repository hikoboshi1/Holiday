<?php

namespace App\Services;

use Carbon\Carbon;
use Carbon\CarbonPeriod;

class HolidaySpanService{
    //Ajaxで受け取った日付から土日祝日を除いた期間を返す
    public function getDuration($from, $to)
    {
        $fromdate = new Carbon($from['holiday_date_from']);
        $todate = new Carbon($to['holiday_date_to']);
        $period = CarbonPeriod::create($fromdate, $todate);
        $days = 0;
        if ($fromdate <= $todate) {
            foreach ($period as $date) {
                if (($date->dayOfWeek != 0) && ($date->dayOfWeek != 6)) {
                    $days++;
                }
            }
        } else {
            $days = "エラー";
        }
        return $days;
    }
}