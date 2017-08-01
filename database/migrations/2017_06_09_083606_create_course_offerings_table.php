<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCourseOfferingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('course_offerings', function (Blueprint $table) {
            $table->increments('id');
            $table->string('program_code');
            $table->string('track');
            $table->string('course_code');
            $table->string('course_name');
            $table->string('section')->default(1);
            $table->string('school_year');
            $table->string('period');
            $table->integer('lec');
            $table->integer('lab')->nullable();
            $table->decimal('hours', 5,2)->nullable();
            $table->string('level');
            $table->string('course_type');
            $table->string('percent_tuition');
            $table->integer('instructor_id')->nullable();
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
        Schema::dropIfExists('course_offerings');
    }
}
