<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStatusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('statuses', function (Blueprint $table) {
            $table->increments('id');
            $table->string('idno');
            $table->date('date_assessed')->nullable();
            $table->date('date_enrolled')->nullable();
            $table->date('date_dropped')->nullable();
            $table->integer('isnew')->default(0);
            $table->integer('status');
            $table->string('academic_type')->nullable();
            $table->string('academic_program')->nullable();
            $table->string('program_code')->nullable();
            $table->string('program_name')->nullable();
            $table->string('level')->nullable();
            $table->string('section')->nullable();
            $table->string('track')->nullable();
            $table->string('strand')->nullable();
            $table->integer('batch')->nullable();
            $table->string('school_year')->nullable();
            $table->string('period')->nullable();
            $table->integer('class_no')->nullable();
            $table->string('plan')->nullable();
            $table->integer('isesc')->default(0);
            $table->string('branch')->nullable();
            $table->date('date_registered')->nullable();
            $table->string('registration_no')->nullable();
            $table->string('remarks');
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
        Schema::dropIfExists('statuses');
    }
}
