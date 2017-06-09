<?php

namespace App\Http\Controllers\Main;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
class loginController extends Controller
{
    
    public function __construct()
	{
		$this->middleware('auth');
	}
    //
    function index(){
        if(Auth::user()->accesslevel == '1'){
           return view('dean.index'); 
        } else {
        return "hello";
        }
    }
    
}
