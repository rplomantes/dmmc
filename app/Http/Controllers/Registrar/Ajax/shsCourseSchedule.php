<?php

namespace App\Http\Controllers\Registrar\Ajax;

use Illuminate\Support\Facades\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use App\Schedule;

class shsCourseSchedule extends Controller {

    public function __construct()
    {
        $this->middleware('auth');
    }
    function getcourses($track) {
        if (Request::ajax()) {

            $school_year = Input::get("school_year");
            $period = Input::get("period");
            $section = Input::get("level");
            $level = Input::get("section");

            $courses = \App\CourseDetailsShs::where('track', $track)
                    ->where('school_year', $school_year)
                    ->where('section', $section)
                    ->where('level', $level)
                    ->where('period', $period)
                    ->get();
            
            return view('registrar.ajax.shs_getcourses', compact('courses'));
        }
    }

    function getexistingsched($room) {
        if (Request::ajax()) {

            $school_year = Input::get("school_year");
            $period = Input::get("period");

//            $schedules = \App\Schedule::join('course_offerings', 'course_offering_id', '=', 'course_offerings.id')
//                    ->where('course_offerings.school_year', $school_year)
//                    ->where('course_offerings.period', $period)
//                    ->where('room', $room)
//                    ->orderBy('course_code')
//                    ->get();
//            return view('registrar.ajax.college_getexistingsched', compact('schedules'));
            
            $courses = \App\ScheduleShs::distinct()->join('course_details_shs', 'course_offering_id', '=', 'course_details_shs.id')
                    ->where('course_details_shs.school_year', $school_year)
                    ->where('course_details_shs.period', $period)
                    ->where('room', $room)
                    ->orderBy('course_code')
                    ->get(['course_offering_id', 'course_code', 'course_name','track' ,'level', 'section']);
            
            return view('registrar.ajax.shs_getexistingsched', compact('courses', 'school_year', 'period', 'room'));
        }
    }

    function addschedule() {
        if (Request::ajax()) {
            
            $school_year = Input::get("school_year");
            $period = Input::get("period");
            $course_id = Input::get("course_offering_id");
            $room = Input::get("room");
            $day = Input::get("day");
            $time_start = Input::get("time_start");
            $time_end = Input::get("time_end");

            $addsched = new \App\ScheduleShs();
            $addsched->course_offering_id = $course_id;
            $addsched->room = "$room";
            $addsched->day = "$day";
            $addsched->time_start = "$time_start";
            $addsched->time_end = "$time_end";
            $addsched->save();
         
            $schedules = \App\ScheduleShs::where('course_offering_id', $course_id)->get();
        
        return view('registrar.ajax.shs_popsched', compact('schedules'));
        }
    }
    
    function changeroom($sched_id, $value){
        
        if (Request::ajax()) {
            
            $school_year = Input::get("school_year");
            $period = Input::get("period");
            $room = Input::get("room");
            
            $changeroom = \App\ScheduleShs::where('id', $sched_id)->first();
            $changeroom->room=$value;
            $changeroom->save();

        return $this->getexistingsched($room);
        }
    }
    
    function changeday($sched_id, $value){
        
        if (Request::ajax()) {
            
            $school_year = Input::get("school_year");
            $period = Input::get("period");
            $room = Input::get("room");
            
            $changeday = \App\ScheduleShs::where('id', $sched_id)->first();
            $changeday->day=$value;
            $changeday->save();

        return $this->getexistingsched($room);

        }
    }
    
    function changetime_start($sched_id, $value){
        
        if (Request::ajax()) {
            
            $school_year = Input::get("school_year");
            $period = Input::get("period");
            $room = Input::get("room");
            
            $changetime = \App\ScheduleShs::where('id', $sched_id)->first();
            $changetime->time_start=$value;
            $changetime->save();

        return $this->getexistingsched($room);

        }
    }
    
    function changetime_end($sched_id, $value){
        
        if (Request::ajax()) {
            
            $school_year = Input::get("school_year");
            $period = Input::get("period");
            $room = Input::get("room");
            
            $changetime = \App\ScheduleShs::where('id', $sched_id)->first();
            $changetime->time_end=$value;
            $changetime->save();

        return $this->getexistingsched($room);

        }
    }
    
    function deletesched($sched_id){
        
        if (Request::ajax()) {
            
            $course_id = Input::get("course_id");
            
            $changetime = \App\ScheduleShs::where('id', $sched_id)->first();
            $changetime->delete();

            $schedules = \App\ScheduleShs::where('course_offering_id', $course_id)->get();
        
        return view('registrar.ajax.shs_popsched', compact('schedules'));
            
        }
    }
    
    public function getlistroom(\Illuminate\Http\Request $request) {
        $query = $request->get('term','');
        
        $rooms= \App\CtrRooms::where('room','LIKE','%'.$query.'%')->get();
        
        $data=array();
        foreach ($rooms as $room) {
                $data[]=array('value'=>$room->room,'id'=>$room->id);
        }
        if(count($data)){
             return $data;
        }else{
            return ['value'=>'No Result Found','id'=>''];
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
