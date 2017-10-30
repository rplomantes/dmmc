<?php

namespace App\Http\Controllers\Registrar\Main;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use PDF;

class StudentList extends Controller {

    public function __construct() {
        $this->middleware('auth');
    }

    //
    function college() {
        if (Auth::user()->accesslevel == "3") {
            $academic_program = \Illuminate\Support\Facades\Auth::user()->academic_program;
            $levels = \App\CtrAcademicProgram::distinct()->where('academic_type', 'College')->orderBy('level', 'asc')->get(['level']);

                $program_codes = \App\CtrAcademicProgram::distinct()->where('academic_type', "College")->get(['program_code', 'program_name']);
                return view('registrar.main.studentlistcollege', compact('program_codes', 'levels', 'academic_program'));
        }
    }
    
    function shs() {
        if (Auth::user()->accesslevel == "3") {
            $academic_program = \Illuminate\Support\Facades\Auth::user()->academic_program;
            $levels = \App\CtrAcademicProgram::distinct()->where('academic_type', 'Senior High School')->orderBy('level', 'asc')->get(['level']);

                $program_codes = \App\CtrAcademicProgram::distinct()->where('academic_type', "Senior High School")->get(['track']);
                return view('registrar.main.studentlistshs', compact('program_codes', 'levels', 'academic_program'));
        }
    }

    function printStudentList_college($course_offering_id) {
        if (Auth::user()->accesslevel == "3") {
            $studentlists = \App\GradeCollege::where('course_offering_id', $course_offering_id)->join('users', 'users.idno', '=', 'grade_colleges.idno')->join('statuses', 'statuses.idno', '=', 'users.idno')->where('statuses.status', 4)->orderBy('users.lastname')->get();
            $offering_id = \App\CourseOffering::find($course_offering_id);
            $instructor = $this->getInstructorId($course_offering_id);

            $pdf = PDF::loadView('registrar.print.studentlistenrolled', compact('studentlists', 'offering_id', 'instructor'));
            return $pdf->stream("Student_List.pdf");
        }
    }

    function printStudentListshs($course_offering_id) {
        if (Auth::user()->accesslevel == "3") {
            $studentlists = \App\GradeShs::where('course_offering_id', $course_offering_id)->join('users', 'users.idno', '=', 'grade_shs.idno')->join('statuses', 'statuses.idno', '=', 'users.idno')->where('statuses.status', 4)->orderBy('users.lastname')->get();
            $offering_id = \App\CourseDetailsShs::find($course_offering_id);
            $instructor = $this->getInstructorIdShs($course_offering_id);

            $pdf = PDF::loadView('dean.print.studentlistenrolled', compact('studentlists', 'offering_id', 'instructor'));
            return $pdf->stream("Student_List.pdf");
        }
    }

    function getInstructorId($offeringid) {
        if (Auth::user()->accesslevel == "3") {
            $offering_id = \App\CourseOffering::find($offeringid);
            $instructor = \App\User::where('id', $offering_id->instructor_id)->first();

            if (count($instructor) > 0) {
                $data = $instructor->firstname . " " . $instructor->lastname . " " . $instructor->extensionname;
                return $data;
            } else {
                return "";
            }
        }
    }

    function getInstructorIdShs($offeringid) {
        if (Auth::user()->accesslevel == "3") {
            $offering_id = \App\CourseDetailsShs::find($offeringid);
            $instructor = \App\User::where('id', $offering_id->instructor_id)->first();

            if (count($instructor) > 0) {
                $data = $instructor->firstname . " " . $instructor->lastname . " " . $instructor->extensionname;
                return $data;
            } else {
                return "";
            }
        }
    }

}
