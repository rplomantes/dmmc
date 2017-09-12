<?php

namespace App\Http\Controllers\Registrar\Ajax;

use Illuminate\Support\Facades\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use DB;

class paymentAssessmentSHS extends Controller {

    public function __construct()
    {
        $this->middleware('auth');
    }
    
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
                        $tuition=$tfr->amount;
                        $getESC=$this->getESC($tuition,$discounttf,$esc_amount);
                        $tuitionfee = $this->getSHSTuition($idno,$school_year,$period,$level,$program_code,$track,$tuition,$discounttf,$discount_code, $esc_amount, $getESC);
                        $otherfee = $this->getOtherFee($idno, $school_year, $period, $level, $program_code,$track,$discountof,$discount_code, $esc_amount,$getESC);
                return view('registrar.assessment.ajax.shsdisplayassessment',compact('idno','school_year','level','period'));       
                
            }
        }
    }
    
    function getESC($tuition,$discounttf,$esc_amount){
        $discount= $tuition*($discounttf/100);
        
        $bal = $tuition-$discount;
        
        if ($discounttf==0){
            return $esc_amount;
        }else if($bal<=0){
            return 0;
        }else if ($bal>=$esc_amount){
            return $esc_amount;
        }else {
            return ($esc_amount-($esc_amount-$bal));
            
        }
    }
    
    function getSHSTuition($idno, $school_year,$period,$level,$program_code,$track,$tuition, $discounttf,$discount_code, $esc_amount,$getESC){
       
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
        $addledger->accounting_code=100100;
        $addledger->category_switch="3";
        $addledger->amount = $tuition;
        $addledger->discount = $tuition*($discounttf/100);
        $addledger->discount_code = $discount_code;
        $addledger->esc = $getESC;
        $addledger->save();
         
    }
    
    function getOtherFee($idno, $school_year, $period, $level, $program_code,$track,$discountof,$discount_code,$esc_amount,$getESC){
        $otherfees = \App\CtrShsOtherFee::where('track',$track)->where('level',$level)->get();
        if(count($otherfees)>0){
            $sumamount = 0;
            $sumdiscount = 0;
            foreach($otherfees as $otherfee){
                $sumamount = $sumamount + $otherfee->amount;
                $sumdiscount = $sumdiscount + ($otherfee->amount*($discountof/100));
                
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
                $addledger->accounting_code=$otherfee->accounting_code;
                $addledger->category_switch=$otherfee->category_switch;
                $addledger->amount = $otherfee->amount;
                $addledger->discount = $otherfee->amount*($discountof/100);
                $addledger->discount_code = $discount_code;
                //$addledger->esc = ($esc_amount-$getESC)/count($otherfees);
                $addledger->save();
            }
            
            $difference=$sumamount-$sumdiscount;
            $updateesc = \App\ledger::where('idno', $idno)->where('program_code', $program_code)->where('track', $track)->where('level', $level)->where('school_year', $school_year)->where('period', $period)->where('category_switch', $otherfee->category_switch)->get();
            $tesc = $esc_amount-$getESC;
            
            foreach ($updateesc as $updateescs){
                $amount=$updateescs->amount;
                $discounts=$updateescs->discount;
                $esc = number_format((($amount-$discounts)/$difference)*($esc_amount-$getESC),2);

                if ($tesc<=$esc){
                    $updateescs->esc = $tesc;
                    $updateescs->save();
                } else {
                    $updateescs->esc = $esc;
                    $updateescs->save();  
                
                    $tesc = $tesc-$esc;
                }
            }
        }
    }
    
    function getdiscountrate($type,$discount_code){
        if($type=='tf'){
            return \App\CtrDiscount::where('discount_code',$discount_code)->first()->tuition_fee;
          
        }elseif($type=='of'){
            return \App\CtrDiscount::where('discount_code',$discount_code)->first()->other_fee;
        }
        
    }
}
