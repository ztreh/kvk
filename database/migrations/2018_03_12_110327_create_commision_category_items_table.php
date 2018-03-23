<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommisionCategoryItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('commision_category_items', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('employee_id')->default(0);
            $table->integer('commision_category_id')->default(0);
            $table->integer('worked_days')->default(0);
            $table->decimal('commision_value')->default(0.00);
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
        Schema::dropIfExists('commision_category_items');
    }
}
