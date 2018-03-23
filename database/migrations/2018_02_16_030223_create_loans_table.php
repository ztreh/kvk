<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLoansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('loans', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('employee_id');
            $table->integer('loan_type_id');
            $table->decimal('loan_interest', 10, 2);
            $table->decimal('loan_amount', 10, 2);
            $table->decimal('value_of_a_installment', 10, 2);
            $table->integer('num_of_installments');
            $table->date('payment_start_date'); 
            $table->text('other_details');
            $table->integer('status')->default(0)->comment('0=not paid , 1= half paid , 2= full paid');
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
        Schema::dropIfExists('loans');
    }
}
