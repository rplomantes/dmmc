<?php

namespace App\Http\Controllers\Registrar\Ajax;

use Illuminate\Support\Facades\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use App\Schedule;

class collegeCourseSchedule extends Controller {

    function getcourses($program_code) {
        if (Request::ajax()) {

            $school_year = Input::get("school_year");
            $period = Input::get("period");
            $section = Input::get("level");
            $level = Input::get("section");

            $courses = \App\CourseOffering::where('program_code', $program_code)
                    ->where('school_year', $school_year)
                    ->where('section', $section)
                    ->where('level', $level)
                    ->where('period', $period)
                    ->get();
            
            return view('registrar.ajax.college_getcourses', compact('courses'));
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
            
            $courses = \App\Schedule::distinct()->join('course_offerings', 'course_offering_id', '=', 'course_offerings.id')
                    ->where('course_offerings.school_year', $school_year)
                    ->where('course_offerings.period', $period)
                    ->where('room', $room)
                    ->orderBy('course_code')
                    ->get(['course_offering_id', 'course_code', 'program_code', 'level', 'section']);
            
            return view('registrar.ajax.college_getexistingsched', compact('courses', 'school_year', 'period', 'room'));
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

            $addsched = new Schedule;
            $addsched->course_offering_id = $course_id;
            $addsched->room = "$room";
            $addsched->day = "$day";
            $addsched->time_start = "$time_start";
            $addsched->time_end = "$time_end";
            $addsched->save();
         
            $schedules = \App\Schedule::where('course_offering_id', $course_id)->get();
        
        return view('registrar.ajax.college_popsched', compact('schedules'));
        }
    }
    
    function changeroom($sched_id, $value){
        
        if (Request::ajax()) {
            
            $school_year = Input::get("school_year");
            $period = Input::get("period");
            $room = Input::get("room");
            
            $changeroom = Schedule::where('id', $sched_id)->first();
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
            
            $changeday = Schedule::where('id', $sched_id)->first();
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
            
            $changetime = Schedule::where('id', $sched_id)->first();
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
            
            $changetime = Schedule::where('id', $sched_id)->first();
            $changetime->time_end=$value;
            $changetime->save();

        return $this->getexistingsched($room);

        }
    }
    
    function deletesched($sched_id){
        
        if (Request::ajax()) {
            
            $course_id = Input::get("course_id");
            
            $changetime = Schedule::where('id', $sched_id)->first();
            $changetime->delete();

            $schedules = \App\Schedule::where('course_offering_id', $course_id)->get();
        
        return view('registrar.ajax.college_popsched', compact('schedules'));
            
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

}
