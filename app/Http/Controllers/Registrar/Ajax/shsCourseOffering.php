<?php

namespace App\Http\Controllers\Registrar\Ajax;

use Illuminate\Support\Facades\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use DB;
use App\CourseOffering;

class shsCourseOffering extends Controller {

    function getList($track, $curriculum_year, $period, $level) {
        if (Request::ajax()) {
            $lists = DB::select("SELECT * FROM `curricula` WHERE `curriculum_year` = $curriculum_year AND `track` LIKE '$track' AND `period` LIKE '$period' AND `level` LIKE '$level' AND `is_current` = 1");
            return view('registrar.ajax.shs_getlist', compact('lists', 'track', 'curriculum_year', 'period', 'level'));
        }
    }

    function getCourseOffered($track, $curriculum_year, $period, $level, $section) {
        if (Request::ajax()) {
            $school_year = \App\CtrSchoolYear::where('academic_type', 'Senior High School')->first();
            $sections = \App\CourseOffering::distinct()->where('track', $track)->where('period', $school_year->period)->where('level', $level)->where('section', $section)->get(['section']);
            return view('registrar.ajax.shs_getcourseoffering', compact('sections', 'track', 'curriculum_year', 'period', 'level', 'school_year'));
        }
    }

    function getsubject($track, $curriculum_year, $period, $level, $section, $course_code) {
        $course_name = \App\Curriculum::distinct()->where('course_code', $course_code)->get(['course_name', 'course_code'])->first();
        $course_details = \App\Curriculum::where('course_code', $course_code)->where('track', $track)->where('is_current', 1)->first();
        $school_year = \App\CtrSchoolYear::where('academic_type', 'College')->first();
        $counter = \App\CourseOffering::where('course_code', $course_code)->where('track', $track)->where('period', $school_year->period)->where('school_year', $school_year->school_year)->where('level', $level)->where('section', $section)->get();
        
        if (Request::ajax()) {
            if (count($counter) == 0) {
                $addsubject = new CourseOffering;
                $addsubject->program_code = "Senior High School";
                $addsubject->track = $track;
                $addsubject->course_code = $course_code;
                $addsubject->course_name = $course_name->course_name;
                $addsubject->section = $section;
                $addsubject->school_year = $school_year->school_year;
                $addsubject->period = $school_year->period;
                $addsubject->lec = $course_details->lec;
                $addsubject->lab = $course_details->lab;
                $addsubject->hours = $course_details->hours;
                $addsubject->level = $level;
                $addsubject->course_type = $course_details->course_type;
                $addsubject->percent_tuition = $course_details->percent_tuition;
                $addsubject->save();
            } else {
                
            }
            return $this->getCourseOffered($track, $curriculum_year, $period, $level, $section);
        }
    }

    function removeSubject($id) {

        if (Request::ajax()) {
            $track = Input::get("track");
            $curriculum_year = Input::get("curriculum_year");
            $section = Input::get("section");
            $level = Input::get("level");
            $period = Input::get("period");


            $removesubject = \App\CourseOffering::find($id);
            $removesubject->delete();

            return $this->getCourseOffered($track, $curriculum_year, $period, $level, $section);
        }
    }

    function addAllSubjects() {

        if (Request::ajax()) {
            $track = Input::get("track");
            $curriculum_year = Input::get("curriculum_year");
            $section = Input::get("section");
            $level = Input::get("level");
            $period = Input::get("period");
            $course_code= Input::get("course_code");

            $school_year = \App\CtrSchoolYear::where('academic_type', 'Senior High School')->first();
            

            $curriculums = \App\Curriculum::where("curriculum_year", $curriculum_year)
                            ->where("period", $period)
                            ->where("track", $track)
                            ->where("level", $level)->get();

            if (count($curriculums) > 0) {
                foreach ($curriculums as $curriculum) {
                    $counter = \App\CourseOffering::where('course_code', $curriculum->course_code)->where('school_year', $school_year->school_year)->where('track', $curriculum->track)->where('period', $school_year->period)->where('level', $curriculum->level)->where('section', $section)->first();
                    if (count($counter) == 0) {
                        $addsubject = new CourseOffering;
                        $addsubject->program_code = "Senior High School";
                        $addsubject->track = $track;
                        $addsubject->course_code = $curriculum->course_code;
                        $addsubject->course_name = $curriculum->course_name;
                        $addsubject->section = $section;
                        $addsubject->school_year = $school_year->school_year;
                        $addsubject->period = $school_year->period;
                        $addsubject->lec = $curriculum->lec;
                        $addsubject->lab = $curriculum->lab;
                        $addsubject->hours = $curriculum->hours;
                        $addsubject->level = $level;
                        $addsubject->course_type = $curriculum->course_type;
                        $addsubject->percent_tuition = $curriculum->percent_tuition;
                        $addsubject->save();
                    }
                }
            }
            return $this->getCourseOffered($track, $curriculum_year, $period, $level, $section);
        }
    }
}
