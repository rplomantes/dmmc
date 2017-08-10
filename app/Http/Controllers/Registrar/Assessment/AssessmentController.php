<?php

namespace App\Http\Controllers\Registrar\Assessment;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AssessmentController extends Controller {

    function viewinfo($idno) {
        $status = \App\Status::where('idno', $idno)->first();

        return view('registrar.assessment.studentinfo', compact('status', 'idno'));
    }

    function viewassessment($idno) {
        $status = \App\Status::where('idno', $idno)->first();

        return view('registrar.assessment.viewassessment', compact('status', 'idno'));
    }
}