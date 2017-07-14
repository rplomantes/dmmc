<?php

namespace App\Http\Controllers\Guidance\Admission;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

class ExamResultController extends Controller
{    
    function viewlist($id){
        $lists = DB::Select("SELECT * FROM entrance_exams JOIN entrance_exam_schedules ON entrance_exam_schedules.id = entrance_exams.exam_schedule JOIN users ON users.idno = entrance_exams.idno JOIN student_infos ON student_infos.idno = users.idno WHERE entrance_exam_schedules.id = $id order by users.lastname");
        return view('guidance.admission.listsBatchResult', compact('lists'));
    }
}
