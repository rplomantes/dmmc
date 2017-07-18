<?php

namespace App\Http\Controllers\Dean\Ajax;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
Use Illuminate\Support\Facades\DB;
use Request;

class GetOfferingPersection extends Controller
{
    function index(){
        if(Request::ajax()){
            $idno=Input::get("idno");
            $school_year=Input::get("school_year");
            $period=Input::get("period");
            $program_code=Input::get("program_code");
            $level=Input::get("level");
            $section=Input::get("section");
            
            $offerings = \App\CourseOffering::where("school_year", $school_year)
                    ->where("period",$period)
                    ->where("program_code",$program_code)
                    ->where("level",$level)
                    ->where("section",$section)->get();
           
            if(count($offerings)>0){
                $data="<table border=\"0\" width=\"100%\"><tr><td>Subject</td><td>Room/Schedule</td><td>Instructor</td></tr>";
                foreach($offerings as $offering){
            
                        $data = $data."<tr><td><a href=\"#\" onclick=\"addtogradecollege('" .$idno . "','" . $offering->id ."')\" >".$offering->course_code." - " . $offering->course_name 
                             . "</a></td><td>" . $this->getSchedule($offering->id) 
                             . "</td><td>".$offering->instructor_id."</td></tr>";
    
                    }
                 $data=$data."</table>";
                 $data=$data."<div class=\"col-sm-12\"><a href=\"#\" class=\"btn btn-primary form-control\" onclick =\"addallsubjects()\" id=\"addallsubject\">Add All >>></a></div>";
                 return $data;
            }else{
                return "No Subject Offerings For this Level";
            }
        }
    }
    //
        public function getSchedule($course_offering_id){
            $schedules = \App\Schedule::where('course_offering_id',$course_offering_id)->get();
            $data = "";
            if(count($schedules)>0){
               foreach($schedules as $schedule){
                   $data = $data."[".$schedule->room."-".$schedule->day." ".$schedule->time."]";
               } 
                
            }
            return $data;
        }
        
         public function getInstructorId($offeringid){
        $offering_id = \App\CourseOffering::find($offeringid);
        return $offering_id->instructor_id;
    }
    
        function addallsubjects(){
            if(Request::ajax()){
            $idno=Input::get("idno");
            $school_year=Input::get("school_year");
            $period=Input::get("period");
            $program_code=Input::get("program_code");
            $level=Input::get("level");
            $section=Input::get("section");
            
             $offerings = \App\CourseOffering::where("school_year", $school_year)
                    ->where("period",$period)
                    ->where("program_code",$program_code)
                    ->where("level",$level)
                    ->where("section",$section)->get();
             
                if(count($offerings)>0){
                    foreach($offerings as $offering){
                        if($this->checksubject($idno,$offering->course_code)){
                            $newgrade = new \App\GradeCollege;
                            $newgrade->idno=$idno;
                            $newgrade->course_offering_id = $offering->id;
                            $newgrade->course_code=$offering->course_code;
                            $newgrade->course_name=$offering->course_name;
                            $newgrade->school_year=$offering->school_year;
                            $newgrade->period=$offering->period;
                            $newgrade->save();
                        }
                    }
                    
                $studentcourses = \App\GradeCollege::where('idno',$idno)
                    ->where('school_year',$school_year)
                    ->where('period',$period)
                    ->get();
            
                if(count($studentcourses)>0){
                    $data = "<table width=\"100%\"><tr><td>Subject</td><td>Room/Schedule</td><td>Instructor</td><td>Remove</td></tr>";
                        foreach($studentcourses as $studentcourse){
                            $data = $data."<tr><td>" . $studentcourse->course_code . " - ". $studentcourse->course_name
                            . "</td><td>" . $this->getSchedule($studentcourse->course_offering_id)
                            . "</td><td>". $this->getInstructorId($studentcourse->course_offering_id) 
                            . "</td><td><a href=\"#\" onclick=\"removesubject('".$studentcourse->id."')\">Remove</a></td></tr>";
                }
                $data=$data."</table>";
                return $data;
            }else{
                return "No Subject Selected Yet...";
            }
                }
            }
        }
        
        function checksubject($idno,$course_code){
            $hassubject = \App\GradeCollege::where('idno',$idno)->where('course_code',$course_code)->get();
            if(count($hassubject)>0){
                return false;
            }else{
                return true;
            }
        }
}
