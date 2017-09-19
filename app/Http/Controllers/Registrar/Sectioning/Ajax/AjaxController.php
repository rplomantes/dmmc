<?php

namespace App\Http\Controllers\Registrar\Sectioning\Ajax;

use Illuminate\Support\Facades\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;

class AjaxController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    function getLevel($level){
        if (Request::ajax()) {
            $school_year = \App\CtrSchoolYear::where('academic_type', "Senior High School")->first();
            $sections = \App\SectionShs::where('level',$level)->where('school_year', $school_year->school_year)->get();
            $data = "<select class=\"form form-control\"><option value=\"\">Select Section</option>";
            foreach ($sections as $section){
                $data = $data."<option>".$section->section."</option>";
            }
            $data = $data."</select>";
            return $data;
        }
    }
    function getStudentList($level){
        if (Request::ajax()){
            $school_year = \App\CtrSchoolYear::where('academic_type', "Senior High School")->first();
            return view('registrar.sectioning.ajax.studentList', compact('level', 'school_year'));
        }
    }
}
