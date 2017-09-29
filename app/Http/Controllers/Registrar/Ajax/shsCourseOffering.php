<?php

namespace App\Http\Controllers\Registrar\Ajax;

use Illuminate\Support\Facades\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use DB;

class shsCourseOffering extends Controller {

    function getList($track, $curriculum_year, $level) {
        if (Request::ajax()) {
            $lists = DB::select("SELECT * FROM `curricula` WHERE `curriculum_year` = $curriculum_year AND `track` LIKE '$track' AND `level` LIKE '$level' AND `is_current` = 1 order by `period`");
            return view('registrar.ajax.shs_getlist', compact('lists', 'track', 'curriculum_year', 'level'));
        }
    }

    function getCourseOffered($track, $curriculum_year, $level, $section) {
        if (Request::ajax()) {
            $school_year = \App\CtrSchoolYear::where('academic_type', 'Senior High School')->first();
            $sections = \App\CourseDetailsShs::distinct()->where('track', $track)->where('level', $level)->where('section', $section)->get(['section']);
            return view('registrar.ajax.shs_getcourseoffering', compact('sections', 'track', 'curriculum_year', 'level', 'school_year'));
        }
    }

    function getsubject($track, $curriculum_year, $level, $section, $course_code) {
        $course_name = \App\Curriculum::distinct()->where('course_code', $course_code)->get(['course_name', 'course_code'])->first();
        $course_details = \App\Curriculum::where('course_code', $course_code)->where('track', $track)->where('is_current', 1)->first();
        $school_year = \App\CtrSchoolYear::where('academic_type', 'Senior High School')->first();
        $counter = \App\CourseDetailsShs::where('course_code', $course_code)->where('track', $track)->where('school_year', $school_year->school_year)->where('level', $level)->where('section', $section)->get();
        
        if (Request::ajax()) {
            if (count($counter) == 0) {
                    $addsubject = new \App\CourseDetailsShs;
                    $addsubject->course_code = $course_code;
                    $addsubject->course_name = $course_name->course_name;
                    $addsubject->section = $section;
                    $addsubject->hours = $course_details->hours;
                    $addsubject->school_year = $school_year->school_year;
                    $addsubject->period = $course_details->period;
                    $addsubject->track = $track;
                    $addsubject->level = $level;
                    $addsubject->course_type = $course_details->course_type;
                    $addsubject->save();
            } else {
                
            }
            return $this->getCourseOffered($track, $curriculum_year, $level, $section);
        }
    }

    function removeSubject($id) {

        if (Request::ajax()) {
            $track = Input::get("track");
            $curriculum_year = Input::get("curriculum_year");
            $section = Input::get("section");
            $level = Input::get("level");


            $removesubject = \App\CourseDetailsShs::find($id);
            $removesubject->delete();

            return $this->getCourseOffered($track, $curriculum_year, $level, $section);
        }
    }

    function addAllSubjects() {

        if (Request::ajax()) {
            $track = Input::get("track");
            $curriculum_year = Input::get("curriculum_year");
            $section = Input::get("section");
            $level = Input::get("level");
            $course_code= Input::get("course_code");

            $school_year = \App\CtrSchoolYear::where('academic_type', 'Senior High School')->first();
            

            $curriculums = \App\Curriculum::where("curriculum_year", $curriculum_year)
                            ->where("track", $track)
                            ->where("level", $level)->get();

            if (count($curriculums) > 0) {
                foreach ($curriculums as $curriculum) {
                    $counter = \App\CourseDetailsShs::where('course_code', $curriculum->course_code)->where('school_year', $school_year->school_year)->where('track', $curriculum->track)->where('level', $curriculum->level)->where('section', $section)->first();
                    if (count($counter) == 0) {
                        $addsubject = new \App\CourseDetailsShs;
                        $addsubject->course_code = $curriculum->course_code;
                        $addsubject->course_name = $curriculum->course_name;
                        $addsubject->section = $section;
                        $addsubject->hours = $curriculum->hours;
                        $addsubject->school_year = $school_year->school_year;
                        $addsubject->period = $curriculum->period;
                        $addsubject->track = $track;
                        $addsubject->level = $level;
                        $addsubject->course_type = $curriculum->course_type;
                        $addsubject->save();
                    }
                }
            }
            return $this->getCourseOffered($track, $curriculum_year, $level, $section);
        }
    }
    function getsection($level){
        if (Request::ajax()) {
            $track = Input::get("track");
            $school_year = \App\CtrSchoolYear::where('academic_type', "Senior High School")->first();
            $sections = \App\SectionShs::where('level',$level)->where('track', $track)->where('school_year', $school_year->school_year)->get();
            $data = "<select class=\"form form-control\"><option value=\"\">Select Section</option>";
            foreach ($sections as $section){
                $data = $data."<option value='".$section->section."'>".$section->section."</option>";
            }
            $data = $data."</select>";
            return $data;
        }
    }
}
