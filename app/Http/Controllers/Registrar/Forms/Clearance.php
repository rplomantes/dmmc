<?php

namespace App\Http\Controllers\Registrar\Forms;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use PDF;

class Clearance extends Controller {

    //
    public function __construct() {
        $this->middleware('auth');
    }

    function viewClearance() {
        if (Auth::user()->accesslevel == "3") {
            return view('registrar.forms.view_clearance');
        }
    }

    function viewBlank_clearance() {
        if (Auth::user()->accesslevel == "3") {

            $pdf = PDF::loadView('registrar.forms.print.REGForm01-2011_blank');
            $pdf->setPaper(array(0, 0, 612.00, 936.0));
            return $pdf->stream("REGForm01-2011.pdf");
        }
    }

    function view_clearance($idno) {
        if (Auth::user()->accesslevel == "3") {

            $user = \App\User::where('idno', $idno)->first();
            $status = \App\Status::where('idno', $idno)->first();
            $studentinfo = \App\StudentInfo::where('idno', $idno)->first();

            $pdf = PDF::loadView('registrar.forms.print.REGForm01-2011', compact('user', 'status', 'studentinfo'));
            $pdf->setPaper(array(0, 0, 612.00, 936.0));
            return $pdf->stream("REGForm01-2011.pdf");
        }
    }

    function bulk_clearance(Request $request) {
        if (Auth::user()->accesslevel == "3") {
            $level = $request->level;
            $course = $request->course;
            $section = $request->section;
            
            if ($course == "ABM" or $course == "STEM" or $course == "GAS" or $course == "HUMMS"){
                $school_year = \App\CtrGradeSchoolYear::where('academic_type', 'Senior High School')->first();
                $statuses = \App\Status::where('status', 4)->where('level', $level)->where('section', $section)->where('academic_type', 'Senior High School')->where('track', $course)->where('school_year',$school_year->school_year)->where('period', 'yearly')->get();
            }else{
                $school_year = \App\CtrSchoolYear::where('academic_type', 'College')->first();
                $statuses = \App\Status::where('status', 4)->where('level', $level)->where('section', $section)->where('academic_type', 'College')->where('program_code', $course)->where('school_year',$school_year->school_year)->where('period', $school_year->period)->get();   
            }
            $pdf = PDF::loadView('registrar.forms.print.REGForm01-2011_bulk', compact('statuses'));
            $pdf->setPaper(array(0, 0, 612.00, 936.0));
            return $pdf->stream("REGForm01-2011_$section.pdf");
        }
    }

}
