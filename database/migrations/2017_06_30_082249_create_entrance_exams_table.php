<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEntranceExamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('entrance_exams', function (Blueprint $table) {
        $table->increments('id');
            $table->string('idno');
            $table->string('course_intended');
            $table->string('second_choice');
            $table->string('exam_result');
            $table->string('exam_description');
            $table->integer('exam_schedule');
            $table->integer('date_issued');
            $table->integer('issued_by');
            $table->integer('graded_by');
            $table->integer('remarks');
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
        Schema::dropIfExists('entrance_exams');
    }
}
