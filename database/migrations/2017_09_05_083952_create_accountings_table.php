<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAccountingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accountings', function (Blueprint $table) {
            $table->increments('id');
            $table->date('transaction_date');
            $table->integer('refid')->nullable();
            $table->string('reference_id');
            $table->string('receipt_no');
            $table->string('idno');
            $table->string('paid_by');
            $table->string('category');
            $table->string('description');
            $table->string('receipt_details');
            $table->string('accounting_code')->nullable();
            $table->string('category_switch');
            $table->integer('entry_type');
            $table->decimal('debit',10,2)->default(0);
            $table->decimal('credit',10,2)->default(0);
            $table->string('particular')->nullable();
            $table->integer('isreverse')->default(0);
            $table->integer('is_new')->default(1);
            $table->string('school_year')->nullable();
            $table->string('period')->nullable();
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
        Schema::dropIfExists('accountings');
    }
}
