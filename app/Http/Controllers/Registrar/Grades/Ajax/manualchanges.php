<?php

namespace App\Http\Controllers\Registrar\Grades\Ajax;

use Illuminate\Support\Facades\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;

class manualchanges extends Controller {

    //
    function listsubjectcollege($instructor) {
        if (Request::ajax()) {
            $period = Input::get('period');
            $school_year = Input::get('school_year');
            
            $courses = \App\CourseOffering::where('instructor_id', $instructor)->where('school_year',$school_year)->where('period',$period)->get();
            
            $data = "<table class=\"table table-condensed\">"
                    . "<thead><tr><th>Course Code</th><th>Course Name</th><th>Course/Section</th></tr></th></thead><tbody>";
            foreach($courses as $course){
                $data = $data . "<tr><td>" .$course->course_code . "</td>"
                        . "<td><a href=".url('registrar', array('liststudents', 'manualchange_college',$course->id)).">" . $course->course_name . "</a></td>"
                        . "<td>" . $course->level. " Year ". $course->program_code ." - Section " .$course->section . "</td></tr>";
            }
            $data = $data . "</tbody></table>";
            return ($data);
        }
    }
    function changeprelim($id, $grade){
        if (Request::ajax()) {
            $changegrade = \App\GradeCollege::find($id);
            $changegrade->prelim = $grade;
            $changegrade->save();
        }
    }
    function changemidterm($id, $grade){
        if (Request::ajax()) {
            $changegrade = \App\GradeCollege::find($id);
            $changegrade->midterm = $grade;
            $changegrade->save();
        }
    }
    function changefinal($id, $grade){
        if (Request::ajax()) {
            $changegrade = \App\GradeCollege::find($id);
            $changegrade->final = $grade;
            $changegrade->save();
        }
    }
}
