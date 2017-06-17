<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCtrBasicDeptsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ctr_basic_depts', function (Blueprint $table) {
            $table->increments('id');
            $table->string('academic_type');
            $table->string('academic_program');
            $table->string('level');
            $table->string('track');
            $table->string('strand');
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
        Schema::dropIfExists('ctr_basic_depts');
    }
}
