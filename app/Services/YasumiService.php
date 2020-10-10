<?php

namespace App\Services;

use Yasumi\Yasumi;

class YasumiService
{
    public function idHolidayy($date){
        $holidays = Yasumi::create('Japan', $date->year);
        return $holidays->isHoliday($date);
    }
}