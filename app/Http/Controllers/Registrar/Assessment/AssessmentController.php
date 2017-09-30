<?php

namespace App\Http\Controllers\Registrar\Assessment;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AssessmentController extends Controller {
    
    public function __construct()
    {
        $this->middleware('auth');
    }

    function indexcollege() {
        return view('registrar.assessment.indexcollege');
    }

    function indexshs() {
        return view('registrar.assessment.indexshs');
    }

    function viewinfo($idno) {
        $status = \App\Status::where('idno', $idno)->first();
        if ($status->status >= 3) {
            return redirect("/registrar/registration/$idno");
        } else {
            return view('registrar.assessment.studentinfo', compact('status', 'idno'));
        }
    }

    function viewassessment($idno) {
        $status = \App\Status::where('idno', $idno)->first();
        if ($status->academic_type != 'College') {
            return view('registrar.assessment.viewassessmentshs', compact('status', 'idno'));
        } else {
            return view('registrar.assessment.viewassessment', compact('status', 'idno'));
        }
    }

}
