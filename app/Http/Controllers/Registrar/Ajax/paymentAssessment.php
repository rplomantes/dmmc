<?php

namespace App\Http\Controllers\Registrar\Ajax;

use Illuminate\Support\Facades\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;

class paymentAssessment extends Controller {

    function computePayment() {
        if (Request::ajax()) {
            $discounttf = 0;
            $discountof = 0;

            $idno = Input::get("idno");
            $plan = Input::get("plan");
            $level = Input::get("level");
            $period = Input::get("period");
            $school_year = Input::get("school_year");
            $currentledgers = \App\ledger::where('idno', $idno)->where('school_year', $school_year)->where('period', $period)->get();
            if (count($currentledgers) > 0) {
                foreach ($currentledgers as $currentledger) {
                    $currentledger->delete();
                }
            }

            $deleteledgerduedates = \App\LedgerDueDate::where('idno', $idno)->where('school_year', $school_year)->where('period', $period)->get();
            if (count($deleteledgerduedates) > 0) {
                foreach ($deleteledgerduedates as $deleteledgerduedate) {
                    $deleteledgerduedate->delete();
                }
            }
            
            $changestatus = \App\Status::where('idno', $idno)->first();
            $changestatus->status = 2;
            $changestatus->save();

            $type_of_account = Input::get("type_of_account");
            $program_code = Input::get("program_code");
            $academic_type = Input::get("academic_type");
            $discount_code = Input::get('discount');
            if (!is_null($discount_code)) {
                $discounttf = $this->getdiscountrate('tf', $discount_code);
                $discountof = $this->getdiscountrate('of', $discount_code);
            }

            if ($academic_type == "College") {
                if ($type_of_account == "regular") {
                    $tfr = \App\CtrCollegeTuition::where('program_code', $program_code)->where('level', $level)->first();
                    $tuitionrate = $tfr->per_unit;
                    $otherfee = $this->getOtherFee($idno, $school_year, $period, $level, $program_code, $discountof, $discount_code);
                    $tuitionfee = $this->getCollegeTuition($idno, $school_year, $period, $level, $program_code, $tuitionrate, $discounttf, $discountof, $discount_code);
                    return view('registrar.assessment.ajax.collegedisplayassessment', compact('idno', 'school_year', 'level', 'period'));
                } else {
                    $tuitionfee = \App\CtrSpecialDiscount::where('special_discount_code', $type_of_account)->where('program_code', $program_code)->where('level', $level)->first()->amount;
                    $accounting_code = \App\CtrSpecialDiscount::where('special_discount_code', $type_of_account)->where('program_code', $program_code)->where('level', $level)->first()->accounting_code;
                    $addledger = new \App\ledger;
                    $addledger->idno = $idno;
                    $addledger->program_code = $program_code;
                    $addledger->level = $level;
                    $addledger->school_year = $school_year;
                    $addledger->period = $period;
                    $addledger->category = "Tuition Fee";
                    $addledger->description = $type_of_account;
                    $addledger->receipt_details = "Tuition Fee";
                    $addledger->accounting_code = $accounting_code;
                    $addledger->category_switch = "3";
                    $addledger->amount = $tuitionfee;
                    $addledger->save();
                    $otherfee = $this->getOtherFee($idno, $school_year, $period, $level, $program_code, $discountof, $discount_code);
                    $grades = \App\GradeCollege::where('idno', $idno)->where('school_year', $school_year)->where('period', $period)->get();
                    if (count($grades) > 0) {
                        $lab = 0;
                        foreach ($grades as $grade) {
                            $this->getSpecialFee($grade->course_code, $level, $program_code, $school_year, $period, $idno);
                            $lab = $lab + $grade->lab;
                        }
                        if ($lab > 0) {
                            $this->getLabFee($idno, $program_code, $level, $period, $school_year, $discountof);
                        }
                    }
                    return view('registrar.assessment.ajax.collegedisplayassessment', compact('idno', 'school_year', 'level', 'period'));
                }
            }
        }
    }

