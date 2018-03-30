<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSalarySessionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('salary__sessions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable();
            $table->year('year');
            $table->integer('month');
            $table->date('start_date');
            $table->date('end_date');
            $table->tinyInteger('status')->default(0)->comment('0 office 1 site');
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
        Schema::dropIfExists('salary__sessions');
    }
}
