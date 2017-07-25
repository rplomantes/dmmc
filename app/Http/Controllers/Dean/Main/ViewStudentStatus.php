<?php

namespace App\Http\Controllers\Dean\Main;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ViewStudentStatus extends Controller
{
    function index($idno){
        $student_status = \App\Status::where('idno',$idno)->first();
        if($student_status->academic_program == Auth::user()->academic_program AND Auth::user()->accesslevel == '2'){
            $status=$student_status->status;
            if($status <= 1 AND $status >=0){
                return view('dean.main.viewstudentstatus',compact('idno','status'));
            }
            elseif($status == 2){
                return view('dean.main.studentstatus2',compact('idno','student_status'));
            }
            elseif($status==-1){
                return view('dean.failed',compact('idno','status'));
            }
        } else {
            return view('dean.unauthorized');
        }
    }
//
}
