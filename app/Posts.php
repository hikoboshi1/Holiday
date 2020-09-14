<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Posts extends Model
{
    //
    protected $table = 'posts';

    public function employees(){
        return $this->hasMany('App\Employees');
    }
}
