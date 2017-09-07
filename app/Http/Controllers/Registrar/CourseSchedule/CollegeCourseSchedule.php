<?php

namespace App\Http\Controllers\Registrar\CourseSchedule;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Schedule;

class CollegeCourseSchedule extends Controller {

    public function __construct()
    {
        $this->middleware('auth');
    }
    
    function index() {
        $school_year = \App\CtrSchoolYear::where('academic_type', 'College')->first();
        $program_codes = \App\CourseOffering::distinct()->where('school_year', $school_year->school_year)->where('period', $school_year->period)->where('program_code', '!=', 'Senior High School')->get(['program_code']);
        return view('registrar.courseschedule.index', compact('program_codes', 'school_year'));
    }

    function listcourseschedule($id) {

        $schedules = \App\Schedule::where('course_offering_id', $id)->get();
        $course_offering = \App\CourseOffering::where('id', $id)->first();
        
        return view('registrar.courseschedule.listschedule', compact('schedules', 'course_offering'));
    }

}
