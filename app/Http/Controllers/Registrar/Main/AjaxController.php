<?php

namespace App\Http\Controllers\Registrar\Main;

use Illuminate\Support\Facades\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use DB;
use App\CourseOffering;

class AjaxController extends Controller {

    function getList($program_code, $curriculum_year, $period, $level) {
        if (Request::ajax()) {
            $lists = DB::select("SELECT * FROM `curricula` WHERE `curriculum_year` = $curriculum_year AND `program_code` LIKE '$program_code' AND `period` LIKE '$period' AND `level` LIKE '$level' AND `is_current` = 1");
            return view('registrar.ajax.getlist', compact('lists', 'program_code', 'curriculum_year', 'period', 'level'));
        }
    }

    function getCourseOffered($program_code, $curriculum_year, $period, $level, $section) {
        if (Request::ajax()) {
            $sections = \App\CourseOffering::distinct()->where('program_code', $program_code)->where('period', $period)->where('level', $level)->where('section', $section)->get(['section']);
            return view('registrar.ajax.getcourseoffering', compact('sections', 'program_code', 'curriculum_year', 'period', 'level'));
        }
    }

    function getsubject($program_code, $curriculum_year, $period, $level, $section, $course_code) {
        $course_name = \App\Curriculum::distinct()->where('course_code', $course_code)->get(['course_name', 'course_code'])->first();
        $counter = \App\CourseOffering::where('course_code', $course_code)->where('program_code', $program_code)->where('period', $period)->where('level', $level)->where('section', $section)->get();
        if (Request::ajax()) {
            if (count($counter) == 0) {
                $addsubject = new CourseOffering;
                $addsubject->program_code = $program_code;
                $addsubject->course_code = $course_code;
                $addsubject->course_name = $course_name->course_name;
                $addsubject->section = $section;
                $addsubject->school_year = 2017;
                $addsubject->period = $period;
                $addsubject->units = 3;
                $addsubject->hours = 0.0;
                $addsubject->level = $level;
                $addsubject->course_type = 'none';
                $addsubject->instructor_id = 1;
                $addsubject->save();
            } else {
                
            }
            return $this->getCourseOffered($program_code, $curriculum_year, $period, $level, $section);
        }
    }

}
