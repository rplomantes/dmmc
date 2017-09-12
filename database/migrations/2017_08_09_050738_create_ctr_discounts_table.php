<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCtrDiscountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ctr_discounts', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('discount_code')->unique();
            $table->string('discount_description');
            $table->string('accounting_code')->nullable();
            $table->integer('other_fee');
            $table->integer('system_fee');
            $table->integer('special_fee');
            $table->integer('tuition_fee');
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
        Schema::dropIfExists('ctr_discounts');
    }
}
