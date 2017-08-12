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
            $plan = Input::get("plan");//cash,3months,6months
            $level = Input::get("level");
            $period = Input::get("period");
            $school_year = Input::get("school_year");
            $type_of_account = Input::get("type_of_account");//regular,15k,8k
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
        return view('registrar.assessment.ajax.displayassessment', compact('grades', 'tuition', 'other_fees', 'plans', 'type_of_account'));
    }
    
    function getCollegeTuition($idno,$school_year,$period,$level,$program_code){
        $tuitionrate = \App\CtrCollegeTuition::where('program_code',$program_code)->where('level',$level)->where('period',$period)->first()->per_unit/100;
        $gradestudent = \App\GradeCollege::where("idno",$idno)->where("school_year",$school_year)
                ->where('period',$period)->get();
        if(count($gradestudent)>0){
            $tf=0;
            foreach($gradestudent as $gs){
                $tf=$tf+(($gs->percent_tuition/100*$gs->lec)+(($gs->percent_tuition/100*$gs->lab)*3));
            }
            return $tf;
        } else{
            return  0;
        }
    }
    
    
}
