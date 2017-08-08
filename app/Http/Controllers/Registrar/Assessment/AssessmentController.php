<?php

namespace App\Http\Controllers\Registrar\Assessment;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AssessmentController extends Controller
{
    function viewinfo($idno){
        $status = \App\Status::where('idno', $idno)->first();
        
        return view('registrar.assessment.studentinfo', compact('status', 'idno'));
        
    }
    
    function viewassessment($idno) {
        $status = \App\Status::where('idno', $idno)->first();
        
        if ($status->academic_type == "Senior High School"){
            return view('registrar.assessment.shsviewassessment', compact('status','idno'));
        } else if ($status->academic_type == "College" or $status->academic_type == "TESDA"){
            return view('registrar.assessment.collegeviewassessment', compact('status','idno'));
        }
    }
}
