<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCourseDetailsShsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('course_details_shs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('course_code');
            $table->string('course_name')->nullable();
            $table->string('section')->nullable();
            $table->string('instructor_id')->nullable();
            $table->string('school_year')->nullable();
            $table->string('period')->nullable();
            $table->string('track')->nullable();
            $table->string('level')->nullable();
            $table->string('course_type')->nullable();
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
        Schema::dropIfExists('course_details_shs');
    }
}
