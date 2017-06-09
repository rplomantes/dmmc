<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CtrAcademicProgram extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('CtrAcademicProgram', function (Blueprint $table) {
            $table->increments('id');
            $table->string('academicProgram');
            $table->string('departmentCode');
            $table->string('departmentName');
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
        Schema::dropIfExists('CtrAcademicProgram');
    }
}
