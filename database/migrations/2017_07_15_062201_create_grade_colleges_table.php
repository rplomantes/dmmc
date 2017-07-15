<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGradeCollegesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('grade_colleges', function (Blueprint $table) {
            $table->increments('id');
            $table->string('idno');
            $table->integer('course_offering_id');
            $table->string('course_code');
            $table->string('course_name');
            $table->decimal('prelim', 5,2);
            $table->decimal('midterm', 5,2);
            $table->decimal('final', 5,2);
            $table->decimal('final_grade', 5,2);
            $table->decimal('grade_point', 5,2);
            $table->string('remarks');
            $table->string('period');
            $table->string('school_year');
            $table->integer('is_lock')->default(0);
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
        Schema::dropIfExists('grade_colleges');
    }
}
