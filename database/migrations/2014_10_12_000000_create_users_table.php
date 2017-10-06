<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('idno')->unique();
            $table->string('old_idno')->nullable();
            $table->string('lastname');
            $table->string('middlename')->nullable();
            $table->string('firstname');
            $table->string('extensionname')->nullable();
            $table->string('email');
            $table->integer('accesslevel')->default(0);
            $table->integer('isactive')->default(1);
            $table->string('password')->nullable();
            $table->string('academic_program');
            $table->string('branch')->nullable();
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
        Schema::dropIfExists('users');
    }
}
