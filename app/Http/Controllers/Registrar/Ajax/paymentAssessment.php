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

            
            if($academic_type=="College"){
                $tuitionfee = 0;
                //get tuition fee base on subject taken or special discount
                if($type_of_account=="Regular"){
                        $tuitionfee = $this->getCollegeTuition($idno, $school_year, $period, $level, $program_code);
                } else {
                        $tuitionfee = \App\CtrSpecialDiscount::where('special_discount_code',$type_of_account)->where('program_code',$program_code)->where('level',$level)->first()->amount;
                }
                    $addledger = new \App\ledger;
                    $addledger->idno=$idno;
                    $addledger->program_code=$program_code;
                    $addledger->level=$level;
                    $addledger->school_year=$school_year;
                    $addledger->period=$period;
                    $addledger->category="Tuition Fee";
                    $addledger->description="Tuition Fee";
                    $addledger->receipt_details="Tuition Fee";
                    $addledger->category_switch="3";

                    
                

            }
        }
    }
    
    
}
