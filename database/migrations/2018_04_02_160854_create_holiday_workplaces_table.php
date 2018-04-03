<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHolidayWorkplacesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('holiday_workplaces', function (Blueprint $table) {
            $table->increments('id');
            $table->date('start_date');
            $table->time('start_time');
            $table->date('end_date');
            $table->time('end_time');
            $table->integer('work_places_id')->default(0)->unsigned();
            $table->foreign('work_places_id')->references('id')->on('work__places');
            $table->integer('holidays_id');
            $table->tinyInteger('status')->default(0)->comment('0 Site 1 office 2 site and office');
            
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
        Schema::table('holiday_workplaces', function (Blueprint $table) {
            $table->dropForeign('work_places_id'); 
        });
        Schema::dropIfExists('holiday_workplaces');

    }
}
