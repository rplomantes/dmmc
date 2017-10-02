<?php

namespace App\Http\Controllers\Registrar\Ajax;

use Illuminate\Support\Facades\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;

class shsAssignInstructor extends Controller {

    function getLevel($level, $track){
        if (Request::ajax()) {
            $school_year = \App\CtrSchoolYear::where('academic_type', "Senior High School")->first();
            $sections = \App\SectionShs::where('level',$level)->where('school_year', $school_year->school_year)->where('track', $track)->get();
            $data = "<select class=\"form form-control\"><option value=\"\">Select Section</option>";
            foreach ($sections as $section){
                $data = $data."<option value='".$section->section."'>".$section->section."</option>";
            }
            $data = $data."</select>";
            return $data;
        }
    }
    
    function getcourses() {
        if (Request::ajax()) {

            $track = Input::get("track");
            $section = Input::get("section");
            $level = Input::get("level");
            $school_year = Input::get("school_year");
            $period = Input::get("period");

            $courses = \App\CourseDetailsShs::where('track', $track)
                    ->where('school_year', $school_year)
                    ->where('section', $section)
                    ->where('level', $level)
                    ->where('period', $period)
                    ->get();

            return view('registrar.ajax.shs_getcourseoffering_instructor', compact('courses'));
        }
    }

    function addcourses($id) {
        if (Request::ajax()) {
            $track = Input::get("track");
            $section = Input::get("section");
            $level = Input::get("level");
            $school_year = Input::get("school_year");
            $period = Input::get("period");
            
            $instructor_id = Input::get("instructor_id");

            $addcoursetoinstructor = \App\CourseDetailsShs::find($id);
            $addcoursetoinstructor->instructor_id = $instructor_id;
            $addcoursetoinstructor->save();
            
            return view('registrar.ajax.shs_existingloads', compact('instructor_id'));
        }
    }
    
    function removecourses($id) {
        if (Request::ajax()) {            
            $instructor_id = Input::get("instructor_id");

            $addcoursetoinstructor = \App\CourseDetailsShs::find($id);
            $addcoursetoinstructor->instructor_id = null;
            $addcoursetoinstructor->save();
            
            return view('registrar.ajax.shs_existingloads', compact('instructor_id'));
        }
    }
    

}
