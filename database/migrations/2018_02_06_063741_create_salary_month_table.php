<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSalaryMonthTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('salary_months', function (Blueprint $table) {
            $table->increments('id');
            $table->year('year');
            $table->integer('month');
            $table->date('start_date');
            $table->date('end_date');
            $table->decimal('budget_allowance', 10, 2);
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
        Schema::dropIfExists('salary_months');
    }
}
