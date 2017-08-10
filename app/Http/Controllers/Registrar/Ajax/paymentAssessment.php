<?php

namespace App\Http\Controllers\Registrar\Ajax;

use Illuminate\Support\Facades\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use DB;

class paymentAssessment extends Controller {

    //
    function computePayment() {
        if (Request::ajax()) {

            $idno = Input::get("idno");
            $plan = Input::get("plan");
            $level = Input::get("level");
            $period = Input::get("period");
            $school_year = Input::get("school_year");
            $type_of_account = Input::get("type_of_account");
            $program_code = Input::get("program_code");
            $academic_type = Input::get("academic_type");

            if ($type_of_account == "regular") {

                if ($academic_type == "College") {
                    $grades = \App\GradeCollege::where('idno', $idno)->where('school_year', $school_year)->where('period', $period)->get();
                    $tuition = \App\CtrCollegeTuition::where('program_code', $program_code)->where('level', $level)->where('period',$period)->first();
                    $other_fees = \App\CtrCollegeOtherFee::where('program_code', $program_code)->where('level', $level)->where('period',$period)->get();
                    $plans = \App\CtrDueDate::where('plan', $plan)->get();
                } else if ($status->academic_type == "Senior High School") {
                    $grades = \App\GradeShs::where('idno', $idno)->where('school_year', $school_year)->where('period', $period)->get();
                } else {}
                
                return view('registrar.assessment.ajax.displayassessment', compact('grades', 'tuition', 'other_fees', 'plans', 'type_of_account'));
                
            } else if ($type_of_account == "Special Discount(15k)") {
                
                if ($academic_type == "College") {
                    $grades = \App\GradeCollege::where('idno', $idno)->where('school_year', $school_year)->where('period', $period)->get();
                    $tuition = \App\CtrSpecialDiscount::where('special_discount_code',$plan)->where('program_code', $program_code)->where('level', $level)->get();
                    $other_fees = \App\CtrCollegeOtherFee::where('program_code', $program_code)->where('level', $level)->where('period',$period)->get();
                    $plans = \App\CtrDueDate::where('plan', $plan)->get();
                } else if ($status->academic_type == "Senior High School") {
                    $grades = \App\GradeShs::where('idno', $idno)->where('school_year', $school_year)->where('period', $period)->get();
                } else {}
                
                return view('registrar.assessment.ajax.displayassessment', compact('grades', 'tuition', 'other_fees', 'plans', 'type_of_account'));
                
            } else if ($type_of_account == "Special Discount(8k)") {
                return ($type_of_account);
            } else {
                return ('Please Select Type of Account!');
            }
        }
    }

}
