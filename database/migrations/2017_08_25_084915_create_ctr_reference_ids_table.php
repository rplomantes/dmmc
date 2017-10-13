<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCtrReferenceIdsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ctr_reference_ids', function (Blueprint $table) {
            $table->increments('id');
            $table->string('idno');
            $table->integer('student_no')->default(1);
            $table->integer('registration_no')->default(1);
            $table->integer('receipt_no')->default(1);
            $table->integer('acknowledgement_no')->default(1);
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
        Schema::dropIfExists('ctr_reference_ids');
    }
}
