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
            $table->string('reference_id');
            $table->string('receipt_no')->nullable();
            $table->string('acknowledgement_no')->nullable();
            $table->string('idno');
            $table->string('category');
            $table->string('description');
            $table->string('receipt_details');
            $table->string('accounting_code')->nullable();
            $table->string('category_switch');
            $table->integer('payment_type')->default(0);
            $table->string('bank_name')->nullable();
            $table->string('check_number')->nullable();
            $table->decimal('cash_amount',10,2)->default(0);
            $table->decimal('check_amount',10,2)->default(0);
            $table->decimal('chnage_amount',10,2)->default(0);
            $table->integer('isreverse')->default(0);
            $table->integer('is_new')->default(1);
            $table->string('school_year')->nullable();
            $table->string('period')->nullable();
            $table->string('remarks')->nullable();
            $table->string('posted_by');
            $table->timestamps();
            $table->foreign('idno')
                    ->references('idno')
                    ->on('users')
                    ->onUpdate('cascade');
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
