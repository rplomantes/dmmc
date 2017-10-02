<?php

namespace App\Http\Controllers\Guidance\Main;

use Illuminate\Support\Facades\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
Use Illuminate\Support\Facades\DB;
use App\User;
use App\StudentInfo;
use App\Status;
use Response;

class AjaxController extends Controller {

    //
    function getmainstudentlist() {
        if (Request::ajax()) {
            $search = Input::get("search");
            $lists = DB::select("SELECT * FROM `users` join statuses on users.idno = statuses.idno join student_infos on student_infos.idno = users.idno where (users.lastname like '%$search%' or users.firstname like '%$search%' or users.idno like '%$search%')order by users.lastname asc");
            return view('guidance.ajax.getmainstudentlist', compact('lists'));
        }
    }

    function getexamschedule() {
        if (Request::ajax()) {
            $search = Input::get("search");
            $scheds = DB::select("SELECT * FROM `entrance_exam_schedules` where entrance_exam_schedules.datetime like '%$search%' or entrance_exam_schedules.place like '%$search%' or entrance_exam_schedules.id like '%$search%' order by entrance_exam_schedules.is_remove asc");
            return view('guidance.ajax.getexamschedule', compact('scheds'));
        }
    }

    function changevalue($idno, $value) {
        if ($value == "Failed") {
            $stat = -1;
        }
        $result = \App\EntranceExam::where('idno', $idno)->first();
        $result->exam_result = $value;
        $result->save();

        $status = \App\Status::where('idno', $idno)->first();
        if ($status->academic_type=="College"){
            $status->status = 1;
        } else {
            $status->status = 2;
        }
        $status->save();

        return TRUE;
    }

    public function getacademicprogram($acad_type) {
        if (Request::ajax()) {

            if ($acad_type == 'College') {
                $datas = DB::select("select distinct academic_program from ctr_academic_programs where academic_type = '$acad_type'");
                return view('guidance.ajax.getacademicprogram-college', compact('datas'));
            } else if ($acad_type == 'Senior High School') {
                $datas = DB::select("select distinct track from ctr_academic_programs where academic_type = '$acad_type'");
                return view('guidance.ajax.getacademicprogram-senior', compact('datas'));
            } else {
                $datas = DB::select("select distinct program_code, program_name from ctr_academic_programs where academic_type = '$acad_type'");
                return;
            }
        }
    }

}
