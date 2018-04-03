<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWorkplaceTimeSlotsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('workplace__time__slots', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('time_slot_id')->unsigned();
            // $table->foreign('time_slot_id')->references('id')->on('time_slots');
            $table->integer('work_places_id')->unsigned();
            // $table->foreign('work_places_id')->references('id')->on('work__places');

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
        Schema::dropIfExists('workplace__time__slots');
    }
}
