<?php

namespace App\Http\Controllers\Registrar\Grades;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Auth;

class AddingDroppingController extends Controller
{
    //
    public function __construct() {
        $this->middleware('auth');
    }
    function index(){
        if (Auth::user()->accesslevel == "3") {
            return view('registrar.grades.adding_dropping');
        }
    }
    function viewprofile($idno){
        if (Auth::user()->accesslevel == "3") {
            return view('registrar.grades.dropping_profile', compact('idno'));
        }
    }
}
