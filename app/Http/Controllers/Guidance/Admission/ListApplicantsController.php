<?php

namespace App\Http\Controllers\Guidance\Admission;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
Use Illuminate\Support\Facades\DB;

class listApplicantsController extends Controller
{
    //
    function listApplicants(){
        $lists = DB::Select("SELECT * FROM `users` join statuses on users.idno = statuses.idno join student_infos on student_infos.idno = users.idno where statuses.status = 0 order by users.lastname asc");
        return view('guidance.admission.listApplicants',  compact('lists'));
    }
    function viewinfo($idno){
        
        
        $exams = DB::select("select * from entrance_exams where idno='$idno'");

        if (count($exams) > 0) {
            $value=0;
        } else {
            $value=1;
        }
        
        $lists = DB::table('users')
                ->join('statuses','users.idno', '=', 'statuses.idno')
                ->join('student_infos','users.idno', '=', 'student_infos.idno')
                ->where('users.idno','=',$idno)
                ->where('statuses.status','=',0)
                ->orderBy('users.lastname','asc')
                ->get();
        
        $dates = DB::table('entrance_exam_schedules')
                ->where('is_remove','=',0)
                ->orderBy('datetime','asc')
                ->get();
        
        return view('guidance.admission.studentinfo', compact('lists', 'dates', 'value', 'exams'));
    }
}
