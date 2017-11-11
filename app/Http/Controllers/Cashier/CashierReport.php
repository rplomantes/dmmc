<?php

namespace App\Http\Controllers\Cashier;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
Use Illuminate\Support\Facades\DB;

class CashierReport extends Controller
{
      public function __construct() {
        $this->middleware('auth');
    }
    function collectionreport($trandate){
        if(Auth::user()->accesslevel=="4"){
            $payments = \App\Payment::where('posted_by',Auth::user()->idno)->where('transaction_date',$trandate)->get();
            return view('cashier.collectionreport',compact('payments','trandate'));
        }
    }
    
    function printcollection($transaction_date){
        if(Auth::user()->accesslevel=="4"){
        $payments = \App\Payment::where('posted_by',Auth::user()->idno)->where('transaction_date',$transaction_date)->get();     
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadView("cashier.printcollection",compact('payments','transaction_date'));
        return $pdf->stream();
        }
    }
    
    function listofchecks($trandate){
        if(Auth::user()->accesslevel=="4"){
            $payments = \App\Payment::where('posted_by',Auth::user()->idno)->where('bank_name', '!=' ,NULL)->where('transaction_date',$trandate)->get();
            return view('cashier.listofchecks',compact('payments','trandate'));
        }
    }
    
    function printchecks($transaction_date){
        if(Auth::user()->accesslevel=="4"){
        $payments = \App\Payment::where('posted_by',Auth::user()->idno)->where('bank_name', '!=' ,NULL)->where('transaction_date',$transaction_date)->get();     
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadView("cashier.printcheck",compact('payments','transaction_date'));
        return $pdf->stream();
        }
    }
    
}
