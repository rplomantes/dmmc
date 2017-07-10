<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCollegeTuitionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('college_tuitions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('program_code');
            $table->string('level');
            $table->string('period');
            $table->decimal('per_unit',10,2);
            $table->decimal('per_hour',10,2);
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
        Schema::dropIfExists('college_tuitions');
    }
}
