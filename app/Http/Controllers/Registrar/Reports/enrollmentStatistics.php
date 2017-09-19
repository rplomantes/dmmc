<?php

namespace App\Http\Controllers\Registrar\Reports;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class enrollmentStatistics extends Controller
{
    //
    public function __construct() {
        $this->middleware('auth');
    }
    
    function index (){
        return view('registrar.reports.enrollment_statistics');
    }
    
}
