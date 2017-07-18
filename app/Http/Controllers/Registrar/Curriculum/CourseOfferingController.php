<?php

namespace App\Http\Controllers\Registrar\Curriculum;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

class CourseOfferingController extends Controller
{
    //
    function index(){
        $programs = \App\CtrAcademicProgram::distinct()->where('academic_type', 'College')->orWhere('academic_type', 'TESDA')->get(['program_code', 'program_name']);
        return view('registrar.curriculum.course_offering', compact('programs'));
    }
    
    function view($program_code){
        $programs = \App\Curriculum::where('program_code', $program_code)->where('is_current', 1)->get();
        return view('registrar.curriculum.view_course_offering', compact('programs', 'program_code'));
    }
}
