<?php

namespace App\Http\Controllers\Dean\Main;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AssessmentController extends Controller
{
    //
    function indexcollege(){
        return view('dean.assessment.indexcollege');
    }
    
    function indexshs(){
        return view('dean.assessment.indexshs');
    }
    
    function viewinfo($idno) {
        $status = \App\Status::where('idno', $idno)->first();

        return view('dean.assessment.studentinfo', compact('status', 'idno'));
    }

    function viewassessment($idno) {
        $status = \App\Status::where('idno', $idno)->first();

        return view('dean.assessment.viewassessment', compact('status', 'idno'));
    }
}
