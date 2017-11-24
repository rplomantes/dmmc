<?php

namespace App\Http\Controllers\Registrar\Ajax;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
Use Illuminate\Support\Facades\DB;
use Request;

class clearance extends Controller {

    //
    function getSection($course, $level) {
        if (Request::ajax()) {
            if ($course == "ABM" or $course == "STEM" or $course == "GAS" or $course == "HUMMS"){
                $school_year = \App\CtrGradeSchoolYear::where('academic_type', 'Senior High School')->first();
                $sections = \App\SectionShs::where('level', $level)->where('track', $course)->where('school_year', $school_year->school_year)->get();
            } else {
                $school_year = \App\CtrSchoolYear::where('academic_type', 'College')->first();
                $sections = \App\CourseOffering::where('program_code', $course)->where('level', $level)->where('school_year', $school_year->school_year)->get();
            }
            $data  = "<option value=\'\' >Select Section</option>";
            foreach ($sections as $section){
                $data = $data . "<option value='". $section->section ."'>" . $section->section . "</option>";
            }
            return $data;
        }
    }
    
    function getSearch() {
        if (Request::ajax()) {
            $search = Input::get("search");
            $lists = DB::select("SELECT * FROM `users` join statuses on users.idno = statuses.idno join student_infos on student_infos.idno = users.idno where (users.lastname like '%$search%' or users.firstname like '%$search%' or users.idno like '%$search%')order by users.lastname asc");
            return view('registrar.forms.ajax.studentclearancelist', compact('lists'));
        }
    }

}
