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
            $lists = DB::select("SELECT * FROM `users` join statuses on users.idno = statuses.idno join student_infos on student_infos.idno = users.idno where statuses.status = 0  and (users.lastname like '%$search%' or users.firstname like '%$search%' or users.idno like '%$search')order by users.lastname asc");
            return view('guidance.ajax.getmainstudentlist',compact('lists'));
        }
    }
    function getexamschedule() {
        if (Request::ajax()) {
            $search = Input::get("search");
            $scheds = DB::select("SELECT * FROM `entrance_exam_schedules` where entrance_exam_schedules.datetime like '%$search%' or entrance_exam_schedules.place like '%$search%' or entrance_exam_schedules.id like '%$search%' order by entrance_exam_schedules.is_remove asc");
            return view('guidance.ajax.getexamschedule',compact('scheds'));
        }
    }
}
