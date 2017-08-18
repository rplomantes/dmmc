<?php

namespace App\Http\Controllers\Dean\Ajax;

//use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
Use Illuminate\Support\Facades\DB;
use Request;

class GetStudentListController extends Controller
{
    function index(){
        if(Request::ajax()){
            $search = Input::get("search");
            $academic_program = Input::get("academic_program");
            $lists = DB::Select("Select users.idno, users.lastname, users.firstname, users.middlename, "
                    . "statuses.status, statuses.program_code from users,statuses where users.idno = statuses.idno and "
                    . "statuses.academic_program = '$academic_program' and (users.idno like '$search' OR "
                    . "users.lastname like '$search%' or users.firstname like '$search%')");
            return view('dean.ajax.getdeanstudentlist',compact('lists'));
           
        }
    }
    
    function getmainstudentlistassessmentcollege() {
        if (Request::ajax()) {
            
            $academic_program = \Illuminate\Support\Facades\Auth::user()->academic_program;
            $search = Input::get("search");
            $lists = DB::select("SELECT * FROM `users` join statuses on users.idno = statuses.idno join student_infos on student_infos.idno = users.idno where (users.lastname like '%$search%' or users.firstname like '%$search%' or users.idno like '%$search%') and statuses.academic_type='College' and statuses.academic_program = '$academic_program' order by users.lastname asc");
            return view('dean.ajax.getmainstudentlistassessment', compact('lists'));
        }
    }
    
    function getmainstudentlistassessmentshs() {
        if (Request::ajax()) {
            $search = Input::get("search");
            $lists = DB::select("SELECT * FROM `users` join statuses on users.idno = statuses.idno join student_infos on student_infos.idno = users.idno where (users.lastname like '%$search%' or users.firstname like '%$search%' or users.idno like '%$search%') and statuses.academic_type='Senior High School' and statuses.academic_program = '$academic_program' order by users.lastname asc");
            return view('dean.ajax.getmainstudentlistassessment', compact('lists'));
        }
    }
    
}