    function getCollegeTuition($idno, $school_year, $period, $level, $program_code, $tuitionrate, $discounttf, $discountof, $discount_code) {
        $grades = \App\GradeCollege::where('idno', $idno)->where('school_year', $school_year)->where('period', $period)->get();
        if (count($grades) > 0) {
            $lab = 0;
            foreach ($grades as $grade) {
                $addledger = new \App\ledger;
                $addledger->idno = $idno;
                $addledger->program_code = $program_code;
                $addledger->level = $level;
                $addledger->school_year = $school_year;
                $addledger->period = $period;
                $addledger->category = "Tuition Fee";
                $addledger->description = $grade->course_code;
                $addledger->receipt_details = "Tuition Fee";
                $addledger->accounting_code = "100100";
                $addledger->category_switch = "3";
                $addledger->amount = (($grade->lec * $tuitionrate * $grade->percent_tuition / 100) + (($grade->lab * $tuitionrate * $grade->percent_tuition / 100) * 3));
                $addledger->discount = (($grade->lec * $tuitionrate * $grade->percent_tuition / 100) + (($grade->lab * $tuitionrate * $grade->percent_tuition / 100) * 3)) * ($discounttf / 100);
                $addledger->discount_code = $discount_code;
                $addledger->save();
                $this->getSpecialFee($grade->course_code, $level, $program_code, $school_year, $period, $idno);
                $lab = $lab + $grade->lab;
            }
            if ($lab > 0) {
                $this->getLabFee($idno, $program_code, $level, $period, $school_year, $discountof);
            }
        }
    }

    function getOtherFee($idno, $school_year, $period, $level, $program_code, $discountof, $discount_code) {
        $otherfees = \App\CtrCollegeOtherFee::where('program_code', $program_code)->where('level', $level)->where('period', $period)->get();
        if (count($otherfees) > 0) {
            foreach ($otherfees as $otherfee) {
                $addledger = new \App\ledger;
                $addledger->idno = $idno;
                $addledger->program_code = $program_code;
                $addledger->level = $level;
                $addledger->school_year = $school_year;
                $addledger->period = $period;
                $addledger->category = $otherfee->category;
                $addledger->description = $otherfee->description;
                $addledger->receipt_details = $otherfee->receipt_details;
                $addledger->accounting_code = $otherfee->accounting_code;
                $addledger->category_switch = $otherfee->category_switch;
                $addledger->amount = $otherfee->amount;
                $addledger->discount = $otherfee->amount * ($discountof / 100);
                $addledger->discount_code = $discount_code;
                $addledger->save();
            }
        }
    }

    function getSpecialFee($course_code, $level, $program_code, $school_year, $period, $idno) {
        $fees = \App\CtrSpecialFee::where('course_code', $course_code)->get();
        if (count($fees) > 0) {
            foreach ($fees as $fee) {
                $addledger = new \App\ledger;
                $addledger->idno = $idno;
                $addledger->program_code = $program_code;
                $addledger->level = $level;
                $addledger->school_year = $school_year;
                $addledger->period = $period;
                $addledger->category = $fee->category;
                $addledger->description = $fee->description;
                $addledger->receipt_details = $fee->receipt_details;
                $addledger->accounting_code = $fee->accounting_code;
                $addledger->category_switch = $fee->category_switch;
                $addledger->amount = $fee->amount;
                $addledger->save();
            }
        }
    }

    function getdiscountrate($type, $discount_code) {
        if ($type == 'tf') {
            return \App\CtrDiscount::where('discount_code', $discount_code)->first()->tuition_fee;
        } elseif ($type == 'of') {
            return \App\CtrDiscount::where('discount_code', $discount_code)->first()->other_fee;
        }
    }

    function getLabFee($idno, $program_code, $level, $period, $school_year, $discountof) {
        $labfee = \App\CtrLabFee::where('program_code', $program_code)->where('level', $level)
                        ->where('period', $period)->first();
        $addledger = new \App\ledger;
        $addledger->idno = $idno;
        $addledger->program_code = $program_code;
        $addledger->level = $level;
        $addledger->school_year = $school_year;
        $addledger->period = $period;
        $addledger->category = $labfee->category;
        $addledger->description = $labfee->description;
        $addledger->receipt_details = $labfee->receipt_details;
        $addledger->accounting_code = $labfee->accounting_code;
        $addledger->category_switch = $labfee->category_switch;
        $addledger->amount = $labfee->amount;
        $addledger->discount = $labfee->amount * $discountof / 100;
        $addledger->save();
    }

}
