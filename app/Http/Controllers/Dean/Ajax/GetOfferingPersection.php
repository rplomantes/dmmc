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
                $data="<table class=\"table table-condensed\" border=\"0\" width=\"100%\"><tr><td>Subject</td><td>Units</td><td>Room/Schedule</td><td>Instructor</td></tr>";
                foreach($offerings as $offering){
            
                        $data = $data."<tr><td><a href=\"javascript: void(0);\" onclick=\"addtogradecollege('" .$idno . "','" . $offering->id ."')\" >".$offering->course_code." - " . $offering->course_name 
                             . "</a></td><td>" . ($offering->lec + $offering->lab)
                             . "</td><td>" . $this->getSchedule($offering->id) 
                             . "</td><td>".$this->getInstructorId($offering->id)."</td></tr>";
    
                    }
                 $data=$data."</table>";
                 $data=$data."<div class=\"col-sm-12\"><a href=\"javascript: void(0);\" class=\"btn btn-primary form-control\" onclick =\"addallsubjects()\" id=\"addallsubject\">Add All >>></a></div>";
                 return $data;
            }else{
                return "<div class='alert alert-danger'>No Subject Offerings For This Level.</div>";
            }
        }
    }
    //
    
        function shs(){
 
        if(Request::ajax()) {   
            $idno=Input::get("idno");
            $school_year=Input::get("school_year");
            $period=Input::get("period");
            $track=Input::get("track");
            $level=Input::get("level");
            $section=Input::get("section");
            
             $offerings = \App\CourseOffering::where("school_year", $school_year)
                    ->where("period",$period)
                    ->where("track",$track)
                    ->where("level",$level)
                    ->where("section",$section)->get();
            
             
             if(count($offerings)>0){
                $data="<table class=\"table table-condensed\" border=\"0\" width=\"100%\"><tr><td>Subject</td><td>Hours</td><td>Room/Schedule</td><td>Instructor</td></tr>";
                foreach($offerings as $offering){
            
                        $data = $data."<tr><td><a href=\"javascript: void(0);\" onclick=\"addtogradeshs('" .$idno . "','" . $offering->id ."')\" >".$offering->course_code." - " . $offering->course_name 
                             . "</a></td><td>" . $offering->hours
                             . "</td><td>" . $this->getSchedule($offering->id) 
                             . "</td><td>".$offering->instructor_id."</td></tr>";
    
                    }
                 $data=$data."</table>";
                 $data=$data."<div class=\"col-sm-12\"><a href=\"javascript: void(0);\" class=\"btn btn-primary form-control\" onclick =\"addallsubjects()\" id=\"addallsubject\">Add All >>></a></div>";
                 return $data;
            }else{
                return "<div class='alert alert-danger'>No Subject Offerings For This Level.</div>";
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
                            $newgrade->lec=$offering->lec;
                            $newgrade->lab=$offering->lab;
                            $newgrade->hours=$offering->hours;
                            $newgrade->percent_tuition=$offering->percent_tuition;
                            $newgrade->save();
                        }
                    }
                    
                $studentcourses = \App\GradeCollege::where('idno',$idno)
                    ->where('school_year',$school_year)
                    ->where('period',$period)
                    ->get();
            
                if(count($studentcourses)>0){
                    $data = "<table class=\"table table-condensed\" width=\"100%\"><tr><td>Subject</td><td>Units</td><td>Room/Schedule</td><td>Instructor</td><td>Remove</td></tr>";
                        $units=0;
                        foreach($studentcourses as $studentcourse){
                            $units = $units + $studentcourse->lec+$studentcourse->lab;
                            $data = $data."<tr><td>" . $studentcourse->course_code . " - ". $studentcourse->course_name
                            . "</td><td>" . ($studentcourse->lec + $studentcourse->lab) 
                            . "</td><td>" . $this->getSchedule($studentcourse->course_offering_id)
                            . "</td><td>". $this->getInstructorId($studentcourse->course_offering_id) 
                            . "</td><td><a href=\"javascript: void(0);\" onclick=\"removesubject('".$studentcourse->id."')\">Remove</a></td></tr>";
                }           
                $data=$data."<tr><td>Total Units</td><td colspan=\"4\">$units</td></table>";
                return $data;
            }else{
                return "<div class='alert alert-danger'>No Subject Selected Yet!!</div>";
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
         function checksubjectshs($idno,$course_code){
            $hassubject = \App\GradeShs::where('idno',$idno)->where('course_code',$course_code)->get();
            if(count($hassubject)>0){
                return false;
            }else{
                return true;
            }
             
         }   
        function search(){
            if(Request::ajax()){
            $idno=Input::get("idno");
            $school_year=Input::get("school_year");
            $period=Input::get("period");
            $program_code=Input::get("program_code");
            $search=Input::get("search");
            
            $offerings = \App\CourseOffering::where("school_year", $school_year)
                    ->where("course_code","like",$search."%")
                    ->orWhere("course_name","like",$search."%")->get();
                    
           
            if(count($offerings)>0){
                $data="<table class=\"table table-condensed\" border=\"0\" width=\"100%\"><tr><td>Subject</td><td>Units</td><td>Room/Schedule</td><td>Instructor</td></tr>";
                foreach($offerings as $offering){
            
                        $data = $data."<tr><td><a href=\"javascript: void(0);\" onclick=\"addtogradecollege('" .$idno . "','" . $offering->id ."')\" >".$offering->course_code." - " . $offering->course_name 
                             . "</a></td><td>" . ($offering->lec + $offering->lab)
                             . "</td><td>" . $this->getSchedule($offering->id) 
                             . "</td><td>".$this->getInstructorId($offering->id)."</td></tr>";
    
                    }
                 $data=$data."</table>";
                 $data=$data."<div class=\"col-sm-12\"><a href=\"javascript: void(0);\" class=\"btn btn-primary form-control\" onclick =\"addallsubjects()\" id=\"addallsubject\">Add All >>></a></div>";
                 return $data;
            }else{
                return "<div class='alert alert-danger'>No Subject Offerings For This Level.</div>";
            }
        }
        }
        
        function addallsubjectsshs(){
            if(Request::ajax()){
            $idno=Input::get("idno");
            $school_year=Input::get("school_year");
            $period=Input::get("period");
            $track=Input::get("track");
            $level=Input::get("level");
            $section=Input::get("section");
            
             $offerings = \App\CourseOffering::where("school_year", $school_year)
                    ->where("period",$period)
                    ->where("track",$track)
                    ->where("level",$level)
                    ->where("section",$section)->get();
             
                if(count($offerings)>0){
                    foreach($offerings as $offering){
                        if($this->checksubjectshs($idno,$offering->course_code)){
                            $newgrade = new \App\GradeShs;
                            $newgrade->idno=$idno;
                            $newgrade->course_offering_id = $offering->id;
                            $newgrade->course_code=$offering->course_code;
                            $newgrade->course_name=$offering->course_name;
                            $newgrade->school_year=$offering->school_year;
                            $newgrade->period=$offering->period;
                            $newgrade->hours=$offering->hours;
                            $newgrade->save();
                        }
                    }
                    
                $studentcourses = \App\GradeShs::where('idno',$idno)
                    ->where('school_year',$school_year)
                    ->where('period',$period)
                    ->get();
            
                if(count($studentcourses)>0){
                    $data = "<table class=\"table table-condensed\" width=\"100%\"><tr><td>Subject</td><td>Hours</td><td>Room/Schedule</td><td>Instructor</td><td>Remove</td></tr>";
                        $hours=0;
                        foreach($studentcourses as $studentcourse){
                            $hours = $hours + $studentcourse->hours;
                            $data = $data."<tr><td>" . $studentcourse->course_code . " - ". $studentcourse->course_name
                            . "</td><td>" . $studentcourse->hours 
                            . "</td><td>" . $this->getSchedule($studentcourse->course_offering_id)
                            . "</td><td>". $this->getInstructorId($studentcourse->course_offering_id) 
                            . "</td><td><a href=\"javascript: void(0);\" onclick=\"removesubject('".$studentcourse->id."')\">Remove</a></td></tr>";
                }           
                $data=$data."<tr><td>Total Hours</td><td colspan=\"4\">$hours</td></table>";
                return $data;
            }else{
                return "<div class='alert alert-danger'>No Subject Selected Yet!!</div>";
            }
                }
            }
            
        }
}
