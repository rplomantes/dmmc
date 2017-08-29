<?php

namespace App\Http\Controllers\Registrar\CourseOffering;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

class SHSCourseOfferingController extends Controller
{
    //
    function index(){
        $tracks = \App\CtrAcademicProgram::distinct()->where('academic_type', 'Senior High School')->get(['program_code', 'track']);
        return view('registrar.courseoffering.shs_course_offering', compact('tracks'));
    }
    
    function view($track){
        $tracks = \App\Curriculum::where('track', $track)->where('is_current', 1)->get();
        return view('registrar.courseoffering.shs_view_course_offering', compact('tracks', 'track'));
    }
}
