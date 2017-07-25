<?php

namespace App\Http\Controllers\Registrar\Ajax;

use Illuminate\Support\Facades\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;

class collegeAssignInstructor extends Controller {

    function getcourses() {
        if (Request::ajax()) {

            $course = Input::get("course");
            $section = Input::get("section");
            $level = Input::get("level");
            $school_year = Input::get("school_year");
            $period = Input::get("period");

            $courses = \App\CourseOffering::where('program_code', $course)
                    ->where('school_year', $school_year)
                    ->where('section', $section)
                    ->where('level', $level)
                    ->where('period', $period)
                    ->get();

            return view('registrar.ajax.college_getcourseoffering_instructor', compact('courses'));
        }
    }

    function addcourses($id) {
        if (Request::ajax()) {
            $course = Input::get("course");
            $section = Input::get("section");
            $level = Input::get("level");
            $school_year = Input::get("school_year");
            $period = Input::get("period");
            
            $instructor_id = Input::get("instructor_id");

            $addcoursetoinstructor = \App\CourseOffering::find($id);
            $addcoursetoinstructor->instructor_id = $instructor_id;
            $addcoursetoinstructor->save();
            
            return view('registrar.ajax.college_existingloads', compact('instructor_id'));
        }
    }
    
    function removecourses($id) {
        if (Request::ajax()) {
            $course = Input::get("course");
            $section = Input::get("section");
            $level = Input::get("level");
            $school_year = Input::get("school_year");
            $period = Input::get("period");
            
            $instructor_id = Input::get("instructor_id");

            $addcoursetoinstructor = \App\CourseOffering::find($id);
            $addcoursetoinstructor->instructor_id = null;
            $addcoursetoinstructor->save();
            
            return view('registrar.ajax.college_existingloads', compact('instructor_id'));
        }
    }
    

}
