<?php

namespace App\Http\Controllers\Guidance;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
Use Illuminate\Support\Facades\DB;
use App\User;
use App\StudentInfo;
use App\Status;
use Response;

class NewStudentController extends Controller
{
    //
    function newstudent(){
        $programs = DB::Select("Select distinct program_code, program_name from ctr_academic_programs");
        return view('guidance.newstudent',  compact('programs'));
    }
    
    function addapplicant(Request $request){
        $this->validate($request, [
            'lastname'=>'required',
            'firstname'=>'required',
            'course'=>'required',
            'course2'=>'required',
            'email'=>'required',
            'address'=>'required',
            'contact_no'=>'required',
            
        ]);
        
        return $this->createapplicant($request);
    }
    
    function createapplicant($request){
        $user = new User;
        
        $refno=$user->idno = $request->input('refno');
        $lastname=$user->lastname = $request->input('lastname');
        $firstname=$user->firstname = $request->input('firstname');
        $middlename=$user->middlename = $request->input('middlename');
        $extensionname=$user->extensionname = $request->input('extensionname');
        $user->email = $request->input('email');
        $user->isactive = 0;
        $user->accesslevel = 0;
        $user->password = "";
        
        $user->save();
        
        $student_info = new StudentInfo;
        
        $student_info->idno = $refno;
        $course1=$student_info->course = $request->input('course');
        $major1=$student_info->major = $request->input('major');
        $course2=$student_info->course2 = $request->input('course2');
        $major2=$student_info->major2 = $request->input('major2');
        $student_info->birthdate = "";
        $student_info->civil_status = "";
        $student_info->address = $request->input('address');
        $student_info->contact_no = $request->input('contact_no');
        $student_info->last_school = $request->input('last_school_attended');
        $student_info->year_graduated = $request->input('year_graduated');
        $student_info->gen_ave = $request->input('gen_ave');
        $student_info->honor = $request->input('honors_received');
        $student_info->is_transferee = 0;
        $student_info->school = $request->input('name_of_school');
        $student_info->prev_course = $request->input('prev_course');
        $student_info->status_upon_admission = $request->input('status_upon_admission');
        
        $student_info->save();
        
        $status = new Status;
        
        $status->idno = $refno;
        $status->isnew = 1;
        $status->status = 0;
        $status->academic_type = "";
        $status->academic_program = "";
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
            
        return view('guidance.studentinfo', compact('refno', 'lastname', 'firstname', 'middlename', 'extensionname', 'course1', 'major1', 'course2', 'major2'));
    }

    public function getMajor($course) {
        $data = DB::select("SELECT DISTINCT major FROM ctr_academic_programs WHERE program_code = '$course'");
        return Response::json($data);
    }
    public function getMajor2($course2) {
        $data = DB::select("SELECT DISTINCT major FROM ctr_academic_programs WHERE program_code = '$course2'");
        return Response::json($data);
    }
    
}