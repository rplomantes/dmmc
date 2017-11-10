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
            $table->string('street')->nullable();
            $table->string('barangay')->nullable();
            $table->string('municipality')->nullable();
            $table->string('province')->nullable();
            $table->string('zip')->nullable();
            $table->string('contact_no')->nullable();
            $table->string('lrn')->nullable();
            
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
            
            $table->string('status_upon_admission')->nullable();
            
            //educational background
            $table->string('pri_school')->nullable();
            $table->string('pri_address')->nullable();
            $table->string('pri_from')->nullable();
            $table->string('pri_to')->nullable();
            $table->string('pri_degree')->nullable();
            $table->string('pri_awards')->nullable();
            $table->string('pri_awards_year')->nullable();
            $table->string('pri_lead')->nullable();
            $table->string('pri_lead_year')->nullable();
            $table->string('sec_school')->nullable();
            $table->string('sec_address')->nullable();
            $table->string('sec_from')->nullable();
            $table->string('sec_to')->nullable();
            $table->string('sec_degree')->nullable();
            $table->string('sec_awards')->nullable();
            $table->string('sec_awards_year')->nullable();
            $table->string('sec_lead')->nullable();
            $table->string('sec_lead_year')->nullable();
            $table->string('ter_school')->nullable();
            $table->string('ter_address')->nullable();
            $table->string('ter_from')->nullable();
            $table->string('ter_to')->nullable();
            $table->string('ter_degree')->nullable();
            $table->string('ter_awards')->nullable();
            $table->string('ter_awards_year')->nullable();
            $table->string('ter_lead')->nullable();
            $table->string('ter_lead_year')->nullable();
            $table->string('voc_school')->nullable();
            $table->string('voc_address')->nullable();
            $table->string('voc_from')->nullable();
            $table->string('voc_to')->nullable();
            $table->string('voc_degree')->nullable();
            $table->string('oth_school')->nullable();
            $table->string('oth_address')->nullable();
            $table->string('oth_from')->nullable();
            $table->string('oth_to')->nullable();
            $table->string('oth_degree')->nullable();
            
            //other information
            $table->string('hobbies')->nullable();
            $table->string('sports')->nullable();
            $table->string('talents')->nullable();
            
            //incase of emergency
            $table->string('emergency_contact_person')->nullable();
            $table->string('emergency_relationship')->nullable();
            $table->string('emergency_address')->nullable();
            $table->string('emergency_contact_no')->nullable();
            
            //requirements
            $table->string('form_138')->default(0);
            $table->string('form_137')->default(0);
            $table->string('psa_birth_cert')->default(0);
            $table->string('good_moral')->default(0);
            $table->string('transfer_credential')->default(0);
            $table->string('married_cert')->default(0);
            $table->string('id_picture')->default(0);
            
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
