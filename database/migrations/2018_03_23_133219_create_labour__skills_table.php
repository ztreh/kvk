<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLabourSkillsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('labour__skills', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('skill_id');
            // $table->foreign('skill_id')->references('id')
            // ->on('skills')->onDelete('cascade');
            
            $table->integer('labours_id');
            // $table->foreign('labours_id')->references('id')
            // ->on('labours')->onDelete('cascade');
            
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
        Schema::dropIfExists('labour__skills');
    }
}
