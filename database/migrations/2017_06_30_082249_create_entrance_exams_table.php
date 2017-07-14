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
            $table->string('second_choice')->nullable();
            $table->string('exam_result')->nullable();
            $table->string('exam_description')->nullable();
            $table->string('exam_schedule');
            $table->string('date_issued');
            $table->string('issued_by');
            $table->string('graded_by')->nullable();
            $table->string('remarks')->nullable();
            $table->string('branch')->nullable();
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
