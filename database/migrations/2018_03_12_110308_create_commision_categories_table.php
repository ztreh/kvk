<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommisionCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('commision_categories', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('commision_id')->nullable();
            $table->integer('designation_id')->nullable();
            $table->decimal('commision_percentage',10,2)->default(0.00);
            $table->decimal('commision_value',10,2)->default(0.00);
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
        Schema::dropIfExists('commision_categories');
    }
}
