<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSlipFeaturesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('slip_features', function (Blueprint $table) {
            $table->increments('id');
            $table->string('description')->default('');
            $table->integer('salary_month_id')->default('0');
            $table->integer('employee_id')->default('0');
            $table->integer('feature_type')->comment('1 = allowance 2 =deduction')->default('0');
            $table->decimal('amount', 10, 2)->default('0.00');
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
        Schema::dropIfExists('slip_features');
    }
}
