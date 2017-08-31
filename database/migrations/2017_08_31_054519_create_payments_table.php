<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->increments('id');
            $table->date('transaction_date');
            $table->string('receipt_no');
            $table->string('idno');
            $table->string('category');
            $table->string('description');
            $table->string('receipt_details');
            $table->string('acccounting_code')->nullable();
            $table->string('category_switch');
            $table->decimal('amount',10,2);
            $table->integer('isreverse')->default(0);
            $table->string('posted_by');
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
        Schema::dropIfExists('payments');
    }
}
