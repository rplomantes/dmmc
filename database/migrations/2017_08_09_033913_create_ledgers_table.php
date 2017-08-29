<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLedgersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ledgers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('idno');
            $table->string('program_code');
            $table->string('level');
            $table->string('school_year');
            $table->string('period');
            $table->string('category');
            $table->string('description');
            $table->string('receipt_details');
            $table->string('acccounting_code')->nullable();
            $table->string('category_switch');
            $table->decimal('amount',10,2);
            $table->decimal('payment',10,2)->default(0);
            $table->decimal('discount',10,2)->default(0);
            $table->integer('discount_id')->nullable();
            $table->integer('is_final')->default(0);
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
        Schema::dropIfExists('ledgers');
    }
}
