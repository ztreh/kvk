<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServiceCenterCommisionItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service_center_commision_items', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('service_center_commision_id')->default(0);
            $table->decimal('commition_percentage', 10, 2)->default(0.00);
            $table->decimal('commision_value', 10, 2)->default(0.00);
            $table->integer('employee_id')->default(0);
            $table->timestamps();
        });
    }
    // employee id 
    // commision percentage 
    // commision value



    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('service_center_commision_items');
    }
}
