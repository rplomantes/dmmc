<?php

namespace App\Http\Controllers\Registrar\Ajax;

//use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
Use Illuminate\Support\Facades\DB;
use Request;

class GetSubjectList extends Controller
{
    function getlistcollege(){
        if(Request::ajax()){
            $level = Input::get("level");
            $program_code = Input::get("program_code");
            $academic_program = Input::get("academic_program");
            
            $school_year = \App\CtrSchoolYear::where('academic_type', 'College')->first();
            $course_offerings = \App\CourseOffering::where('level', $level)->where('program_code', $program_code)->where('school_year',$school_year->school_year)->where('period', $school_year->period)->get();
            
            if (count($course_offerings)>0){
                $data = "<table class=\"table table-condensed\"><thead><th>Subject Code</th><th>Subject Name</th><th>Section</th><th>Schedule</th><th>Professor</th></thead>";
                foreach ($course_offerings as $course_offering) {
                    $data = $data . "<tr>"
                            . "<td>" . $course_offering->course_code . "</td>"
                            . "<td><a href=\"/dean/generatereport/studentlist/$course_offering->id\" target=\"_blank\">". $course_offering->course_name . "</a></td>"
                            . "<td>" . $course_offering->program_code . " - section " . $course_offering->section . "</td>"
                            . "<td>" . $this->getSchedule($course_offering->id) . "</td>"
                            . "<td>" . $this->getInstructorId($course_offering->id) . "</td>"
                            . "</tr>";
                }
                $data=$data."</table>";
                
                return $data;
                
            }else{
                return "<div class='alert alert-danger'>No subject offerings for this level and course.</div>";
            }
        }
    }
    
    function getlistpersearchcollege(){
        if(Request::ajax()){
            $search = Input::get("search");
            $academic_program = Input::get("academic_program");
            
            $school_year = \App\CtrSchoolYear::where('academic_type', 'College')->first();
            $course_offerings = \App\CourseOffering::where('school_year',$school_year->school_year)->where('period', $school_year->period)->where("course_code","like","%".$search."%")->orWhere("course_name","like","%".$search."%")->get();
            
            if (count($course_offerings)>0){
                $data = "<table class=\"table table-condensed\"><thead><th>Subject Code</th><th>Subject Name</th><th>Section</th><th>Schedule</th><th>Professor</th></thead>";
                foreach ($course_offerings as $course_offering) {
                    $data = $data . "<tr>"
                            . "<td>" . $course_offering->course_code . "</td>"
                            . "<td><a href=\"/registrar/generatereport/studentlist_college/$course_offering->id\" target=\"_blank\">". $course_offering->course_name . "</a></td>"
                            . "<td>" . $course_offering->program_code . " - section " . $course_offering->section . "</td>"
                            . "<td>" . $this->getSchedule($course_offering->id) . "</td>"
                            . "<td>" . $this->getInstructorId($course_offering->id) . "</td>"
                            . "</tr>";
                }
                $data=$data."</table>";
                
                return $data;
                
            }else{
                return "<div class='alert alert-danger'>No subject offerings for this level and course.</div>";
            }
        }
    }
    
    function getlistshs(){
        if(Request::ajax()){
            $level = Input::get("level");
            $program_code = Input::get("program_code");
            $academic_program = Input::get("academic_program");
            
            $school_year = \App\CtrGradeSchoolYear::where('academic_type', 'Senior High School')->first();
            $course_offerings = \App\CourseDetailsShs::where('level', $level)->where('track', $program_code)->where('school_year',$school_year->school_year)->where('period', $school_year->period)->get(); 
            
            if (count($course_offerings)>0){
                $data = "<table class=\"table table-condensed\"><thead><th>Subject Name</th><th>Section</th><th>Schedule</th><th>Professor</th></thead>";
                foreach ($course_offerings as $course_offering) {
                    $data = $data . "<tr>"
                            . "<td><a href=\"/dean/generatereport/studentlistshs/$course_offering->id\" target=\"_blank\">". $course_offering->course_name . "</a></td>"
                            . "<td>" . $course_offering->track . " - section " . $course_offering->section . "</td>"
                            . "<td>" . $this->getScheduleShs($course_offering->id) . "</td>"
                            . "<td>" . $this->getInstructorIdShs($course_offering->id) . "</td>"
                            . "</tr>";
                }
                $data=$data."</table>";
                
                return $data;
                
            }else{
                return "<div class='alert alert-danger'>No subject offerings for this level and course.</div>";
            }
        }
    }
    
