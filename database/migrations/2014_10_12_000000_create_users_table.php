<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');// 自動採番してくれる値
            $table->unsignedInteger('employee_id')->length(5)->foreign()->references('id')->on('employees');
            $table->string('user_name'); 
            $table->string('password');
            $table->unsignedInteger('role_id')->length(5)->foreign()->references('id')->on('roles');
            $table->rememberToken();//varchar(100)でNull値可能な remember_tokenを追加
            $table->timestamps();//Null値可能なcreate_at と update_at カラムを追加
            $table->unique(['user_name','password','role_id'], 'unique_name_pass_role');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
