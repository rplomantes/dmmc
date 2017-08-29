<?php

namespace App\Http\Controllers\Registrar\Assessment;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use DB;

class processPayment extends Controller
{
    //
    function index(Request $request){
        $downpaymentamount = $request->downpaymentamount;
        $plan = $request->plan;
        $idno = $request->idno;
        $totalTuition = $request->totalTuition;
        $plans = \App\CtrDueDate::where('academic_type', $request->academic_type)->where('plan', $plan)->get();
                
        if ($plan=='full'){
            $addledgerduedates = new \App\LedgerDueDate;
            $addledgerduedates->idno=$idno;
            $addledgerduedates->due_switch=0;
            $addledgerduedates->due_date=date('Y-m-d');
            $addledgerduedates->amount=$totalTuition;
            $addledgerduedates->amount2=$totalTuition;
            $addledgerduedates->save();
        } else {
            $addledgerduedates = new \App\LedgerDueDate;
            $addledgerduedates->idno=$idno;
            $addledgerduedates->due_switch=0;
            $addledgerduedates->due_date=date('Y-m-d');
            $addledgerduedates->amount=$downpaymentamount;
            $addledgerduedates->amount2=$downpaymentamount;
            $addledgerduedates->save();
            foreach ($plans as $paln){
                                
                $addledgerduedates = new \App\LedgerDueDate;
                $addledgerduedates->idno=$idno;
                $addledgerduedates->due_switch=1;
                $addledgerduedates->due_date=$paln->due_date;
                $addledgerduedates->amount=$this->computeplan($downpaymentamount, $totalTuition, $plans);
                $addledgerduedates->amount2=$this->computeplan($downpaymentamount, $totalTuition, $plans);
                $addledgerduedates->save();
                
            $this->compute12percent($downpaymentamount, $totalTuition, $plans, $idno);
            }
        }
        $this->changeledgerstatus($idno);
        $this->changeStatus($idno);
        $newIDno=$this->changeIDno($idno);
        return redirect("/registrar/registration/$newIDno");
        
    }
    
    function computeplan($downpaymentamount, $totalTuition, $plans){
        $planpayment = (($totalTuition-$downpaymentamount)/count($plans)*1.12);
        return $planpayment;
    }
    
    function compute12percent($downpaymentamount, $totalTuition, $plans, $idno){
        $planpayment = (($totalTuition-$downpaymentamount)/count($plans)*1.12);
        $rawplan = (($totalTuition-$downpaymentamount)/count($plans));
        $percent12 = ($planpayment-$rawplan);
        
        $status= \App\Status::where('idno',$idno)->first();
        $school_year = \App\CtrSchoolYear::where('academic_type', $status->academic_type)->first();
        
        $addledger12percent = new \App\ledger;
        $addledger12percent->idno=$status->idno;
        $addledger12percent->program_code=$status->program_code;
        $addledger12percent->level=$status->level;
        $addledger12percent->school_year=$school_year->school_year;
        $addledger12percent->period=$school_year->period;
        $addledger12percent->category="Tuition Fee";
        $addledger12percent->description="12%";
        $addledger12percent->receipt_details="Tuition Fee";
        $addledger12percent->category_switch="3";
        $addledger12percent->amount = $percent12;
        $addledger12percent->save();
    }
    
    function changeledgerstatus($idno){
        $status= \App\Status::where('idno',$idno)->first();
        $school_year = \App\CtrSchoolYear::where('academic_type', $status->academic_type)->first();
        
        $changeledgerstatuses = \App\ledger::where('idno',$idno)->where('level', $status->level)->where('school_year', $school_year->school_year)->where('period', $school_year->period)->get();
        foreach ($changeledgerstatuses as $changeledgerstatus){
        $changeledgerstatus->is_final=1;
        $changeledgerstatus->save();
        }
    }
    
    function changeIDno($idno){    
        $userID = Auth::user()->idno;
        $referenceID = \App\CtrReferenceId::where('idno', $userID)->first();
        $year = date('y');
        $inc = $referenceID->student_no;
        
        if (strlen($idno)>7){
        $changeIDno = \App\User::where('idno', $idno)->first();
        $newIDno = $changeIDno->idno=$year."".sprintf("%02s", $referenceID->id)."".sprintf("%03s", $inc);
        $changeIDno->save();
        
        $incID = \App\CtrReferenceId::where('idno', $userID)->first();
        $incID->student_no=$inc+1;
        $incID->save();
        return $newIDno;
        } else {
        return $idno;
        }
    }
    
    function changeStatus($idno){
        $userID = Auth::user()->idno;
        $registrationID = \App\CtrReferenceId::where('idno', $userID)->first();
        $year = date('y');
        $inc = $registrationID->registration_no;
        
        $registration_no=$year."".sprintf("%02s", $registrationID->id)."".sprintf("%03s", $inc);
        
        $changestatus = \App\Status::where('idno', $idno)->first();
        $changestatus->status=3;
        $changestatus->registration_no=$registration_no;
        $changestatus->save();
        
        $incID = \App\CtrReferenceId::where('idno', $userID)->first();
        $incID->registration_no=$inc+1;
        $incID->save();
    }
    
}