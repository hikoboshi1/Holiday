<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaidHolidays extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('paid_holidays', function (Blueprint $table) {
            $table->bigIncrements('id')->length(5);
            $table->unsignedInteger('employee_id')->length(5)->foreign()->references('id')->on('employees');
            $table->date('given_date');
            $table->float('given_days',4,1);
            $table->float('used_days',4,1)->default(0);
            $table->unique(['employee_id', 'given_date'], 'unique_employee_id_given_date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('paid_holidays');
    }
}
