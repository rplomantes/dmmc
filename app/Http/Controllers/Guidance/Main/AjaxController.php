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
            $idno = Input::get("search");
            $data = DB::select("SELECT * FROM `users` join statuses on users.idno = statuses.idno join student_infos on student_infos.idno = users.idno where users.idno = '$idno' and statuses.status = 0 order by users.lastname asc");
            return Response::json($data);
        }
    }

    public function getMajor($course) {
        $data = DB::select("SELECT DISTINCT major FROM ctr_academic_programs WHERE program_code = '$course'");
        return Response::json($data);
    }

    public function getMajor2($course2) {
        $data = DB::select("SELECT DISTINCT major FROM ctr_academic_programs WHERE program_code = '$course2'");
        return Response::json($data);
    }

}
