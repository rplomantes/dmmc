<?php

namespace App\Http\Controllers\Dean\Ajax;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
Use Illuminate\Support\Facades\DB;
use Request;

class AddToGradeCollege extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
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
            $newgrade->level=$offering->level;
            $newgrade->lec=$offering->lec;
            $newgrade->lab=$offering->lab;
            $newgrade->hours=$offering->hours;
            $newgrade->school_year=$offering->school_year;
            $newgrade->period=$offering->period;
            $newgrade->percent_tuition=$offering->percent_tuition;
            $newgrade->save();
            }
            $studentcourses = \App\GradeCollege::where('idno',$idno)
                    ->where('school_year',$newgrade->school_year)
                    ->where('period',$newgrade->period)
                    ->get();
            
            if(count($studentcourses)>0){
                $data = "<table class=\"table table-condensed\" width=\"100%\"><tr><td>Subject</td><td>Units</td><td>Room/Schedule</td><td>Instructor</td><td>Remove</td></tr>";
                $units=0;
                foreach($studentcourses as $studentcourse){
                    $data = $data."<tr><td>" . $studentcourse->course_code . " - ". $studentcourse->course_name
                            ."</td><td>" . ($studentcourse->lec + $studentcourse->lab)
                            . "</td><td>" . $this->getSchedule($studentcourse->course_offering_id)
                            . "</td><td>". $this->getInstructorId($studentcourse->course_offering_id) . "</td><td><a href=\"javascript: void(0);\" onclick=\"removesubject('".$studentcourse->id."')\">Remove</a></td></tr>";
                
                    $units=$units + $studentcourse->lec+$studentcourse->lab;
                }
                $data=$data."<tr><td><strong>Total Units</strong></td><td colspan=\"4\"><strong>$units</strong></td></tr>";
                $data=$data."</table>";
                return $data;
            }else{
                return "<div class='alert alert-danger'>No Subject Selected Yet!!</div>";
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
            $newgrade->level=$offering->level;
            $newgrade->period=$offering->period;
            $newgrade->save();
            }
            $studentcourses = \App\GradeShs::where('idno',$idno)
                    ->where('school_year',$offering->school_year)->orderBy('period')
                    ->get();
            
            if(count($studentcourses)>0){
                $data = "<table class=\"table table-condensed\" width=\"100%\"><tr><td>Subject</td><td>Period</td><td>Hours</td><td>Room/Schedule</td><td>Instructor</td><td>Remove</td></tr>";
                $hours=0;
                foreach($studentcourses as $studentcourse){
                    $data = $data."<tr><td>" . $studentcourse->course_name
                            . "</td><td>" . $studentcourse->period
                            . "</td><td>" . $studentcourse->hours
                            . "</td><td>" . $this->getSchedule($studentcourse->course_offering_id)
                            . "</td><td>". $this->getInstructorId($studentcourse->course_offering_id) . "</td><td><a href=\"javascript: void(0);\" onclick=\"removesubject('".$studentcourse->id."')\">Remove</a></td></tr>";
                
                    $hours=$hours + $studentcourse->hours;
                }
                $data=$data."<tr><td colspan = \"2\"><strong>Total Hours</strong></td><td colspan=\"4\"><strong>$hours</strong></td></tr>";
                $data=$data."</table>";
                return $data;
            }else{
                return "<div class='alert alert-danger'>No Subject Selected Yet!!</div>";
            }
        }
        
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
                $data = "<table class=\"table table-condensed\" width=\"100%\"><tr><td>Subject</td><td>Units</td><td>Room/Schedule</td><td>Instructor</td><td>Remove</td></tr>";
                $units=0;
                foreach($studentcourses as $studentcourse){
                $data = $data."<tr><td>" . $studentcourse->course_code . " - ". $studentcourse->course_name
                            ."</td><td>" .($studentcourse->lec + $studentcourse->lab)
                            . "</td><td>" . $this->getSchedule($studentcourse->course_offering_id)
                            . "</td><td>". $this->getInstructorId($studentcourse->course_offering_id) . "</td><td><a href=\"javascript: void(0);\" onclick=\"removesubject('".$studentcourse->id."')\">Remove</a></td></tr>";
                
                    $units = $units + $studentcourse->lec + $studentcourse->lab;
                }
                $data=$data."<tr><td><strong>Total Units</strong></td><td colspan=\"4\"><strong>$units</strong></td></tr>";
                $data=$data."</table>";
                return $data;
            }else{
                return "<div class='alert alert-danger'>No Subject Selected Yet!!</div>";
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
                $data = "<table class=\"table table-condensed\" width=\"100%\"><tr><td>Subject</td><td>Hours</td><td>Room/Schedule</td><td>Instructor</td><td>Remove</td></tr>";
                $hours=0;
                foreach($studentcourses as $studentcourse){
                $data = $data."<tr><td>" . $studentcourse->course_name
                            ."</td><td>" . $studentcourse->hours
                            . "</td><td>" . $this->getSchedule($studentcourse->course_offering_id)
                            . "</td><td>". $this->getInstructorId($studentcourse->course_offering_id) . "</td><td><a href=\"javascript: void(0);\" onclick=\"removesubject('".$studentcourse->id."')\">Remove</a></td></tr>";
                
                    $hours = $hours + $studentcourse->hours;
                }
                $data=$data."<tr><td><strong>Total Hours</strong></td><td colspan=\"4\"><strong>$hours</strong></td></tr>";
                $data=$data."</table>";
                return $data;
            }else{
                return "<div class='alert alert-danger'>No Subject Selected Yet!!</div>";
            }
           
        }
    }
}
