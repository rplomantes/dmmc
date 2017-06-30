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
            $table->string('birthdate');
            $table->string('civil_status');
            $table->string('address');
            $table->string('contact_no');
            $table->string('last_school');
            $table->string('year_graduated');
            $table->string('gen_ave');
            $table->string('honor');
            $table->string('is_transferee');
            $table->string('school');
            $table->string('prev_course');
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
