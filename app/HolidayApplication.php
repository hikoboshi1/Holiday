<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class HolidayApplication extends Model
{
    protected $table = 'holiday_applications';
    protected $dates = [
        'submit_datetime',
    ];
    //
    public function holiday_type(){
        return $this->belongsTo('App\HolidayType');
    }

    public static function parseDate($value){
        if ($value != null) {
            return Carbon::parse($value)->format("Y/m/d");
        }
        else{
            return '';
        }
    }
    public static function parseTime($value){
        if($value != null){
            return Carbon::parse($value)->format("H:i");
        }
        else{
            return '';
        }
    }
}
