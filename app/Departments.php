<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Departments extends Model
{
    //
    protected $table = 'departments';

    public function employees(){
        return $this->hasMany('App\Employees');
    }
}
