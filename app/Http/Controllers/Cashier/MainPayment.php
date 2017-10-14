<?php

namespace App\Http\Controllers\Cashier;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
Use Illuminate\Support\Facades\DB;
//Use Carbon;

class MainPayment extends Controller
{
    public $withOr = 0;
    public $withAR = 0;
    public $receipt_no ="";
    public $acknowlegment_no="";
    public $reference_id="";
    
      public function __construct() {
        $this->middleware('auth');
    }
    //
    function index($idno){
        if(Auth::user()->accesslevel==4){
        return view('cashier.mainpayment',compact('idno'));
        } else
        {
            return "Unauthorized to view this record";
        }
    }
    
    function processpayment(Request $request){
        if(Auth::user()->accesslevel==4){
            $referenceno = \App\CtrReferenceId::where('idno',Auth::user()->idno)->first();
            $this->receipt_no=$referenceno->receipt_no;
            $this->acknowlegment_no=$referenceno->id . " - " . $referenceno->acknowledgement_no;
            $this ->reference_id=uniqid();
            
            $idno = $request->idno;
            $student=  \App\User::where('idno',$idno)->first();
            //$referenceno = \App\CtrReferenceId::where('idno',Auth::user()->idno)->first();
            //$receiptno = $referenceno->receipt_no;
            //$acknowlegeno =  $referenceno->id . " - " . $referenceno->acknowledgement_no;
            $referenceid = uniqid();
            $cashamount=0;
             $remarks = $request->remarks;
             if(isset($request->previousaccount)){
                if($request->previousaccount > 0){
                    $previousaccounts = DB::Select("select * from ledgers where category_switch >= 10 and "
                        . "amount-discount-debit_memo-payment-esc > 0 and idno = '$idno'");
                    //$previousaccounts = \App\ledger::where('idno',$idno)->where("category_switch",">=","10")->where("amount-debit_memo-discount-payment-esc",">","0")->get();
                    $this->process_current_previous_acct($idno, $request->previousaccount, $previousaccounts,$student);
                    $cashamount=$cashamount+$request->previousaccount;    
                } 
            }
            
             if(isset($request->mainaccount)){
                if($request->mainaccount > 0){
                   $mainaccounts = DB::Select("select * from ledgers where category_switch <= 5 and "
                        . "amount-discount-debit_memo-payment-esc > 0 and idno = '$idno'");
                   //$mainaccounts = \App\ledger::where('idno',$idno)->where("category_switch","<=","5")->where("amount-debit_memo-discount-payment-esc",">","0")->get();
                   $this->process_current_previous_acct($idno,$request->mainaccount,$mainaccounts,$student);    
                   $cashamount=$cashamount+$request->mainaccount;
                   
                }
             } 
             
             if(isset($request->otheracct)){
                 $otheraccount = $request->otheracct;
                 foreach($otheraccount as $key=>$value){
                     $otheraccounts = \App\ledger::where('id',$key)->get();
                     $this->process_current_previous_acct($idno,$value,$otheraccounts,$student);
                     $cashamount=$cashamount+$value;
                 }
             }
             
             $this->add_debit_cash_entry($idno,$cashamount,$student);
             $this->add_payment_details($request,$student,$idno);
             
             $receipt = \App\CtrReferenceId::where('idno',Auth::user()->idno)->first();
             if($this->withOr=="1"){
             $receipt->receipt_no = $receipt->receipt_no + 1;
             $receipt->update();
             }
             if($this->withAR=="1"){
             $receipt->acknowledgement_no = $receipt->acknowledgement_no + 1;
             $receipt->update();        
             }
             $status = \App\Status::where('idno',$idno)->first();
             if($status->status==3){
                $status->status=4;
                $status->date_enrolled=\Carbon\Carbon::now();
                $status->update();
             }
             
             return redirect(url('/viewreceipt',$this->reference_id));
             
        }else{
            return "Unauthorized to access this module. Please see Administrator!!!";
        }
            
    }
    function process_current_previous_acct($idno,$acct_amount,$accounts,$student){
            
               $fiscalyear = \App\CtrFiscalYear::first()->fiscal_year;   
            //process payment for main and previous balances
                foreach($accounts as $account){
                    $refid=$account->id;
                    $amount=$account->amount;
                    $discount=$account->discount;
                    $debit_memo=$account->debit_memo;
                    $payment=$account->payment;
                    $esc=$account->esc;
                    $balance = $amount-$discount-$debit_memo-$payment-$esc;
                    if($acct_amount >= $balance){
                        //$account->payment = $balance;
                        $updatedb=DB::Select("update ledgers set payment = payment + '$balance' where id = '$refid'");
                        //$account->update();
            
                      //entry to accountings
                        $acctentry = new \App\Accounting;
                        $acctentry->transaction_date = \Carbon\Carbon::now();
                        $acctentry->refid=$refid;
                        $acctentry->reference_id=$this->reference_id;
                        if($account->receipt_type=="OR"){
                        $acctentry->receipt_no=$this->receipt_no;
                        $this->withOr=1;
                        }
                        else{
                        $this->withAR=1;
                        $acctentry->acknowledgement_no=$this->acknowlegment_no;    
                        }
                        $acctentry->receipt_type=$account->receipt_type;
                        $acctentry->idno=$idno;
                        $acctentry->paid_by=$student->lastname . "' " . $student->firstname;
                        $acctentry->category = $account->category;
                        $acctentry->description = $account->description;
                        $acctentry->receipt_details = $account->receipt_details;
                        $acctentry->accounting_code = $account->accounting_code;
                        $acctentry->category_switch=$account->category_switch;
                        $acctentry->entry_type="1";
                        $acctentry->fiscal_year=$fiscalyear;
                        $acctentry->credit = $amount-$debit_memo-$payment-$esc;
                        $acctentry->posted_by=Auth::user()->idno;
                        $acctentry->save();
                        
                        if($discount > 0){
                            $discounts = \App\CtrDiscount::where("discount_code",$account->discount_code)->first();
                            $debit_accounting_code = $discounts->accounting_code;
                            $debit_description = $discounts->discount_description;
                            $acctentry = new \App\Accounting;
                            $acctentry->transaction_date = \Carbon\Carbon::now();
                            $acctentry->refid=$refid;
                            $acctentry->reference_id=$this->reference_id;
                            if($discounts->receipt_type=="OR"){
                            $acctentry->receipt_no=$this->receipt_no;
                            } else {
                              $acctentry->acknowledgement_no=$this->acknowlegment_no;  
                            }
                            $acctentry->idno=$idno;
                            $acctentry->paid_by=$student->lastname . "' " . $student->firstname;
                            $acctentry->category = "Discount";
                            $acctentry->description = $debit_description;
                            $acctentry->receipt_details = "Discount";
                            $acctentry->accounting_code = $debit_accounting_code;
                            $acctentry->category_switch=$account->category_switch;
                            $acctentry->entry_type="1";
                            $acctentry->fiscal_year=$fiscalyear;
                            $acctentry->debit = $discount;
                            $acctentry->posted_by=Auth::user()->idno;
                            $acctentry->save();
                        }
                       /* if($esc > 0){
                            $acctentry = new \App\Accounting;
                            $acctentry->transaction_date = \Carbon\Carbon::now();
                            $acctentry->refid=$refid;
                            $acctentry->reference_id=$referenceid;
                            $acctentry->receipt_no=$receiptno;
                            $acctentry->idno=$idno;
                            $acctentry->paid_by=$student->lastname . "' " . $student->firstname;
                            $acctentry->category = "ESC";
                            $acctentry->description = "ESC";
                            $acctentry->receipt_details = "ESC";
                            $acctentry->accounting_code = "escaactcode";
                            $acctentry->category_switch=$account->category_switch;
                            $acctentry->entry_type="1";
                            $acctentry->debit = $esc;
                            $acctentry->posted_by=Auth::user()->idno;
                            $acctentry->save();
                        }*/
                        $acct_amount = $acct_amount-$balance;
                              
                      //end of entry to accounting  
                    } else{
                        if($acct_amount==0){
                            break;
                        }
                        $updatedb=DB::Select("update ledgers set payment = payment + '$acct_amount' where id = '$refid'");
                        //$account->payment = $acct_amount;
                        //$account->update();
                        //Accounting Entry
                        $acctentry = new \App\Accounting;
                        $acctentry->transaction_date = \Carbon\Carbon::now();
                        $acctentry->refid=$refid;
                        $acctentry->reference_id=$this->reference_id;
                       
                        if($account->receipt_type == "OR"){
                        $acctentry->receipt_no=$this->receipt_no;
                        $this->withOr=1;
                        }else{
                        $acctentry->acknowledgement_no=$this->acknowlegment_no;
                        $this->withAR=1;
                        }
                        $acctentry->idno=$idno;
                        $acctentry->paid_by=$student->lastname . "' " . $student->firstname;
                        $acctentry->category = $account->category;
                        $acctentry->description = $account->description;
                        $acctentry->receipt_details = $account->receipt_details;
                        $acctentry->accounting_code = $account->accounting_code;
                        $acctentry->category_switch=$account->category_switch;
                        $acctentry->entry_type="1";
                        $acctentry->fiscal_year=$fiscalyear;
                        $acctentry->credit = $acct_amount;
                        $acctentry->posted_by=Auth::user()->idno;
                        $acctentry->save();
                        //End Accountiing Entry
                        $acct_amount=0;
                    }
                }
                
    }
    
