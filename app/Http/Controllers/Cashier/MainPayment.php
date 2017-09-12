<?php

namespace App\Http\Controllers\Cashier;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
Use Illuminate\Support\Facades\DB;
//Use Carbon;

class MainPayment extends Controller
{
    
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
            $idno = $request->idno;
            $student=  \App\User::where('idno',$idno)->first();
            $receiptno = \App\CtrReferenceId::where('idno',Auth::user()->idno)->first()->receipt_no;
            $referenceid = uniqid();
            $cashamount=0;
             $remarks = $request->remarks;
             if(isset($request->previousaccount)){
                if($request->previousaccount > 0){
                    $previousaccounts = DB::Select("select * from ledgers where category_switch >= 10 and "
                        . "amount-discount-debit_memo-payment-esc > 0 and idno = '$idno'");
                    //$previousaccounts = \App\ledger::where('idno',$idno)->where("category_switch",">=","10")->where("amount-debit_memo-discount-payment-esc",">","0")->get();
                    $this->process_current_previous_acct($idno, $request->previousaccount, $previousaccounts,$student,$receiptno,$referenceid);
                    $cashamount=$cashamount+$request->previousaccount;    
                } 
            }
            
             if(isset($request->mainaccount)){
                if($request->mainaccount > 0){
                   $mainaccounts = DB::Select("select * from ledgers where category_switch <= 5 and "
                        . "amount-discount-debit_memo-payment-esc > 0 and idno = '$idno'");
                   //$mainaccounts = \App\ledger::where('idno',$idno)->where("category_switch","<=","5")->where("amount-debit_memo-discount-payment-esc",">","0")->get();
                   $this->process_current_previous_acct($idno,$request->mainaccount,$mainaccounts,$student,$receiptno,$referenceid);    
                   $cashamount=$cashamount+$request->mainaccount;
                   
                }
             } 
             
             if(isset($request->otheracct)){
                 $otheraccount = $request->otheracct;
                 foreach($otheraccount as $key=>$value){
                     $otheraccounts = \App\ledger::where('id',$key)->get();
                     $this->process_current_previous_acct($idno,$value,$otheraccounts,$student,$receiptno,$referenceid);
                     $cashamount=$cashamount+$value;
                 }
             }
             
             $this->add_debit_cash_entry($idno,$cashamount,$student,$receiptno,$referenceid);
             $this->add_payment_details($request,$receiptno,$student,$referenceid,$idno);
             $receipt = \App\CtrReferenceId::where('idno',Auth::user()->idno)->first();
             $receipt->receipt_no = $receipt->receipt_no + 1;
             $receipt->update();
             $status = \App\Status::where('idno',$idno)->first();
             if($status->status==3){
                $status->status=4;
                $status->update();
             }
             
             return redirect(url('/viewreceipt',$referenceid));
             
        }else{
            return "Unauthorized to access this module. Please see Administrator!!!";
        }
            
    }
    function process_current_previous_acct($idno,$acct_amount,$accounts,$student,$receiptno,$referenceid){
            
            
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
                        $acctentry->reference_id=$referenceid;
                        $acctentry->receipt_no=$receiptno;
                        $acctentry->idno=$idno;
                        $acctentry->paid_by=$student->lastname . "' " . $student->firstname;
                        $acctentry->category = $account->category;
                        $acctentry->description = $account->description;
                        $acctentry->receipt_details = $account->receipt_details;
                        $acctentry->accounting_code = $account->accounting_code;
                        $acctentry->category_switch=$account->category_switch;
                        $acctentry->entry_type="1";
                        $acctentry->credit = $amount-$debit_memo-$payment-$esc;
                        $acctentry->posted_by=Auth::user()->idno;
                        $acctentry->save();
                        
                        if($discount > 0){
                            $discounts = \App\CtrDiscount::where("discount_code",$account->accounting_code)->first();
                            $debit_accounting_code = $discounts->accounting_code;
                            $debit_description = $discounts->discount_description;
                            $acctentry = new \App\Accounting;
                            $acctentry->transaction_date = \Carbon\Carbon::now();
                            $acctentry->refid=$refid;
                            $acctentry->reference_id=$referenceid;
                            $acctentry->receipt_no=$receiptno;
                            $acctentry->idno=$idno;
                            $acctentry->paid_by=$student->lastname . "' " . $student->firstname;
                            $acctentry->category = "Discount";
                            $acctentry->description = $debit_description;
                            $acctentry->receipt_details = "Discount";
                            $acctentry->accounting_code = $debit_accounting_code;
                            $acctentry->category_switch=$account->category_switch;
                            $acctentry->entry_type="1";
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
                        $acctentry->reference_id=$referenceid;
                        $acctentry->receipt_no=$receiptno;
                        $acctentry->idno=$idno;
                        $acctentry->paid_by=$student->lastname . "' " . $student->firstname;
                        $acctentry->category = $account->category;
                        $acctentry->description = $account->description;
                        $acctentry->receipt_details = $account->receipt_details;
                        $acctentry->accounting_code = $account->accounting_code;
                        $acctentry->category_switch=$account->category_switch;
                        $acctentry->entry_type="1";
                        $acctentry->credit = $acct_amount;
                        $acctentry->posted_by=Auth::user()->idno;
                        $acctentry->save();
                        //End Accountiing Entry
                        $acct_amount=0;
                    }
                }
                
                
    }
    
    function add_debit_cash_entry($idno,$cashamount,$student,$receiptno,$referenceid){
        $acctentry = new \App\Accounting;
        $acctentry->transaction_date = \Carbon\Carbon::now();
        $acctentry->reference_id=$referenceid;
        $acctentry->receipt_no=$receiptno;
        $acctentry->idno=$idno;
        $acctentry->paid_by=$student->lastname . "' " . $student->firstname;
        $acctentry->category = "Cash On Hand";
        $acctentry->description = "Cash On Hand";
        $acctentry->receipt_details = "Total Amount";
        $acctentry->accounting_code = "100001";
        $acctentry->category_switch="";
        $acctentry->entry_type="1";
        $acctentry->debit = $cashamount;
        $acctentry->posted_by=Auth::user()->idno;
        $acctentry->save();
        
    }
    
    function add_payment_details($request,$receiptno,$student,$referenceid,$idno){
       
        $addpayment = new \App\Payment;
        $addpayment->transaction_date=  \Carbon\Carbon::now();
        $addpayment->receipt_no = $receiptno;
        $addpayment->reference_id=$referenceid;
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
        return redirect(url('/viewledger',$payment->idno));
    }
}
