<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Curriculum extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('curriculum', function (Blueprint $table) {
            $table->increments('id');
            $table->string('curriculumCode')->unique();
            $table->string('curriculumName');
            $table->string('programCode');
            $table->string('programName');
            $table->string('coursecode');
            $table->string('coursename');
            $table->integer('units');
            $table->decimal('number_hours', 5,2);
            $table->string('yearLevel');
            $table->string('period');
            $table->string('courseType');
            $table->rememberToken();
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
        Schema::dropIfExists('curriculum');
    }
}
