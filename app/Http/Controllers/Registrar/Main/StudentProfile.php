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
        if ($status->academic_type=='College' or $status->academic_type=='TESDA') {
        $grades = \App\GradeCollege::where('idno', $idno)->get();
        } else {
        $grades = \App\GradeShs::where('idno', $idno)->get();    
        }
        
        return view('registrar.studentprofile', compact('idno','student_info','status','user','grades'));
    }
}
