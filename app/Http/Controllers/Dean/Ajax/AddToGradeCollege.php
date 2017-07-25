<?php

namespace App\Http\Controllers\Dean\Ajax;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
Use Illuminate\Support\Facades\DB;
use Request;

class AddToGradeCollege extends Controller
{
    //
    function index(){
        if(Request::ajax()){
            $idno = Input::get('idno');
            $offering = \App\CourseOffering::find(Input::get('offeringid'));
            $checksubject = \App\GradeCollege::where('idno',$idno)->where('course_code',$offering->course_code)->get();
            if(count($checksubject)==0){
            $newgrade = new \App\GradeCollege;
            $newgrade->idno=$idno;
            $newgrade->course_offering_id = Input::get('offeringid');
            $newgrade->course_code=$offering->course_code;
            $newgrade->course_name=$offering->course_name;
            $newgrade->lec=$offering->lec;
            $newgrade->lab=$offering->lab;
            $newgrade->hours=$offering->hours;
            $newgrade->school_year=$offering->school_year;
            $newgrade->period=$offering->period;
            $newgrade->save();
            }
            $studentcourses = \App\GradeCollege::where('idno',$idno)
                    ->where('school_year',$newgrade->school_year)
                    ->where('period',$newgrade->period)
                    ->get();
            
            if(count($studentcourses)>0){
                $data = "<table width=\"100%\"><tr><td>Subject</td><td>Units</td><td>Room/Schedule</td><td>Instructor</td><td>Remove</td></tr>";
                $units=0;
                foreach($studentcourses as $studentcourse){
                    $data = $data."<tr><td>" . $studentcourse->course_code . " - ". $studentcourse->course_name
                            ."</td><td>" . ($studentcourse->lec + $studentcourse->lab)
                            . "</td><td>" . $this->getSchedule($studentcourse->course_offering_id)
                            . "</td><td>". $this->getInstructorId($studentcourse->course_offering_id) . "</td><td><a href=\"javascript: void(0);\" onclick=\"removesubject('".$studentcourse->id."')\">Remove</a></td></tr>";
                
                    $units=$units + $studentcourse->lec+$studentcourse->lab;
                }
                $data=$data."<tr><td>ToTal Units</td><td colspan=\"4\">$units</td></tr>";
                $data=$data."</table>";
                return $data;
            }else{
                return "No Subject Selected Yet...";
            }
        }
    }
    
    function shs(){
        if(Request::ajax()){
            $idno = Input::get('idno');
            $offering = \App\CourseOffering::find(Input::get('offeringid'));
            $checksubject = \App\GradeShs::where('idno',$idno)->where('course_code',$offering->course_code)->get();
            if(count($checksubject)==0){
            $newgrade = new \App\GradeShs;
            $newgrade->idno=$idno;
            $newgrade->course_offering_id = Input::get('offeringid');
            $newgrade->course_code=$offering->course_code;
            $newgrade->course_name=$offering->course_name;
            $newgrade->hours=$offering->hours;
            $newgrade->school_year=$offering->school_year;
            $newgrade->period=$offering->period;
            $newgrade->save();
            }
            $studentcourses = \App\GradeShs::where('idno',$idno)
                    ->where('school_year',$offering->school_year)
                    ->where('period',$offering->period)
                    ->get();
            
            if(count($studentcourses)>0){
                $data = "<table width=\"100%\"><tr><td>Subject</td><td>Hours</td><td>Room/Schedule</td><td>Instructor</td><td>Remove</td></tr>";
                $hours=0;
                foreach($studentcourses as $studentcourse){
                    $data = $data."<tr><td>" . $studentcourse->course_code . " - ". $studentcourse->course_name
                            ."</td><td>" . $studentcourse->hours
                            . "</td><td>" . $this->getSchedule($studentcourse->course_offering_id)
                            . "</td><td>". $this->getInstructorId($studentcourse->course_offering_id) . "</td><td><a href=\"javascript: void(0);\" onclick=\"removesubject('".$studentcourse->id."')\">Remove</a></td></tr>";
                
                    $hours=$hours + $studentcourse->hours;
                }
                $data=$data."<tr><td>ToTal Hours</td><td colspan=\"4\">$hours</td></tr>";
                $data=$data."</table>";
                return $data;
            }else{
                return "No Subject Selected Yet...";
            }
        }
        
    }
    
     public function getInstructorId($offeringid){
        $offering_id = \App\CourseOffering::find($offeringid);
        return $offering_id->instructor_id;
    }
    
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
    function removesubject(){
       if(Request::ajax()){
            $id = Input::get('id');
            $idno=Input::get('idno');
            $school_year=Input::get("school_year");
            $period=Input::get("period");
            $removesubject = \App\GradeCollege::find($id);
            $removesubject->delete();
            
            $studentcourses = \App\GradeCollege::where('idno',$idno)
                    ->where('school_year',$school_year)
                    ->where('period',$period)
                    ->get();
            
            if(count($studentcourses)>0){
                $data = "<table width=\"100%\"><tr><td>Subject</td><td>Units</td><td>Room/Schedule</td><td>Instructor</td><td>Remove</td></tr>";
                $units=0;
                foreach($studentcourses as $studentcourse){
                $data = $data."<tr><td>" . $studentcourse->course_code . " - ". $studentcourse->course_name
                            ."</td><td>" .($studentcourse->lec + $studentcourse->lab)
                            . "</td><td>" . $this->getSchedule($studentcourse->course_offering_id)
                            . "</td><td>". $this->getInstructorId($studentcourse->course_offering_id) . "</td><td><a href=\"javascript: void(0);\" onclick=\"removesubject('".$studentcourse->id."')\">Remove</a></td></tr>";
                
                    $units = $units + $studentcourse->lec + $studentcourse->lab;
                }
                $data=$data."<tr><td>Total Units</td><td colspan=\"4\">$units</td></tr>";
                $data=$data."</table>";
                return $data;
            }else{
                return "No Subject Selected Yet...";
            }
           
        }
    } 
    function removesubjectshs(){
        if(Request::ajax()){
            $id = Input::get('id');
            $idno=Input::get('idno');
            $school_year=Input::get("school_year");
            $period=Input::get("period");
            $removesubject = \App\GradeShs::find($id);
            $removesubject->delete();
            
            $studentcourses = \App\GradeShs::where('idno',$idno)
                    ->where('school_year',$school_year)
                    ->where('period',$period)
                    ->get();
            
            if(count($studentcourses)>0){
                $data = "<table width=\"100%\"><tr><td>Subject</td><td>Hours</td><td>Room/Schedule</td><td>Instructor</td><td>Remove</td></tr>";
                $hours=0;
                foreach($studentcourses as $studentcourse){
                $data = $data."<tr><td>" . $studentcourse->course_code . " - ". $studentcourse->course_name
                            ."</td><td>" . $studentcourse->hours
                            . "</td><td>" . $this->getSchedule($studentcourse->course_offering_id)
                            . "</td><td>". $this->getInstructorId($studentcourse->course_offering_id) . "</td><td><a href=\"javascript: void(0);\" onclick=\"removesubject('".$studentcourse->id."')\">Remove</a></td></tr>";
                
                    $hours = $hours + $studentcourse->hours;
                }
                $data=$data."<tr><td>Total Hours</td><td colspan=\"4\">$hours</td></tr>";
                $data=$data."</table>";
                return $data;
            }else{
                return "No Subject Selected Yet...";
            }
           
        }
    }
}
