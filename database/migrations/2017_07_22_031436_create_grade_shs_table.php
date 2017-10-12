<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGradeShsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('grade_shs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('idno');
            $table->integer('course_offering_id');
            $table->string('course_code');
            $table->string('course_name');
            $table->string('level');
            $table->decimal('hours', 5,2);
            $table->decimal('first_qtr', 5,2)->nullable();
            $table->decimal('second_qtr', 5,2)->nullable();
            $table->decimal('final_grade', 5,2)->nullable();
            $table->decimal('grade_point', 5,2)->nullable();
            $table->string('remarks')->nullable();
            $table->string('period');
            $table->string('school_year');
            $table->integer('is_lock')->default(0);
            $table->integer('is_drop')->default(0);
            $table->foreign('idno')
                ->references('idno')->on('users')
                ->onUpdate('cascade');
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
        Schema::dropIfExists('grade_shs');
    }
}
