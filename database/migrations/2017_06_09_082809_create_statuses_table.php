<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStatusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('statuses', function (Blueprint $table) {
            $table->increments('id');
            $table->string('idno');
            $table->date('date_assessed');
            $table->date('date_enrolled');
            $table->date('date_dropped');
            $table->integer('is_new')->default(0);
            $table->integer('status');
            $table->string('academic_type');
            $table->string('academic_program');
            $table->string('grade_level');
            $table->string('section');
            $table->string('track');
            $table->string('strand');
            $table->integer('batch');
            $table->string('school_year');
            $table->string('period');
            $table->integer('class_no');
            $table->string('plan');
            $table->integer('isesc')->default(0);
            $table->string('remarks');
            $table->foreign('idno')
                ->references('idno')->on('users')
                ->onDelete('cascade');
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
        Schema::dropIfExists('statuses');
    }
}
