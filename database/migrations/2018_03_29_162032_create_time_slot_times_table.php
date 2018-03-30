<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTimeSlotTimesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('time_slot_times', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('workplace_time_slot_id');
            $table->time('start_time');
            $table->time('end_time');
            $table->tinyInteger('status')->default(0)->comment('1 active 0 inactive');
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
        Schema::dropIfExists('time_slot_times');
    }
}
