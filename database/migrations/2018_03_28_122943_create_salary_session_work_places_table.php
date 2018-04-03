<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSalarySessionWorkPlacesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('salary_session_work_places', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('work_places_id')->unsigned();
            // $table->foreign('work_places_id')->references('id')
            // ->on('work__places')->onDelete('cascade');
            
            $table->integer('salary_sessions_id')->unsigned();
            // $table->foreign('salary_sessions_id')->references('id')
            // ->on('salary__sessions')->onDelete('cascade');

            $table->integer('salary_session_types_id')->unsigned();
            // $table->foreign('salary_session_types_id')->references('id')
            // ->on('salary__session__types')->onDelete('cascade');
            $table->date('start_date');
            $table->date('end_date');

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
        Schema::dropIfExists('salary_session_work_places');
    }
}
