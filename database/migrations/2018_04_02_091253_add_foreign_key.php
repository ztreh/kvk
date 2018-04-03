<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignKey extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('workplace__time__slots', function (Blueprint $table) {
            
            $table->foreign('time_slot_id')->references('id')->on('time_slots');
            $table->foreign('work_places_id')->references('id')->on('work__places');
            
        });

        Schema::table('time_slot_times', function (Blueprint $table) {
            $table->foreign('workplace_time_slot_id')->references('id')->on('workplace__time__slots');
            
        });

        Schema::table('salary_session_work_places', function (Blueprint $table) {
            
            $table->foreign('work_places_id')->references('id')->on('work__places')->onDelete('cascade');
            $table->foreign('salary_sessions_id')->references('id')->on('salary__sessions')->onDelete('cascade');
            $table->foreign('salary_session_types_id')->references('id')->on('salary__session__types')->onDelete('cascade');
            
        });

        Schema::table('devices', function (Blueprint $table) {
            
            $table->foreign('work_places_id')->references('id')->on('work__places')->onDelete('cascade');
        });

        Schema::table('labour__skills', function (Blueprint $table) {
            
            $table->foreign('skill_id')->references('id')->on('skills')->onDelete('cascade');
            $table->foreign('labours_id')->references('id')->on('labours')->onDelete('cascade');
        });

        Schema::table('labours', function (Blueprint $table) {

            $table->foreign('recomended_employee_id')->references('id')->on('employees')->onDelete('cascade');
            $table->foreign('employees_id')->references('id')->on('employees')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
       //  Schema::table('lists', function(Blueprint $table)
       // {
       //      $table->dropForeign('user_id'); //
       // });

        Schema::table('workplace__time__slots', function (Blueprint $table) {
           
            $table->dropForeign('time_slot_id'); //
            $table->dropForeign('work_places_id'); //

        });

        Schema::table('time_slot_times', function (Blueprint $table) {
            $table->dropForeign('workplace_time_slot_id'); //
            
        });

        Schema::table('salary_session_work_places', function (Blueprint $table) {
            
            $table->dropForeign('work_places_id'); 
            $table->dropForeign('salary_sessions_id'); 
            $table->dropForeign('salary_session_types_id'); 
            
            
        });

        Schema::table('devices', function (Blueprint $table) {
            
            $table->dropForeign('work_places_id'); 
        });

        Schema::table('labour__skills', function (Blueprint $table) {
            
            $table->dropForeign('skill_id'); 
            $table->dropForeign('labours_id'); 
        });

        Schema::table('labours', function (Blueprint $table) {

            $table->dropForeign('recomended_employee_id'); 
            $table->dropForeign('employees_id'); 
        });

    }
}
