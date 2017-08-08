<?php

namespace App\Http\Controllers\Registrar\CourseSchedule;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Schedule;

class SHSCourseSchedule extends Controller {

    function index() {
        $school_year = \App\CtrSchoolYear::where('academic_type', 'Senior High School')->first();
        $tracks = \App\CourseOffering::distinct()->where('school_year', $school_year->school_year)->where('period', $school_year->period)->get(['track']);
        return view('registrar.courseschedule.shsindex', compact('tracks', 'school_year'));
    }

    function listcourseschedule($id) {

        $schedules = \App\Schedule::where('course_offering_id', $id)->get();
        $course_offering = \App\CourseOffering::where('id', $id)->first();
        
        return view('registrar.courseschedule.listschedule', compact('schedules', 'course_offering'));
    }

}
