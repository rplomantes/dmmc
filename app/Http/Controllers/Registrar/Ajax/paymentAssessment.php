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
            $discount_code=Input::get('discount');
            $discounttf= $this->getdiscountrate('tf', $discount_code);
            $discountof= $this->getdiscountrate('of', $discount_code);
            
            
            if($academic_type=="College"){
                if($type_of_account=="regular"){
                        $tfr=  \App\CtrCollegeTuition::where('program_code',$program_code)->where('level',$level)->first();
                        $tuitionrate=$tfr->per_unit;
                        $otherfee = $this->getOtherFee($idno, $school_year, $period, $level, $program_code);
                        $tuitionfee = $this->getCollegeTuition($idno,$school_year,$period,$level,$program_code,$tuitionrate,$discounttf);
                 return view('registrar.assessment.ajax.collegedisplayassessment',compact('idno','school_year','level','period'));       
                } else {
                        $tuitionfee = \App\CtrSpecialDiscount::where('special_discount_code',$type_of_account)->where('program_code',$program_code)->where('level',$level)->first()->amount;
                }
 
            }
        }
    }
    
    
    function getCollegeTuition($idno, $school_year,$period,$level,$program_code,$tuitionrate, $discounttf){
        $grades = \App\GradeCollege::where('idno',$idno)->where('school_year',$school_year)->where('period',$period)->get();
        if(count($grades)>0){
            foreach($grades as $grade){
                    $addledger = new \App\ledger;
                    $addledger->idno=$idno;
                    $addledger->program_code=$program_code;
                    $addledger->level=$level;
                    $addledger->school_year=$school_year;
                    $addledger->period=$period;
                    $addledger->category="Tuition Fee";
                    $addledger->description=$grade->course_code;
                    $addledger->receipt_details="Tuition Fee";
                    $addledger->category_switch="3";
                    $addledger->amount = (($grade->lec * $tuitionrate * $grade->percent_tuition/100)+(($grade->lab * $tuitionrate * $grade->percent_tuition/100)*3));
                    $addledger->discount = (($grade->lec * $tuitionrate * $grade->percent_tuition/100)+(($grade->lab * $tuitionrate * $grade->percent_tuition/100)*3)) * ($discounttf/100);
                    $addledger->save();
                    $this->getSpecialFee($grade->course_code, $level, $program_code, $school_year, $period, $idno);
            }
        }
    }
    
    function getOtherFee($idno,$school_year,$period,$level,$program_code){
        $otherfees = \App\CtrCollegeOtherFee::where('program_code',$program_code)->where('level',$level)->where('period',$period)->get();
        if(count($otherfees)>0){
            foreach($otherfees as $otherfee){
                $addledger = new \App\ledger;
                    $addledger->idno=$idno;
                    $addledger->program_code=$program_code;
                    $addledger->level=$level;
                    $addledger->school_year=$school_year;
                    $addledger->period=$period;
                    $addledger->category=$otherfee->category;
                    $addledger->description=$otherfee->description;
                    $addledger->receipt_details=$otherfee->receipt_details;
                    $addledger->category_switch=$otherfee->category_switch;
                    $addledger->amount = $otherfee->amount;
                    $addledger->save();
            }
        }
    }
    
    function getSpecialFee($course_code,$level,$program_code,$school_year,$period,$idno){
        $fees = \App\CtrSpecialFee::where('course_code',$course_code)->get();
        if(count($fees)>0){
            foreach($fees as $fee){
                    $addledger = new \App\ledger;
                    $addledger->idno=$idno;
                    $addledger->program_code=$program_code;
                    $addledger->level=$level;
                    $addledger->school_year=$school_year;
                    $addledger->period=$period;
                    $addledger->category=$fee->category;
                    $addledger->description=$fee->description;
                    $addledger->receipt_details=$fee->receipt_details;
                    $addledger->category_switch=$fee->category_switch;
                    $addledger->amount = $fee->amount;
                    $addledger->save();
            }
        }
    }
    
    function getdiscountrate($type,$discount_code){
        if($type=='tf'){
            return \App\CtrDiscount::where('discount_code',$discount_code)->tuition_fee;
          
        }elseif($type=='of'){
            return $discount = \App\CtrDiscount::where('discount_code',$discount_code)->other_fee;
        }
        
    }
    
}
