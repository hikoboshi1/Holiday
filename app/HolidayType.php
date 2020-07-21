<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class HolidayType extends Model
{
    protected $table = 'holiday_types';
    //
    public function holiday_applications(){
        return $this->hasMany('App\HolidayApplication');
    }
    public function scopeIdToCode(Builder $query, $id){
        return $query->where('id', $id)->first()->holiday_type_code;
    }
}
