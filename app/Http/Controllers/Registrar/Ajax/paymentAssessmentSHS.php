<?php

namespace App\Http\Controllers\Registrar\Ajax;

use Illuminate\Support\Facades\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use DB;

class paymentAssessmentSHS extends Controller {

    //
    function computePayment() {
        if (Request::ajax()) {
            $discounttf=0;
            $discountof=0;
            
            $idno = Input::get("idno");
            $level = Input::get("level");
            $period = Input::get("period");
            $school_year = Input::get("school_year");
            $currentledgers=  \App\ledger::where('idno',$idno)->where('school_year',$school_year)->get();
            if(count($currentledgers)>0){
                foreach($currentledgers as $currentledger){
                    $currentledger->delete();
                }
            }
            $deleteledgerduedates = \App\LedgerDueDate::where('idno', $idno)->where('school_year', $school_year)->get();
            if (count($deleteledgerduedates) > 0) {
                foreach ($deleteledgerduedates as $deleteledgerduedate) {
                    $deleteledgerduedate->delete();
                }
            }
            
            $esc_id = Input::get("esc");
            $esc = \App\CtrEsc::where('id', $esc_id)->first();
            $esc_amount = $esc->amount;
            $program_code = Input::get("program_code");
            $track = Input::get("track");
            $academic_type = Input::get("academic_type");
            $discount_code=Input::get('discount');
            if(!is_null($discount_code)){
            $discounttf= $this->getdiscountrate('tf', $discount_code);
            $discountof= $this->getdiscountrate('of', $discount_code);
            }
            
            if($academic_type=="Senior High School"){
                        $tfr= \App\CtrShsTuition::where('track',$track)->where('level',$level)->first();
                        $tuitionrate=$tfr->amount;
                        $otherfee = $this->getOtherFee($idno, $school_year, $period, $level, $program_code,$track,$discountof,$discount_code);
                        $tuitionfee = $this->getSHSTuition($idno,$school_year,$period,$level,$program_code,$track,$tuitionrate,$discounttf,$discount_code, $esc_amount);
                return view('registrar.assessment.ajax.shsdisplayassessment',compact('idno','school_year','level','period'));       
                
            }
        }
    }
    
    
    function getSHSTuition($idno, $school_year,$period,$level,$program_code,$track,$tuitionrate, $discounttf,$discount_code, $esc_amount){
       
        $addledger = new \App\ledger;
        $addledger->idno=$idno;
        $addledger->program_code=$program_code;
        $addledger->track=$track;
        $addledger->level=$level;
        $addledger->school_year=$school_year;
        $addledger->period=$period;
        $addledger->category="Tuition Fee";
        $addledger->description="Tuition Fee";
        $addledger->receipt_details="Tuition Fee";
        $addledger->category_switch="3";
        $addledger->amount = $tuitionrate;
        $addledger->discount = $tuitionrate*($discounttf/100);
        $addledger->discount_id = $discount_code;
        $addledger->esc = $esc_amount;
        $addledger->save();
         
    }
    
    function getOtherFee($idno, $school_year, $period, $level, $program_code,$track,$discountof,$discount_code){
        $otherfees = \App\CtrShsOtherFee::where('track',$track)->where('level',$level)->get();
        if(count($otherfees)>0){
            foreach($otherfees as $otherfee){
                $addledger = new \App\ledger;
                $addledger->idno=$idno;
                $addledger->program_code=$program_code;
                $addledger->track=$track;
                $addledger->level=$level;
                $addledger->school_year=$school_year;
                $addledger->period=$period;
                $addledger->category=$otherfee->category;
                $addledger->description=$otherfee->description;
                $addledger->receipt_details=$otherfee->receipt_details;
                $addledger->category_switch=$otherfee->category_switch;
                $addledger->amount = $otherfee->amount;
                $addledger->discount = $otherfee->amount*$discountof/100;
                $addledger->discount_id = $discount_code;
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