    function add_debit_cash_entry($idno,$cashamount,$student){
        $fiscalyear = \App\CtrFiscalYear::first()->fiscal_year;
        $entries = \App\CtrCashierDebit::first();
        $acctentry = new \App\Accounting;
        $acctentry->reference_id=$this->reference_id;
        $acctentry->transaction_date = \Carbon\Carbon::now();
        if($this->withOr=="1"){
        $acctentry->receipt_no=$this->receipt_no;
        }
        if($this->withAR=="1"){
         $acctentry->acknowledgement_no= $this->acknowlegment_no;   
        }
        $acctentry->idno=$idno;
        $acctentry->paid_by=$student->lastname . ", " . $student->firstname;
        $acctentry->category = $entries->accounting_name;
        $acctentry->description = $entries->accounting_name;
        $acctentry->receipt_details = "Total Amount";
        $acctentry->accounting_code = $entries->accounting_code;
        $acctentry->category_switch="";
        $acctentry->entry_type="1";
        $acctentry->fiscal_year=$fiscalyear;
        $acctentry->debit = $cashamount;
        $acctentry->posted_by=Auth::user()->idno;
        $acctentry->save();
        
    }
    
    function add_payment_details($request,$student,$idno){
       
        $addpayment = new \App\Payment;
        $addpayment->transaction_date=  \Carbon\Carbon::now();
        if($this->withOr=="1"){
        $addpayment->receipt_no = $this->receipt_no;
        }
        if($this->withAR=="1"){
        $addpayment->acknowledgement_no = $this->acknowlegment_no;    
        }
        $addpayment->reference_id=$this->reference_id;
        $addpayment->idno=$idno;
        $addpayment->paid_by=$student->lastname . ", " .$student->firstname;
        $addpayment->bank_name=$request->bank;
        $addpayment->check_number=$request->checkno;
        $addpayment->cash_amount = $request->cashamount;
        $addpayment->check_amount=$request->checkamount;
        $addpayment->change_amount=$request->change;
        $addpayment->remarks=$request->remarks;
        $addpayment->posted_by=Auth::user()->idno;
        $addpayment->save();
    }
    
