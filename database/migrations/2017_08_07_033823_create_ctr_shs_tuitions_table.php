<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCtrShsTuitionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ctr_shs_tuitions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('track');
            $table->string('level');
            $table->string('period');
            $table->decimal('amount',7,2);
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
        Schema::dropIfExists('ctr_shs_tuitions');
    }
}
