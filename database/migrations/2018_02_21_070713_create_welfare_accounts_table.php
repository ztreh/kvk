<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWelfareAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('welfare_accounts', function (Blueprint $table) {
            $table->increments('id');
            $table->text('description');
            $table->integer('type')->default(0)->comment('1 = credit 2 =debit');
            $table->integer('salary_month_id')->default(0);
            $table->integer('employee_id')->default(0);
            $table->integer('status')->default(0)->comment('1 = cannot delete 0=can delete');
            $table->date('date');
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
        Schema::dropIfExists('welfare_accounts');
    }
}
