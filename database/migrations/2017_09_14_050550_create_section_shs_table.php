<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSectionShsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('section_shs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('section');
            $table->string('track');
            $table->string('level');
            $table->string('school_year');
            $table->string('adviser_id')->nullable();
            $table->string('adviser_name')->nullable();
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
        Schema::dropIfExists('section_shs');
    }
}
