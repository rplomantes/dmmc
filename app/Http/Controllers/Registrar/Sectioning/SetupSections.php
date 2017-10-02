<?php

namespace App\Http\Controllers\Registrar\Sectioning;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class SetupSections extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    function shsindex(){
        if (Auth::user()->accesslevel == "3") {
        return view('registrar.sectioning.shs');
        }
    }
}