    function reverserestore($reference_id,$action){
        if(Auth::user()->accesslevel==4){
            //$accountings = \App\Accounting::where('reference_id',$reference_id)->get();
            
                if($action == "reverse"){
                    $accountings = \App\Accounting::where('reference_id',$reference_id)->get();
                    foreach($accountings as $accounting){
                        $ledger=  \App\ledger::find($accounting->refid);
                        if(count($ledger)>0){
                        $ledger->payment = $ledger->payment-$accounting->credit;
                        $ledger->update();
                        $ledger->payment = $ledger->payment + $accounting->debit;
                        $ledger->update();
                        }
                        $accounting->isreverse=1;
                        $accounting->save();
                        
                    }
                    $payment= \App\Payment::where('reference_id',$reference_id)->first();
                    $payment->isreverse=1;
                    $payment->update();
                } else{
                    $accountings = \App\Accounting::where('reference_id',$reference_id)->get();
                    foreach($accountings as $accounting){
                        $ledger=  \App\ledger::find($accounting->refid);
                        if(count($ledger)>0){
                        $ledger->payment = $ledger->payment+$accounting->credit;
                        $ledger->update();
                        $ledger->payment = $ledger->payment - $accounting->debit;
                        $ledger->update();
                        }
                        $accounting->isreverse=0;
                        $accounting->save();
                        
                    }
                        $payment= \App\Payment::where('reference_id',$reference_id)->first();
                        $payment->isreverse=0;
                        $payment->update(); 
                }
            
            
        }
        if($payment->idno != "999999"){
        return redirect(url('/viewledger',$payment->idno));
        } else {
         return redirect(url('/'));   
        }
    }
    
    function setreceipt(){
        if(Auth::user()->accesslevel==4){
            $currentreceipt = \App\CtrReferenceId::where('idno',Auth::user()->idno)->first()->receipt_no;
            return view('cashier.receiptno',compact('currentreceipt'));
        }
    }
    
    function setreceiptno(Request $request){
        if(Auth::user()->accesslevel==4){
            $currentreceipt = \App\CtrReferenceId::where('idno',Auth::user()->idno)->first();
            $currentreceipt->receipt_no = $request->newnumber;
            $currentreceipt->update();
            return redirect(url('/'));
        }
    }
}
