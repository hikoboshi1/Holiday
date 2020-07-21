<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHolidayApplicationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('holiday_applications', function (Blueprint $table) {
            $table->bigIncrements('id')->length(5);
            $table->unsignedInteger('user_id')->length(5);
            $table->foreign('user_id')->references('id')->on('users');
            $table->dateTime('submit_date');
            $table->unsignedInteger('holiday_type_id')->length(2);
            $table->foreign('holiday_type_id')->references('id')->on('holiday_types');
            $table->date('holiday_date_from');
            $table->date('holiday_date_to')->nullable();
            $table->time('holiday_time_from')->nullable();
            $table->time('holiday_time_to')->nullable();
            $table->string('reason',255);
            $table->string('remarks',255)->nullable();
            $table->timestamps();
            $table->unique(['user_id', 'holiday_date_from'], 'unique_user_id_holiday_date_from');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('holiday_applications');
    }
}
