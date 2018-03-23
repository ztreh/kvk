<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServiceCenterCommisionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service_center_commisions', function (Blueprint $table) {
            $table->increments('id');
            $table->decimal('commition_percentage', 10, 2)->default(0.00);
            $table->decimal('commition_value', 10, 2)->default(0.00);
            $table->decimal('sale_amount', 10, 2)->default(0.00);
            $table->integer('salary_month_id')->default(0);
            $table->string('job_no',255)->nullable();;
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
        Schema::dropIfExists('service_center_commisions');
    }
}
