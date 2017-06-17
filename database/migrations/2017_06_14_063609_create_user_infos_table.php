<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_infos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('studentID')->unique();
            $table->string('contactNo');
            $table->string('street');
            $table->string('brgy');
            $table->string('city/town');
            $table->string('province');
            $table->string('country');
            $table->string('zipcode');
            $table->string('birthday');
            $table->string('birthplace');
            $table->string('citizenship');
            $table->string('civilStat');
            $table->string('religion');
            $table->string('lrn');
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
        Schema::dropIfExists('user_infos');
    }
}
