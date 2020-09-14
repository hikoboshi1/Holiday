<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class ApplicationStatuses extends Model
{
    protected $table = 'application_statuses';
    //
    public function holiday_applications(){
        return $this->hasMany('App\HolidayApplication');
    }

    //
    public function scopeIdToName(Builder $query, $id){
        return $query->where('id', $id)->first()->application_status_name;
    }
}
