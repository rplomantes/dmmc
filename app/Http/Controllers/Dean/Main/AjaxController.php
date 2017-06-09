<?php

namespace App\Http\Controllers\Dean\Main;

use Illuminate\Support\Facades\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
class AjaxController extends Controller
{
    //
    function getmainstudentlist(){
        if(Request::ajax()){
            return Input::get("search");
        }   
            
    }
}
