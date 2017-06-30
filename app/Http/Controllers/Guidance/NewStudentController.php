<?php

namespace App\Http\Controllers\Guidance;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
Use Illuminate\Support\Facades\DB;

class NewStudentController extends Controller
{
    //
    function newstudent(){
        $programs = DB::Select("Select distinct program_code from ctr_academic_programs");
        return view('guidance.newstudent',  compact('programs'));
    }
    
    function addapplicant(Request $request){
        $this->validate($request, [
            'lastname'=>'required',
            'firstname'=>'required',
            'course'=>'required',
        ]);
        
        return $this->createapplicant($request);
    }
    
    function createapplicant($request){
        return $request;
    }

}