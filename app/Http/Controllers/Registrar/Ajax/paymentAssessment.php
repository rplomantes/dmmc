<?php

namespace App\Http\Controllers\Registrar\Ajax;

use Illuminate\Support\Facades\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;

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

            if ($academic_type == "College") {
                    $grades = \App\GradeCollege::where('idno', $idno)->where('school_year', $school_year)->where('period', $period)->get();
                    $other_fees = \App\CtrCollegeOtherFee::where('program_code', $program_code)->where('level', $level)->where('period', $period)->get();
                    $plans = \App\CtrDueDate::where('plan', $plan)->get();
                    $lab_fee = \App\CtrLabFee::where('program_code', $program_code)->where('level', $level)->where('period', $period)->first();
                    
                
                if ($type_of_account == "regular") {
                    $tuition = \App\CtrCollegeTuition::where('program_code', $program_code)->where('level', $level)->where('period', $period)->first();
                } else {
                    $tuition = \App\CtrSpecialDiscount::where('special_discount_code', $type_of_account)->where('program_code', $program_code)->where('level', $level)->first();
                }
                
                return view('registrar.assessment.ajax.collegedisplayassessment', compact('grades', 'tuition', 'other_fees', 'plans', 'plan', 'type_of_account','lab_fee'));
                
            } else if ($academic_type == "Senior High School") {
                
            } else {
                
            }
        }
    }

}
