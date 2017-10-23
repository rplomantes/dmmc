<?php

namespace App\Http\Controllers\Cashier\Ajax;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
Use Illuminate\Support\Facades\DB;
use Request;


class CashierController extends Controller
{
   
function getstudentlist(){
    if(Request::ajax()){
        $search = Input::get('search');
        return view("cashier.ajax.studentlist",compact('search'));
        //return "<h1>Hello</h1>";
    }
}    
//
function getsubsidiary(){
    if(Request::ajax()){
        $value = Input::get('value');
        $i=Input::get('i');
        $otherpayments = \App\OtherPayment::where('accounting_name',$value)->get();
        return view("cashier.ajax.getsubsidiary",compact('otherpayments','i'));
    }
}
 function searchor(){
     if(Request::ajax()){
         $search = Input::get('search');
         return view('cashier.ajax.searchor',compact('search'));
     }
 }
}
