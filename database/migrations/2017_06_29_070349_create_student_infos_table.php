<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStudentInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('student_infos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('idno');
            $table->string('course');
            $table->string('major')->nullable();
            $table->string('course2');
            $table->string('major2')->nullable();
            $table->string('birthdate');
            $table->string('civil_status');
            $table->string('address')->nullable();
            $table->string('contact_no')->nullable();
            $table->string('last_school')->nullable();
            $table->string('year_graduated')->nullable();
            $table->string('gen_ave')->nullable();
            $table->string('honor')->nullable();
            $table->string('is_transferee');
            $table->string('school')->nullable();
            $table->string('prev_course')->nullable();
            $table->string('status_upon_admission');
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
        Schema::dropIfExists('student_infos');
    }
}
