<?php

namespace App\Http\Controllers\Registrar\Main;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class RegisterSubjects extends Controller {

    function index(Request $request) {
        $idno = $request->idno;
        $users = \App\User::where('idno', $request->idno)->first();
        $student_status = \App\Status::where('idno', $request->idno)->first();
        if ($student_status->academic_type != 'College') {
            $registered_subject = \App\GradeShs::where('idno', $request->idno)->where('school_year', $student_status->school_year)->where('period', $student_status->period)->get();
        } else {
            $registered_subject = \App\GradeCollege::where('idno', $request->idno)->where('school_year', $student_status->school_year)->where('period', $student_status->period)->get();
        }
        if (count($registered_subject) > 0) {
            $student_status->status = "2";
            $student_status->save();
return redirect("/registrar/viewinfo/$idno");            
//return view('registrar.main.studentstatus2', compact('idno', 'student_status'));
            ;
        } else {
            return "No Subject To Be Processed!!!";
        }
    }

    //
}
