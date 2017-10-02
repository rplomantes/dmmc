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
    
    function assessmentcollege(){
        if(Request::ajax()){
            $search = Input::get("search");
            $academic_program = Input::get("academic_program");
            $lists = DB::Select("Select users.idno, users.lastname, users.firstname, users.middlename, "
                    . "statuses.status, statuses.program_code from users,statuses where users.idno = statuses.idno and "
                    . "statuses.academic_program = '$academic_program' and "
                    . "(statuses.academic_type = 'College' or statuses.academic_type = 'TESDA')"
                    . "and (users.idno like '$search' OR "
                    . "users.lastname like '$search%' or users.firstname like '$search%')");
            return view('dean.ajax.assessmentgetdeanstudentlist',compact('lists'));
           
        }
    }
    
    function assessmentshs(){
        if(Request::ajax()){
            $search = Input::get("search");
            $academic_program = Input::get("academic_program");
            $lists = DB::Select("Select users.idno, users.lastname, users.firstname, users.middlename, "
                    . "statuses.status, statuses.program_code from users,statuses where users.idno = statuses.idno and "
                    . "statuses.academic_program = '$academic_program' and "
                    . "statuses.academic_type = 'Senior High School'"
                    . "and (users.idno like '$search' OR "
                    . "users.lastname like '$search%' or users.firstname like '$search%')");
            return view('dean.ajax.assessmentgetdeanstudentlist',compact('lists'));
           
        }
    }
    
}
