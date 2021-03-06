<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCtrShsOtherFeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ctr_shs_other_fees', function (Blueprint $table) {
            $table->increments('id');
            $table->string('track');
            $table->string('level');
            $table->string('period');
            $table->string('category');
            $table->string('description');
            $table->string('receipt_details');
            $table->string('accounting_code')->nullable();
            $table->string('category_switch');
            $table->string('receipt_type')->default("OR");
            $table->decimal('amount',10,2);
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
        Schema::dropIfExists('ctr_shs_other_fees');
    }
}
