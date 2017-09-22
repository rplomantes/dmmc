<?php

namespace App\Http\Controllers\Guidance\Admission;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
Use Illuminate\Support\Facades\DB;
use App\User;
use App\StudentInfo;
use App\Status;

class NewStudentController extends Controller {

    //
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    function newstudent() {
        $programs = DB::Select("Select distinct program_code ,program_name from ctr_academic_programs where academic_type='College'");
        return view('guidance.admission.newstudent', compact('programs'));
    }

    function newstudent_shs() {
        $programs = DB::Select("Select distinct track from ctr_academic_programs where academic_type='Senior High School'");
        return view('guidance.admission.newstudent_shs', compact('programs'));
    }

    function addapplicant(Request $request) {
        $this->validate($request, [
            'lastname' => 'required',
            'firstname' => 'required',
            'course' => 'required',
            'email' => 'required',
            'birthdate' => 'required',
            'address' => 'required',
            'contact_no' => 'required',
            'gender' => 'required',
        ]);

        return $this->createapplicant($request);
    }

    function createapplicant($request) {
        $user = new User;

        $idno = $user->idno = $request->refno;
        $user->lastname = $request->lastname;
        $user->firstname = $request->firstname;
        $user->middlename = $request->middlename;
        $user->extensionname = $request->extensionname;
        $user->email = $request->email;
        $user->isactive = 0;
        $user->accesslevel = 0;
        $user->password = "";
        $user->academic_program = "";

        $user->save();

        if ($request->status_upon_admission != "Transferee") {
            $is_transferee = 0;
            $name_of_school = NULL;
            $prev_course = NULL;
        } else {
            $is_transferee = 1;
            $name_of_school = $request->name_of_school;
            $prev_course = $request->prev_course;
        }

        
        $student_info = new StudentInfo;

        $student_info->idno = $idno;
        $course = $student_info->course = $request->course;
        $student_info->course2 = $request->course2;
        $student_info->birthdate = $request->birthdate;
        $student_info->civil_status = $request->civil_status;
        $student_info->gender= $request->gender;
        $student_info->address = $request->address;
        $student_info->contact_no = $request->contact_no;
        $student_info->last_school = $request->last_school_attended;
        $student_info->year_graduated = $request->year_graduated;
        $student_info->gen_ave = $request->gen_ave;
        $student_info->honor = $request->honors_received;
        $student_info->is_transferee = $is_transferee;
        $student_info->school = $name_of_school;
        $student_info->prev_course = $prev_course;
        $student_info->status_upon_admission = $request->status_upon_admission;

        $student_info->save();

        $status = new Status;

        $status->idno = $idno;
        $status->isnew = 1;
        $status->status = 0;
        $status->academic_type = "";
        $status->academic_program = $this->getAcademicProgram($course);
        $status->academic_type = $this->getAcademicType($course);
        $status->program_code = $this->getProgramCode($course);
        $status->program_name = $this->getProgramName($course);
        $status->level = "";
        $status->section = "";
        $status->track = "";
        $status->strand = "";
        $status->batch = 0;
        $status->school_year = "";
        $status->period = "";
        $status->class_no = 0;
        $status->plan = "";
        $status->isesc = 0;
        $status->remarks = "";

        $status->save();

        return redirect("guidance/viewinfo/$idno");
    }

    function getAcademicProgram($course) {
        if ($course == 'ABM' or $course == 'STEM' or $course == 'GAS' or $course == 'HUMMS') {
            $academic_program = \App\CtrAcademicProgram::where('track', $course)->first();
            return $academic_program->academic_program;
        } else {
            $academic_program = \App\CtrAcademicProgram::where('program_code', $course)->first();
            return $academic_program->academic_program;
        }
    }

    function getAcademicType($course) {
        if ($course == 'ABM' or $course == 'STEM' or $course == 'GAS' or $course == 'HUMMS') {
            $academic_program = \App\CtrAcademicProgram::where('track', $course)->first();
            return $academic_program->academic_type;
        } else {
            $academic_program = \App\CtrAcademicProgram::where('program_code', $course)->first();
            return $academic_program->academic_type;
        }
    }
    
    function getProgramCode($course) {
        if ($course == 'ABM' or $course == 'STEM' or $course == 'GAS' or $course == 'HUMMS') {
            $academic_program = \App\CtrAcademicProgram::where('track', $course)->first();
            return $academic_program->program_code;
        } else {
            $academic_program = \App\CtrAcademicProgram::where('program_code', $course)->first();
            return $academic_program->program_code;
        }
    }
    
    function getProgramName($course) {
        if ($course == 'ABM' or $course == 'STEM' or $course == 'GAS' or $course == 'HUMMS') {
            $academic_program = \App\CtrAcademicProgram::where('track', $course)->first();
            return $academic_program->program_name;
        } else {
            $academic_program = \App\CtrAcademicProgram::where('program_code', $course)->first();
            return $academic_program->program_name;
        }
    }

}
