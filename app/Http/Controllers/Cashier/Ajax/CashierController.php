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
}
