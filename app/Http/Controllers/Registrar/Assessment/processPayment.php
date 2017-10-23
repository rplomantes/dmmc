<?php

namespace App\Http\Controllers\Registrar\Assessment;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use DB;

class processPayment extends Controller {

    //
    public function __construct() {
        $this->middleware('auth');
    }

    function index(Request $request) {
        if (Auth::user()->accesslevel == "3") {
            $downpaymentamount = $request->downpaymentamount;
            $plan = $request->plan;
            $idno = $request->idno;
            $user = \App\Status::where('idno', $idno)->first();
            $school_year = \App\CtrSchoolYear::where('academic_type', $user->academic_type)->first();
            $totalTuition = $request->totalTuition;
            $plans = \App\CtrDueDate::where('academic_type', $request->academic_type)->where('plan', $plan)->get();

            if ($plan == 'full') {
                $addledgerduedates = new \App\LedgerDueDate;
                $addledgerduedates->idno = $idno;
                $addledgerduedates->school_year = $school_year->school_year;
                $addledgerduedates->period = $school_year->period;
                $addledgerduedates->due_switch = 0;
                $addledgerduedates->due_date = date('Y-m-d');
                $addledgerduedates->amount = $totalTuition;
                $addledgerduedates->amount2 = $totalTuition;
                $addledgerduedates->save();
            } else {
                $addledgerduedates = new \App\LedgerDueDate;
                $addledgerduedates->idno = $idno;
                $addledgerduedates->school_year = $school_year->school_year;
                $addledgerduedates->period = $school_year->period;
                $addledgerduedates->due_switch = 0;
                $addledgerduedates->due_date = date('Y-m-d');
                $addledgerduedates->amount = $downpaymentamount;
                $addledgerduedates->amount2 = $downpaymentamount;
                $addledgerduedates->save();
                foreach ($plans as $paln) {

                    $addledgerduedates = new \App\LedgerDueDate;
                    $addledgerduedates->idno = $idno;
                    $addledgerduedates->school_year = $school_year->school_year;
                    $addledgerduedates->period = $school_year->period;
                    $addledgerduedates->due_switch = 1;
                    $addledgerduedates->due_date = $paln->due_date;
                    $addledgerduedates->amount = $this->computeplan($downpaymentamount, $totalTuition, $plans);
                    $addledgerduedates->amount2 = $this->computeplan($downpaymentamount, $totalTuition, $plans);
                    $addledgerduedates->save();

                    $this->compute12percent($downpaymentamount, $totalTuition, $plans, $idno);
                }
            }
            $this->changeledgerstatus($idno);
            $this->changeStatus($idno, $plan);
            $newIDno = $this->changeIDno($idno);
            return redirect("/registrar/registration/$newIDno");
        }
    }

    function computeplan($downpaymentamount, $totalTuition, $plans) {
        $planpayment = (($totalTuition - $downpaymentamount) / count($plans) * 1.12);
        return $planpayment;
    }

    function compute12percent($downpaymentamount, $totalTuition, $plans, $idno) {
        $planpayment = (($totalTuition - $downpaymentamount) / count($plans) * 1.12);
        $rawplan = (($totalTuition - $downpaymentamount) / count($plans));
        $percent12 = ($planpayment - $rawplan);

        $status = \App\Status::where('idno', $idno)->first();
        $school_year = \App\CtrSchoolYear::where('academic_type', $status->academic_type)->first();
        $chartofaccount = \App\ChartOfAccount::where('accounting_name', "Accounts Receivables")->first();
        
        $addledger12percent = new \App\ledger;
        $addledger12percent->idno = $status->idno;
        $addledger12percent->program_code = $status->program_code;
        $addledger12percent->level = $status->level;
        $addledger12percent->school_year = $school_year->school_year;
        $addledger12percent->period = $school_year->period;
        $addledger12percent->category = "Tuition Fee";
        $addledger12percent->description = "12%";
        $addledger12percent->receipt_details = "Tuition Fee";
        $addledger12percent->receipt_type = "OR";
        $addledger12percent->accounting_code = $chartofaccount->accounting_code;
        $addledger12percent->category_switch = "3";
        $addledger12percent->amount = $percent12;
        $addledger12percent->save();
    }

    function changeledgerstatus($idno) {
        $status = \App\Status::where('idno', $idno)->first();
        $school_year = \App\CtrSchoolYear::where('academic_type', $status->academic_type)->first();

        $changeledgerstatuses = \App\ledger::where('idno', $idno)->where('level', $status->level)->where('school_year', $school_year->school_year)->where('period', $school_year->period)->get();
        foreach ($changeledgerstatuses as $changeledgerstatus) {
            $changeledgerstatus->is_final = 1;
            $changeledgerstatus->save();
        }
    }

    function changeIDno($idno) {
        $userID = Auth::user()->idno;
        $status = \App\Status::where('idno', $idno)->first();
        $referenceID = \App\CtrReferenceId::where('idno', $userID)->first();
        $year = \App\CtrSchoolYear::where('academic_type', $status->academic_type)->first();
        $inc = $referenceID->student_no;

        if (strlen($idno) > 7) {
            $changeIDno = \App\User::where('idno', $idno)->first();
            $changeIDno->old_idno = $idno;
            $newIDno = $changeIDno->idno = substr($year->school_year, 2) . "" . sprintf("%02s", $referenceID->id) . "" . sprintf("%03s", $inc);
            $changeIDno->save();

            $incID = \App\CtrReferenceId::where('idno', $userID)->first();
            $incID->student_no = $inc + 1;
            $incID->save();
            return $newIDno;
        } else {
            return $idno;
        }
    }

    function changeStatus($idno, $plan) {
        $userID = Auth::user()->idno;
        $status = \App\Status::where('idno', $idno)->first();
        $registrationID = \App\CtrReferenceId::where('idno', $userID)->first();
        $year = \App\CtrSchoolYear::where('academic_type', $status->academic_type)->first();
        $inc = $registrationID->registration_no;
        if ($plan != "full") {
            $plans = \App\CtrDueDate::distinct('plan')->where('plan', $plan)->get(['plan'])->first();
            $paln = $plans->plan;
        } else {
            $paln = "Full";
        }
        $registration_no = substr($year->school_year, -2) . "" . sprintf("%02s", $registrationID->id) . "" . sprintf("%03s", $inc);

        $changestatus = \App\Status::where('idno', $idno)->first();
        $changestatus->status = 3;
        $changestatus->registration_no = $registration_no;
        $changestatus->plan = "$paln";
        $changestatus->date_assessed = date('Y-m-d');
        $changestatus->section = NULL;
        $changestatus->save();

        $addregistrationno = new \App\RegistrationFormNo;
        $addregistrationno->idno = $idno;
        $addregistrationno->registration_no = $registration_no;
        $addregistrationno->save();

        $incID = \App\CtrReferenceId::where('idno', $userID)->first();
        $incID->registration_no = $inc + 1;
        $incID->save();
    }

}
