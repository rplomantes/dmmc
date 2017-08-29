<?php

namespace App\Http\Controllers\Registrar\Assessment;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class registrationController extends Controller
{
    function index($idno){
        return view('registrar.assessment.summaryofpayment',compact('idno'));
    }
}
