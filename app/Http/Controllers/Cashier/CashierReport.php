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
    
}
