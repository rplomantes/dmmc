<?php

namespace App\Http\Controllers\Registrar\CourseSchedule;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class SHSCourseSchedule extends Controller {

    public function __construct() {
        $this->middleware('auth');
    }

    function index() {
        if (Auth::user()->accesslevel == "3") {
            $school_year = \App\CtrGradeSchoolYear::where('academic_type', 'Senior High School')->first();
            $tracks = \App\CourseDetailsShs::distinct()->where('school_year', $school_year->school_year)->where('period', $school_year->period)->get(['track']);
            return view('registrar.courseschedule.shsindex', compact('tracks', 'school_year'));
        }
    }

    function listcourseschedule($id) {
        if (Auth::user()->accesslevel == "3") {

            $schedules = \App\ScheduleShs::where('course_offering_id', $id)->get();
            $course_offering = \App\CourseDetailsShs::where('id', $id)->first();

            return view('registrar.courseschedule.shslistschedule', compact('schedules', 'course_offering'));
        }
    }

}
