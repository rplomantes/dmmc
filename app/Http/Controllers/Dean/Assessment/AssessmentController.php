<?php

namespace App\Http\Controllers\Dean\Assessment;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AssessmentController extends Controller {

    public function __construct() {
        $this->middleware('auth');
    }

    function indexcollege() {
        if (Auth::user()->accesslevel == "2") {
            return view('dean.assessment.indexcollege');
        }
    }

    function indexshs() {
        if (Auth::user()->accesslevel == "2") {
            return view('dean.assessment.indexshs');
        }
    }

    function viewinfo($idno) {
        if (Auth::user()->accesslevel == "2") {
            $status = \App\Status::where('idno', $idno)->first();
            return view('dean.assessment.studentinfo', compact('status', 'idno'));
        }
    }

    function viewassessment($idno) {
        if (Auth::user()->accesslevel == "2") {
            $status = \App\Status::where('idno', $idno)->first();
            return view('dean.assessment.viewassessment', compact('status', 'idno'));
        }
    }

}
