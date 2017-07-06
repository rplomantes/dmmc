<?php

namespace App\Http\Controllers\Guidance\Admission;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ExamSchedCreatorController extends Controller
{
    //
    function createSched (){
     return view ('guidance.admission.createExamSched');   
    }
}
