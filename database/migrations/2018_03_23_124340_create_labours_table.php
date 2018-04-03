<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLaboursTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('labours', function (Blueprint $table) {
            $table->increments('id');
            $table->tinyInteger('is_skill')->default(0)->comment('1 skill 0 unskill');
            $table->decimal('expected_rate', 10, 2)->default(0.00)->comment('expected rate per day');
            $table->integer('recomended_employee_id')->unsigned();
            // $table->foreign('recomended_employee_id')->references('id')
            // ->on('employees')->onDelete('cascade');
            
            $table->integer('employees_id')->unsigned();
            // $table->foreign('employees_id')->references('id')
            // ->on('employees')->onDelete('cascade');
            
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
        Schema::dropIfExists('labours');
    }
}
