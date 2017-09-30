<?php

namespace App\Http\Controllers\Cashier;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
Use Illuminate\Support\Facades\DB;


class ViewLedger extends Controller
{
    
      public function __construct() {
        $this->middleware('auth');
    }
    
    //
    function index($idno){
        $student = \App\User::where('idno',$idno)->first();
        if(count($student)>0){
        return view('cashier.viewledger',compact('idno','student'));
        } else{
        return redirect('/');    
        }
    }
    
    function viewreceipt($reference_id){
        if(Auth::user()->accesslevel==4)
        return view('cashier.viewreceipt',compact('reference_id'));
        }
    function searchor(){
        if(Auth::user()->accesslevel==4){
        return view('cashier.searchor');    
        }
    }    
    }
    
   