    function getlistpersearchshs(){
        if(Request::ajax()){
            $search = Input::get("search");
            $academic_program = Input::get("academic_program");
            
            $school_year = \App\CtrGradeSchoolYear::where('academic_type', 'Senior High School')->first();
            $course_offerings = \App\CourseDetailsShs::where('school_year',$school_year->school_year)->where('period', $school_year->period)->where("course_name","like","%".$search."%")->get();
            
            if (count($course_offerings)>0){
                $data = "<table class=\"table table-condensed\"><thead><th>Subject Name</th><th>Section</th><th>Schedule</th><th>Professor</th></thead>";
                foreach ($course_offerings as $course_offering) {
                    $data = $data . "<tr>"
                            . "<td><a href=\"/dean/generatereport/studentlistshs/$course_offering->id\" target=\"_blank\">". $course_offering->course_name . "</a></td>"
                            . "<td>" . $course_offering->track . " - section " . $course_offering->section . "</td>"
                            . "<td>" . $this->getScheduleShs($course_offering->id) . "</td>"
                            . "<td>" . $this->getInstructorIdShs($course_offering->id) . "</td>"
                            . "</tr>";
                }
                $data=$data."</table>";
                
                return $data;
                
            }else{
                return "<div class='alert alert-danger'>No subject offerings for this level and course.</div>";
            }
        }
    }
    
    public function getSchedule($course_offering_id){
        $schedules = \App\Schedule::distinct()->where('course_offering_id', $course_offering_id)->get(['time_start', 'time_end', 'room']);
        $data = "";
        $whatDay = "";
        $finalSched="";

        foreach($schedules as $schedule){
            $days = \App\Schedule::distinct()->where('course_offering_id', $course_offering_id)->where('time_start', $schedule->time_start)->where('time_end', $schedule->time_end)->where('room', $schedule->room)->get(['day']);
            foreach ($days as $day){
                $whatDay = $whatDay."".$day->day;
            }
                $finalSched = $schedule->room." [".$whatDay." ".date('g:i A', strtotime($schedule->time_start))." - ".date('g:i A', strtotime($schedule->time_end))."]";
                $whatDay = "";
                $data = $data." ".$finalSched."<br>";
        }
        return $data;
    }
    public function getScheduleShs($course_offering_id){
        $schedules = \App\ScheduleShs::distinct()->where('course_offering_id', $course_offering_id)->get(['time_start', 'time_end', 'room']);
        $data = "";
        $whatDay = "";
        $finalSched="";

        foreach($schedules as $schedule){
            $days = \App\ScheduleShs::distinct()->where('course_offering_id', $course_offering_id)->where('time_start', $schedule->time_start)->where('time_end', $schedule->time_end)->where('room', $schedule->room)->get(['day']);
            foreach ($days as $day){
                $whatDay = $whatDay."".$day->day;
            }
                $finalSched = $schedule->room." [".$whatDay." ".date('g:i A', strtotime($schedule->time_start))." - ".date('g:i A', strtotime($schedule->time_end))."]";
                $whatDay = "";
                $data = $data." ".$finalSched."<br>";
        }
        return $data;
    }
        
    public function getInstructorId($offeringid){             
        $offering_id = \App\CourseOffering::find($offeringid);
        $instructor = \App\User::where('id', $offering_id->instructor_id)->first();

        if (count($instructor)>0){
        $data = $instructor->firstname." ".$instructor->lastname." ".$instructor->extensionname;
        return $data;
        }else {
            return "";
        }
    }
    public function getInstructorIdShs($offeringid){             
        $offering_id = \App\CourseDetailsShs::find($offeringid);
        $instructor = \App\User::where('id', $offering_id->instructor_id)->first();

        if (count($instructor)>0){
        $data = $instructor->firstname." ".$instructor->lastname." ".$instructor->extensionname;
        return $data;
        }else {
            return "";
        }
    }
}
