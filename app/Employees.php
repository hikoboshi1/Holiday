<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Employees extends Model
{
    //
    protected $table = 'employees';
    
    public function holiday_applications(){
        return $this->hasMany('App\HolidayApplication');
    }
    public function paid_holidays(){
        return $this->hasMany('App\PaidHolidays');
    }
    public function post(){
        return $this->belongsTo('App\Posts');
    }
    public function department(){
        return $this->belongsTo('App\Departments');
    }
    public function user(){
        return $this->belongsTo('App\User');
    }

    //employee_idからlast_nameを取得
    public function scopeIdToLastName(Builder $query, $id){
        return $query->where('id', $id)->first()->last_name;
    }
    //employee_idからfirst_nameを取得
    public function scopeIdToFirstName(Builder $query, $id){
        return $query->where('id', $id)->first()->first_name;
    }
}
