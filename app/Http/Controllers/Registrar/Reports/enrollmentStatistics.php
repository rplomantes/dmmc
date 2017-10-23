<?php

namespace App\Http\Controllers\Registrar\Reports;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class enrollmentStatistics extends Controller
{
    //
    public function __construct() {
        $this->middleware('auth');
    }
    
    function index (){
        if (Auth::user()->accesslevel == "3") {
        return view('registrar.reports.enrollment_statistics');
        }
    }
    
}
