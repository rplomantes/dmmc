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
            
            //choices of student
            $table->string('course');
            $table->string('course2')->nullable();
            
            //student information
            $table->string('birthdate');
            $table->string('place_of_birth')->nullable();
            $table->string('citizenship')->nullable();
            $table->string('civil_status')->nullable();
            $table->string('religion')->nullable();
            $table->string('gender')->nullable();
            $table->string('address')->nullable();
            $table->string('contact_no')->nullable();
            
            //last school attended
            $table->string('last_school')->nullable();
            $table->string('year_graduated')->nullable();
            $table->string('gen_ave')->nullable();
            $table->string('honor')->nullable();
            
            //if transferee
            $table->string('is_transferee')->nullable();
            $table->string('school')->nullable();
            $table->string('prev_course')->nullable();
            
            //curriculum year of student
            $table->string('curriculum_year')->nullable();
            
            $table->string('status_upon_admission');
            
            //educational background
            $table->string('primary');
            $table->string('pri_school');
            $table->string('pri_address');
            $table->string('pri_from');
            $table->string('pri_to');
            $table->string('pri_degree');
            $table->string('pri_awards');
            $table->string('pri_awards_year');
            $table->string('pri_lead');
            $table->string('pri_lead_year');
            $table->string('secondary');
            $table->string('sec_school');
            $table->string('sec_address');
            $table->string('sec_from');
            $table->string('sec_to');
            $table->string('sec_degree');
            $table->string('sec_awards');
            $table->string('sec_awards_year');
            $table->string('sec_lead');
            $table->string('sec_lead_year');
            $table->string('tertiary');
            $table->string('ter_school');
            $table->string('ter_address');
            $table->string('ter_from');
            $table->string('ter_to');
            $table->string('ter_degree');
            $table->string('ter_awards');
            $table->string('ter_awards_year');
            $table->string('ter_lead');
            $table->string('ter_lead_year');
            $table->string('vocational');
            $table->string('voc_school');
            $table->string('voc_address');
            $table->string('voc_from');
            $table->string('voc_to');
            $table->string('voc_degree');
            $table->string('others');
            $table->string('oth_school');
            $table->string('oth_address');
            $table->string('oth_from');
            $table->string('oth_to');
            $table->string('oth_degree');
            
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
