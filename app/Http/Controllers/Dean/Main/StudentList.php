<?php

namespace App\Http\Controllers\Dean\Main;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use PDF;

class StudentList extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    //
    function index(){
        $academic_program = \Illuminate\Support\Facades\Auth::user()->academic_program;
        $levels = \App\CtrAcademicProgram::distinct()->where('academic_program', $academic_program)->orderBy('level', 'asc')->get(['level']);
        
        if ($academic_program=='Senior High School'){
            $program_codes = \App\CtrAcademicProgram::distinct()->where('academic_program', $academic_program)->get(['track']);
            return view('dean.main.studentlistshs', compact('program_codes','levels','academic_program'));
            
        } else {
            $program_codes = \App\CtrAcademicProgram::distinct()->where('academic_program', $academic_program)->get(['program_code','program_name']);
            return view('dean.main.studentlistcollege', compact('program_codes','levels','academic_program'));
            
        }
        
    }
    
    function printStudentList($course_offering_id){
        $studentlists = \App\GradeCollege::where('course_offering_id', $course_offering_id)->join('users', 'users.idno', '=', 'grade_colleges.idno')->join('statuses', 'statuses.idno', '=','users.idno')->where('statuses.status', 3)->orderBy('users.lastname')->get();
        $offering_id = \App\CourseOffering::find($course_offering_id);
        $instructor = $this->getInstructorId($course_offering_id);
        
        $pdf = PDF::loadView('dean.print.studentlistenrolled', compact('studentlists', 'offering_id', 'instructor'));
        return $pdf->stream("Student_List.pdf");
    }
    
    public function getInstructorId($offeringid){             
        $offering_id = \App\CourseOffering::find($offeringid);
        $instructor = \App\User::where('id', $offering_id->instructor_id)->first();

        if (count($instructor)>0){
        $data = $instructor->firstname." ".$instructor->lastname." ".$instructor->extensionname;
        return $data;
        }else {
            return "";
        }
    }
}
