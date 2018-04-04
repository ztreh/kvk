<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLeaveEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('leave_employees', function (Blueprint $table) {
            $table->increments('id');
            $table->string('remarks');
            $table->date('start_date');
            $table->time('start_time');
            $table->date('end_date');
            $table->time('end_time');
            $table->integer('employees_id')->default(0)->unsigned();
            $table->foreign('employees_id')->references('id')->on('employees');
            $table->integer('leaves_id')->unsigned();
            $table->foreign('leaves_id')->references('id')->on('leaves');
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
        Schema::table('leave_employees', function (Blueprint $table) {
            $table->dropForeign('leaves_id'); 
            $table->dropForeign('employees_id'); 
        });
        
        Schema::dropIfExists('leave_employees');
    }
}
