<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRawAttendancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('raw_attendances', function (Blueprint $table) {
            $table->increments('id');
            $table->date('date')->nullable();
            $table->time('time')->nullable();
            $table->string('fingerprint_no')->nullable();
            $table->tinyInteger('status')->default(0);
            $table->integer('devices_id')->unsigned();
            $table->foreign('devices_id')->references('id')->on('devices');

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
        Schema::table('raw_attendances', function (Blueprint $table) {
            $table->dropForeign('devices_id'); 
        });
        
        Schema::dropIfExists('raw_attendances');
    }
}
