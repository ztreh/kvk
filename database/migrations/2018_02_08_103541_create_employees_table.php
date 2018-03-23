<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('address_current',255);
            $table->string('address_temperary',255);
            $table->string('telephone_no_1');
            $table->string('telephone_no_2');
            $table->string('telephone_no_3');
            $table->string('driving_license_no');
            $table->string('nic_no');
            $table->integer('category_id');
            $table->integer('designation_id');
            $table->date('birth_day');
            $table->string('finger_print_no');
            $table->integer('employee_salary_type');
            $table->integer('ot_availability');
            $table->integer('epf_availability');
            $table->date('date_joined');
            $table->decimal('basic_salary', 10, 2);
            $table->time('work_start_time');
            $table->time('work_off_time');
            $table->decimal('monthly_salary', 10, 2);
            $table->decimal('per_day_salary', 10, 2);
            $table->decimal('ot_rate', 10, 2);
            $table->decimal('attendance_incentive', 10, 2);
            $table->decimal('allowance_per_day', 10, 2);
            $table->decimal('welfare', 10, 2);
            $table->string('epf_no', 10, 2);
            $table->text('qualification');
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
        Schema::dropIfExists('employees');
    }
}
