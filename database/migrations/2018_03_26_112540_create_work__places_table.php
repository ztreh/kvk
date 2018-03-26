<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWorkPlacesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('work__places', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name',150)->nullable();
            $table->string('address',255)->nullable();
            $table->string('tp_mobile',15)->nullable();
            $table->string('tp_land',15)->nullable();
            $table->date('start_date')->nullable(); 
            $table->date('end_date')->nullable(); 
            $table->tinyInteger('status')->default(0);
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
        Schema::dropIfExists('work__places');
    }
}
