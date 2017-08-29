<?php

namespace App\Http\Controllers\Registrar\Main;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class StudentProfile extends Controller
{
    //
    function index($idno){
        $user = \App\User::where('idno',$idno)->first();
        $student_info = \App\StudentInfo::where('idno', $idno)->first();
        $status = \App\Status::where('idno', $idno)->first();
        $levels = \App\Curriculum::distinct()->where('curriculum_year', $student_info->curriculum_year)->where('program_code', $status->program_code)->orderBy('level')->get(['level', 'period']);
        
//        if (count($levels)>0){ 
//            foreach ($levels as $level){
//                $courses = \App\Curriculum::where('curriculum_year', $student_info->curriculum_year)
//                            ->where('level', $level->level)
//                            ->where('program_code', $status->program_code)
//                            ->where('period', $level->period)
//                            ->get(['course_code', 'course_name']);
//                
//                $curriculum = "<table class=\'table table-condensed\'><thead><th class=\"col-sm-1\">Subject Code</th><th class=\"col-sm-4\">Subject Name</th><th class=\"col-sm-1\">Remarks</th></thead>";
//            
//                foreach ($courses as $course){
//                $curriculum = $curriculum."<tr><td>" . $course->course_code . "</td>"
//                        . "<td>" . $course->course_name . "</td>"
//                        . "<td>". $this->getRemarks($idno ,$course->course_code) . "</td></tr>";
//                }
//                $curriculum = $curriculum. "</table>";
//                
//            }
//            
//        }
        
        return view('registrar.studentprofile', compact('idno','student_info','status','user', 'levels', 'curriculum'));
    }
    
    function getRemarks($idno, $course_code){
        $grade = \App\GradeCollege::where('idno', $idno)->where('course_code', $course_code)->get();
        if (count($grade)>0){
            foreach ($grade as $grades){
                $data = $grades->remarks;
                return $data;
            }
        }else {
            return "";
        }
        
    }
}
