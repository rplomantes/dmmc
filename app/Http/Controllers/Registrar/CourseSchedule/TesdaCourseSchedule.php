<?php

namespace App\Http\Controllers\Registrar\CourseSchedule;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Schedule;

class TesdaCourseSchedule extends Controller {

    public function __construct() {
        $this->middleware('auth');
    }

    function index() {
        if (Auth::user()->accesslevel == "3") {
            $school_year = \App\CtrSchoolYear::where('academic_type', 'TESDA')->first();
            $program_codes = \App\CourseOffering::distinct()->where('school_year', $school_year->school_year)->where('period', $school_year->period)->where('program_code', 'BES-NCII')->get(['program_code']);
            return view('registrar.courseschedule.tesdaindex', compact('program_codes', 'school_year'));
        }
    }

    function listcourseschedule($id) {

        if (Auth::user()->accesslevel == "3") {

            $schedules = \App\Schedule::where('course_offering_id', $id)->get();
            $course_offering = \App\CourseOffering::where('id', $id)->first();

            return view('registrar.courseschedule.tesdalistschedule', compact('schedules', 'course_offering'));
        }
    }

}
