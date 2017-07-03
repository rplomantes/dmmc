<?php

namespace App\Http\Controllers\Guidance;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
Use Illuminate\Support\Facades\DB;

class listApplicantsController extends Controller
{
    //
    function listApplicants(){
        $lists = DB::Select("SELECT * FROM `users` join statuses join student_infos on student_infos.idno = users.idno  where users.idno = statuses.idno and statuses.status = 0 order by users.lastname asc");
        return view('guidance.listApplicants',  compact('lists'));
    }
}
