<?php

namespace App\Http\Controllers\Registrar\Main;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;


class SelectSubject extends Controller
{
    function college(Request $request){
        if(Auth::user()->accesslevel == '3'){
                $academic_program = \App\CtrAcademicProgram::where('program_code',$request->program_code)->first();
                $schoolyear=  \App\CtrSchoolYear::where('academic_type',$academic_program->academic_type)->first();
                $updatestatus = \App\Status::where('idno',$request->idno)->first();
                $updatestatus->program_code=$academic_program->program_code;
                $updatestatus->program_name=$academic_program->program_name;
                $updatestatus->school_year=$schoolyear->school_year;
                $updatestatus->period=$schoolyear->period;
                $updatestatus->level=$request->level;
                $updatestatus->save();
                
                $updatestudentinfo = \App\StudentInfo::where('idno', $request->idno)->first();
                $updatestudentinfo->curriculum_year=$request->curriculum_year;
                $updatestudentinfo->save();
                
                return view('registrar.main.selectsubjectcollege',compact('request'));
            
        }else{
           return view('registrar.unauthorized'); 
        }
    }    
    //
    function shs(Request $request){
        if(Auth::user()->accesslevel == '3'){
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
                
                $updatestudentinfo = \App\StudentInfo::where('idno', $request->idno)->first();
                $updatestudentinfo->curriculum_year=$request->curriculum_year;
                $updatestudentinfo->save();
                return view('registrar.main.selectsubjectshs',compact('request'));
            
            
        }else{
          return view('registrar.unauthorized');   
        }
    }
    
    
}
