<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCtrCollegeTuitionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ctr_college_tuitions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('program_code');
            $table->string('level');
            $table->string('period');
            $table->decimal('per_unit',10,2)->nullable();
            $table->decimal('per_hour',10,2)->nullable();
            $table->string('branch')->nullable();
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
        Schema::dropIfExists('ctr_college_tuitions');
    }
}
