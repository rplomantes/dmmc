<?php

namespace App\Http\Controllers\Registrar\Assessment;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AssessmentController extends Controller {

    public function __construct() {
        $this->middleware('auth');
    }

    function indexcollege() {
        if (Auth::user()->accesslevel == "3") {
            return view('registrar.assessment.indexcollege');
        }
    }

    function indexshs() {
        if (Auth::user()->accesslevel == "3") {
            return view('registrar.assessment.indexshs');
        }
    }

    function viewinfo($idno) {
        if (Auth::user()->accesslevel == "3") {
            $status = \App\Status::where('idno', $idno)->first();
            if ($status->status >= 3) {
                return redirect("/registrar/registration/$idno");
            } else {
                return view('registrar.assessment.studentinfo', compact('status', 'idno'));
            }
        }
    }

    function viewassessment($idno) {
        if (Auth::user()->accesslevel == "3") {
            $status = \App\Status::where('idno', $idno)->first();
            if ($status->academic_type == 'Senior High School') {
                return view('registrar.assessment.viewassessmentshs', compact('status', 'idno'));
            } else {
                return view('registrar.assessment.viewassessment', compact('status', 'idno'));
            }
        }
    }

}
