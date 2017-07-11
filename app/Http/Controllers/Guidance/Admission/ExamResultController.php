<?php

namespace App\Http\Controllers\Guidance\Admission;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ExamResultController extends Controller
{
    function viewresult(){
        Return view('guidance.admission.ListExamResult');
    }
}
