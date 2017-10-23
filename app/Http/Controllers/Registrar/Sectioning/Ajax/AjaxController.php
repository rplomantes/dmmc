<?php

namespace App\Http\Controllers\Registrar\Sectioning\Ajax;

use Illuminate\Support\Facades\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;

class AjaxController extends Controller
{
    //
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
//            return view('registrar.sectioning.ajax.getlevel', compact('sections'));
        }
    }
    function getStudentList($level, $track){
        if (Request::ajax()){
            $school_year = \App\CtrSchoolYear::where('academic_type', "Senior High School")->first();
            return view('registrar.sectioning.ajax.studentList', compact('level', 'school_year', 'track'));
        }
    }
    function getSectionList($section, $level){
        if (Request::ajax()){
            $school_year = \App\CtrSchoolYear::where('academic_type', "Senior High School")->first();
            $lists = \App\Status::where('section', $section)->where('level', $level)->where('status', 4)->where('school_year', $school_year->school_year)->get();
            return view('registrar.sectioning.ajax.sectionlist', compact('lists'));
        }   
    }
    function addtosection($idno){
        if (Request::ajax()){
            $level = Input::get("levels");
            $section = Input::get("section");
            $school_year = \App\CtrGradeSchoolYear::where('academic_type', "Senior High School")->first();
            
            $updatestatus = \App\Status::where('idno', $idno)->first();
            $updatestatus->section = $section;
            $updatestatus->save();
                        
            $updategradeshs = \App\GradeShs::where('idno', $idno)->where('school_year', $school_year->school_year)->where('period',$school_year->period)->get();
            foreach ($updategradeshs as $updatenow){
                $getcoursedetails = \App\CourseDetailsShs::where('course_code',$updatenow->course_code)->where('school_year', $updatenow->school_year)->where('period', $updatenow->period)->where('section', $section)->first();
                $updatenow->course_offering_id = $getcoursedetails->id;
                $updatenow->save();
            }
            
            
            $lists = \App\Status::where('section', $section)->where('level', $level)->where('status', 4)->where('school_year', $school_year->school_year)->get();
            return view('registrar.sectioning.ajax.sectionlist', compact('lists'));
            
        }
    }
    function removetosection($idno){
        if (Request::ajax()){
            $level = Input::get("levels");
            $section = Input::get("section");
            $school_year = \App\CtrGradeSchoolYear::where('academic_type', "Senior High School")->first();
            
            $updatestatus = \App\Status::where('idno', $idno)->first();
            $updatestatus->section = NULL;
            $updatestatus->save();
            
            $updategradeshs = \App\GradeShs::where('idno', $idno)->where('school_year',$school_year->school_year)->where('period', $school_year->period)->get();
            foreach($updategradeshs as $updatenow){
                $updatenow->course_offering_id = NULL;
                $updatenow->save();
            }
            
            $lists = \App\Status::where('section', $section)->where('level', $level)->where('status', 4)->where('school_year', $school_year->school_year)->get();
            return view('registrar.sectioning.ajax.sectionlist', compact('lists'));
            
        }        
    }
    function assignadviser($adviser){
        if (Request::ajax()){
            $level = Input::get("level");
            $section = Input::get("section");
            $track = Input::get("track");
            $school_year = \App\CtrSchoolYear::where('academic_type', "Senior High School")->first();
            
            if($adviser=="None"){
                $advisername = NULL;
                $adviser = NULL;
            }else{
                $user = \App\User::where('idno', $adviser)->first();
                $advisername = $user->firstname." ".$user->lastname." ".$user->extensionname;
            }
            
            $updatesection = \App\SectionShs::where('level', $level)->where('track', $track)->where('section', $section)->where('school_year', $school_year->school_year)->first();
            $updatesection->adviser_id = $adviser;
            $updatesection->adviser_name = $advisername;
            $updatesection->save();
            
        }
    }
}
