<?php

namespace App\Http\Controllers\Registrar\Main;

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
            return view('registrar.ajax.getmainstudentlist', compact('lists'));
        }
    }
    
    function getmainstudentlistassessment() {
        if (Request::ajax()) {
            $search = Input::get("search");
            $lists = DB::select("SELECT * FROM `users` join statuses on users.idno = statuses.idno join student_infos on student_infos.idno = users.idno where (users.lastname like '%$search%' or users.firstname like '%$search%' or users.idno like '%$search%')order by users.lastname asc");
            return view('registrar.ajax.getmainstudentlistassessment', compact('lists'));
        }
    }
}