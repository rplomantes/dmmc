<?php

namespace App\Http\Controllers\Registrar\CourseOffering;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use DB;

class TesdaCourseOfferingController extends Controller {

    public function __construct() {
        $this->middleware('auth');
    }

    //
    function index() {
        if (Auth::user()->accesslevel == "3") {
            $programs = \App\CtrAcademicProgram::distinct()->where('academic_type', 'TESDA')->get(['program_code', 'program_name']);
            return view('registrar.courseoffering.tesda_course_offering', compact('programs'));
        }
    }

    function view($program_code) {
        if (Auth::user()->accesslevel == "3") {
            $programs = \App\Curriculum::where('program_code', $program_code)->where('is_current', 1)->get();
            return view('registrar.courseoffering.tesda_view_course_offering', compact('programs', 'program_code'));
        }
    }

}
