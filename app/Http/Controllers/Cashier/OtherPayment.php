<?php

namespace App\Http\Controllers\Cashier;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
Use Illuminate\Support\Facades\DB;

class OtherPayment extends Controller
{
    //
      public function __construct() {
        $this->middleware('auth');
    }
    
    function otherpayment($idno){
        if(Auth::user()->accesslevel==4){
            return view("cashier.otherpayment",compact('idno'));
        }
    }
    
    function processpayment(Request $request){
        $student = \App\User::where('idno',$request->idno)->first();
        if(Auth::user()->accesslevel==4){
        $addpayment = new \App\Payment;
        $addpayment->transaction_date=  \Carbon\Carbon::now();
        $addpayment->receipt_no = $request->receipt_no;
        $addpayment->reference_id=$request->referenceid;
        $addpayment->idno=$request->idno;
        $addpayment->paid_by=$student->lastname . ", " .$student->firstname;
        $addpayment->bank_name=$request->bank;
        $addpayment->check_number=$request->checkno;
        $addpayment->cash_amount = $request->cashamount;
        $addpayment->check_amount=$request->checkamount;
        $addpayment->change_amount=$request->change;
        $addpayment->remarks=$request->remarks;
        $addpayment->posted_by=Auth::user()->idno;
        $addpayment->save();
        $acctname = $request->acctname;
        $subsidiary = $request->subsidiary;
        $explanation = $request->explanation;
        $other_amount = $request->other_amount;
        $length_of_array = count($request->acctname);
        for($i=0; $i <= $length_of_array-1; $i++){
            $acctentry = new \App\Accounting;
            $acctentry->transaction_date = \Carbon\Carbon::now();
            $acctentry->reference_id=$request->referenceid;
            $acctentry->receipt_no=$request->receipt_no;
            $acctentry->idno=$request->idno;
            $acctentry->paid_by=$student->lastname . ", " . $student->firstname;
            $acctentry->category = "Other Payment";
            $acctentry->description = $subsidiary[$i];
            $acctentry->receipt_details = $subsidiary[$i] . " - " . $explanation[$i];
            $acctentry->accounting_code = $this->getAccountingCode($acctname[$i]);
            $acctentry->category_switch="6";
            $acctentry->entry_type="1";
            $acctentry->credit = $other_amount[$i];
            $acctentry->posted_by=Auth::user()->idno;
            $acctentry->save();
        }
        
        $receipt = \App\CtrReferenceId::where('idno',Auth::user()->idno)->first();
        $receipt->receipt_no = $receipt->receipt_no + 1;
        $receipt->update();
         return redirect(url('/viewreceipt',$request->referenceid));
        }
    }
    
    function getAccountingCode($acctname){
        $acctcode = \App\ChartOfAccount::where('accounting_name',$acctname)->first();
        return $acctcode->accounting_code;
    }
    
    function nonstudent(){
        if(Auth::user()->accesslevel==4){
            return view("cashier.nonstudent");
        }
    }
    function processnonstudent(Request $request){
        
        
        if(Auth::user()->accesslevel==4){
        $addpayment = new \App\Payment;
        $addpayment->transaction_date=  \Carbon\Carbon::now();
        $addpayment->receipt_no = $request->receipt_no;
        $addpayment->reference_id=$request->referenceid;
        $addpayment->idno="999999";
        $addpayment->paid_by=$request->receive_from;
        $addpayment->bank_name=$request->bank;
        $addpayment->check_number=$request->checkno;
        $addpayment->cash_amount = $request->cashamount;
        $addpayment->check_amount=$request->checkamount;
        $addpayment->change_amount=$request->change;
        $addpayment->remarks=$request->remarks;
        $addpayment->posted_by=Auth::user()->idno;
        $addpayment->save();
        $acctname = $request->acctname;
        $subsidiary = $request->subsidiary;
        $explanation = $request->explanation;
        $other_amount = $request->other_amount;
        $length_of_array = count($request->acctname);
        for($i=0; $i <= $length_of_array-1; $i++){
            $acctentry = new \App\Accounting;
            $acctentry->transaction_date = \Carbon\Carbon::now();
            $acctentry->reference_id=$request->referenceid;
            $acctentry->receipt_no=$request->receipt_no;
            $acctentry->idno="999999";
            $acctentry->paid_by=$request->receive_from;
            $acctentry->category = "Other Payment Non Student";
            $acctentry->description = $subsidiary[$i];
            $acctentry->receipt_details = $subsidiary[$i] . " - " . $explanation[$i];
            $acctentry->accounting_code = $this->getAccountingCode($acctname[$i]);
            $acctentry->category_switch="7";
            $acctentry->entry_type="1";
            $acctentry->credit = $other_amount[$i];
            $acctentry->posted_by=Auth::user()->idno;
            $acctentry->save();
        }
        
        $receipt = \App\CtrReferenceId::where('idno',Auth::user()->idno)->first();
        $receipt->receipt_no = $receipt->receipt_no + 1;
        $receipt->update();
         return redirect(url('/viewreceipt',$request->referenceid));
        }
       
    }
}
