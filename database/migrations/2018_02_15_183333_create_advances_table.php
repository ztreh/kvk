<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdvancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('advances', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('salary_session_work_places_id')->unsigned();
            $table->foreign('salary_session_work_places_id')->references('id')->on('salary_session_work_places');
            $table->integer('employees_id')->unsigned();
            $table->foreign('employees_id')->references('id')->on('employees');
            $table->decimal('advance_amount', 10, 2);
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
        Schema::table('advances', function (Blueprint $table) {
            
            $table->dropForeign('salary_session_work_places_id'); 
            $table->dropForeign('employees_id'); 
        });
        
        Schema::dropIfExists('advances');
    }
}
