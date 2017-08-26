<?php

namespace App\Http\Controllers\Cashier;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
Use Illuminate\Support\Facades\DB;


class ViewLedger extends Controller
{
    //
    function index($idno){
       return view('cashier.viewledger',compact('idno'));
    }
}
