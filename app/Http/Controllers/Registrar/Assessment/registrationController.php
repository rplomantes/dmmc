<?php

namespace App\Http\Controllers\Registrar\Assessment;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use PDF;

class registrationController extends Controller
{
    function index($idno){
        return view('registrar.assessment.summaryofpayment',compact('idno'));
    }
    
    function reassess($idno){
        $status = \App\Status::where('idno', $idno)->first();
        $school_year = \App\CtrSchoolYear::where('academic_type', $status->academic_type)->first();
        
        $changestatus = \App\Status::where('idno', $idno)->first();
        $changestatus->status = 2;
        $changestatus->save();
        
        $deleteledgers = \App\ledger::where('idno', $idno)->where('school_year', $school_year->school_year)->where('period', $school_year->period)->get();
        foreach ($deleteledgers as $deleteledger){
            $deleteledger->delete();
        }
        
        $deleteledgerduedates = \App\LedgerDueDate::where('idno', $idno)->where('school_year', $school_year->school_year)->where('period', $school_year->period)->get();
        foreach ($deleteledgerduedates as $deleteledgerduedate){
            $deleteledgerduedate->delete();
        }
        return redirect("/registrar/assess_payment/$idno");
    }
    
    function printform($idno){
        $user = \App\User::where('idno', $idno)->first();
        $status = \App\Status::where('idno', $idno)->first();
        $school_year = \App\CtrSchoolYear::where('academic_type', $status->academic_type)->first();
        $ledger_due_dates = \App\LedgerDueDate::where('idno', $idno)->where('school_year', $school_year->school_year)->where('period', $school_year->period)->where('due_switch', 1)->get();
        $downpayment = \App\LedgerDueDate::where('idno', $idno)->where('school_year', $school_year->school_year)->where('period', $school_year->period)->where('due_switch', 0)->first();
        
        if ($status->academic_type == 'College'){
            $grades = \App\GradeCollege::where('idno', $idno)->where('school_year', $school_year->school_year)->where('period', $school_year->period)->get();
        }else{
            $grades = \App\GradeShs::where('idno', $idno)->where('school_year', $school_year->school_year)->where('period', $school_year->period)->get();
        }
        
        $pdf = PDF::loadView('registrar.print.registration_form', compact('grades','user', 'status','school_year', 'ledger_due_dates', 'downpayment'));
        return $pdf->stream("registration_form_$status->registration_no.pdf");
    }
}
