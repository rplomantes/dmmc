<?php

namespace App\Http\Controllers\Main;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class loginController extends Controller {

    public function __construct() {
        $this->middleware('auth');
    }

    //
    function index() {
        if (Auth::user()->accesslevel == '1') {
            return view('dean.index');
        } else if (Auth::user()->accesslevel == '2') {
            return view('guidance.index');
        } else if (Auth::user()->accesslevel == '3') {
            return view('registrar.index');
        } else if (Auth::user()->accesslevel == '4') {
            return view('cashier.index');
        } else {
            return ("hello");
        }
    }

}
