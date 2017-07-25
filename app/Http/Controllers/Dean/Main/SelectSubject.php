<?php

namespace App\Http\Controllers\Dean\Main;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;


class SelectSubject extends Controller
{
    function college(Request $request){
        if(Auth::user()->accesslevel == '2'){
            if(\App\Status::where('idno',$request->idno)->first()->academic_program == Auth::user()->academic_program){
                $academic_program = \App\CtrAcademicProgram::where('program_code',$request->program_code)->first();
                $schoolyear=  \App\CtrSchoolYear::where('academic_type',$academic_program->academic_type)->first();
                $updatestatus = \App\Status::where('idno',$request->idno)->first();
                $updatestatus->program_code=$academic_program->program_code;
                $updatestatus->program_name=$academic_program->program_name;
                $updatestatus->school_year=$schoolyear->school_year;
                $updatestatus->period=$schoolyear->period;
                $updatestatus->level=$request->level;
                $updatestatus->save();
                return view('dean.main.selectsubjectcollege',compact('request'));
            } else {
                return view('dean.unauthorized');
            }
        }else{
           return view('dean.unauthorized'); 
        }
    }    
    //
    function shs(Request $request){
        if(Auth::user()->accesslevel == '2'){
            if(\App\Status::where('idno',$request->idno)->first()->academic_program == Auth::user()->academic_program){
                $academic_program = \App\CtrAcademicProgram::where('track',$request->track)->first();
                $schoolyear=  \App\CtrSchoolYear::where('academic_type',$academic_program->academic_type)->first();
                $updatestatus = \App\Status::where('idno',$request->idno)->first();
                $updatestatus->program_code=$academic_program->program_code;
                $updatestatus->program_name=$academic_program->program_name;
                $updatestatus->school_year=$schoolyear->school_year;
                $updatestatus->period=$schoolyear->period;
                $updatestatus->level=$request->level;
                $updatestatus->track=$request->track;
                $updatestatus->save();
                return view('dean.main.selectsubjectshs',compact('request'));
            }else{
                return view('dean.unauthorized');
            }
            
        }else{
          return view('dean.unauthorized');   
        }
    }
    
    
}
