<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSlipsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('slips', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('employee_id');
            $table->integer('salary_month_id');
            $table->integer('employee_salary_type');
            $table->integer('ot_availability');
            $table->integer('epf_availability');
            $table->integer('is_paid')->default(0);
            $table->decimal('basic_salary', 10, 2);
            $table->time('work_start_time');
            $table->time('work_off_time');
            $table->date('date_paid');
            $table->decimal('monthly_salary', 10, 2);
            $table->decimal('per_day_salary', 10, 2);
            $table->decimal('ot_rate', 10, 2);
            $table->decimal('attendance_incentive', 10, 2);
            $table->decimal('allowance_per_day', 10, 2);
            $table->decimal('welfare', 10, 2);
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
        Schema::dropIfExists('slips');
    }
}
