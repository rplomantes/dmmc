<?php

namespace App\Http\Controllers\Guidance\Admission;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
Use Illuminate\Support\Facades\DB;
use App\User;
use App\StudentInfo;
use App\Status;

class NewStudentController extends Controller
{
    //
    function newstudent(){
        $programs = DB::Select("Select distinct program_code ,program_name from ctr_academic_programs");
        return view('guidance.admission.newstudent',  compact('programs'));
    }
    
    function addapplicant(Request $request){
        $this->validate($request, [
            'lastname'=>'required',
            'firstname'=>'required',
            'course'=>'required',
            'email'=>'required',
            'birthdate'=>'required',
            'address'=>'required',
            'contact_no'=>'required',
            
        ]);
        
        return $this->createapplicant($request);
    }
    
    function createapplicant($request){
        $user = new User;
        
        $idno=$user->idno = $request->input('refno');
        $user->lastname = $request->input('lastname');
        $user->firstname = $request->input('firstname');
        $user->middlename = $request->input('middlename');
        $user->extensionname = $request->input('extensionname');
        $user->email = $request->input('email');
        $user->isactive = 0;
        $user->accesslevel = 0;
        $user->password = "";
        
        $user->save();
        
        if ($request->input('name_of_school')==null){
            $is_transferee = 0;
        } else {
            $is_transferee = 1;
        };
        
        $student_info = new StudentInfo;
        
        $student_info->idno = $idno;
        $student_info->course = $request->input('course');
        $student_info->major = $request->input('major');
        $student_info->course2 = $request->input('course2');
        $student_info->major2 = $request->input('major2');
        $student_info->birthdate = $request->input('birthdate');
        $student_info->civil_status = $request->input('civil_status');
        $student_info->address = $request->input('address');
        $student_info->contact_no = $request->input('contact_no');
        $student_info->last_school = $request->input('last_school_attended');
        $student_info->year_graduated = $request->input('year_graduated');
        $student_info->gen_ave = $request->input('gen_ave');
        $student_info->honor = $request->input('honors_received');
        $student_info->is_transferee = $is_transferee;
        $student_info->school = $request->input('name_of_school');
        $student_info->prev_course = $request->input('prev_course');
        $student_info->status_upon_admission = $request->input('status_upon_admission');
        
        $student_info->save();
        
        $status = new Status;
        
        $status->idno = $idno;
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
           
        return app('App\Http\Controllers\Guidance\Admission\ListApplicantsController')->viewinfo($idno);
    }    
}