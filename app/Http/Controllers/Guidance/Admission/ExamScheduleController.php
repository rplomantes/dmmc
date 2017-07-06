<?php

namespace App\Http\Controllers\Guidance\Admission;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
Use Illuminate\Support\Facades\DB;
use App\User;
use App\StudentInfo;
use App\EntranceExam;
use App\EntranceExamSchedule;

function __construct() {
    
}

class ExamScheduleController extends Controller {

//
    function schedApplicant(Request $request) {
        $this->validate($request, [
            'lastname' => 'required',
            'firstname' => 'required',
            'email' => 'required',
            'address' => 'required',
            'contact_no' => 'required',
            'exam_date' => 'required'
        ]);

        $idno = $request->input('idno');
        $lists = DB::select("select * from entrance_exams where idno='$idno'");

        if (count($lists) > 0) {
            return app('App\Http\Controllers\Guidance\Admission\ListApplicantsController')->viewinfo($idno);
        } else {
            return $this->createSchedapplicant($request);
        }
    }

    function createSchedapplicant($request) {

        $EntranceExam = new EntranceExam;

        $idno=$EntranceExam->idno = $request->input('idno');
        $EntranceExam->course_intended = $request->input('course');
        $EntranceExam->second_choice = $request->input('course2');
        $EntranceExam->exam_result = "";
        $EntranceExam->exam_description = "";
        $schedule = $EntranceExam->exam_schedule = $request->input('exam_date');
        $EntranceExam->date_issued = date('Y-m-d');
        $EntranceExam->issued_by = "";
        $EntranceExam->graded_by = "";
        $EntranceExam->remarks = "";

        $EntranceExam->save();

        
        $user = User::find($idno);

        $user->firstname = $request->input('firstname');
        $user->middlename = $request->input('middlename');
        $user->lastname = $request->input('lastname');
        $user->extensionname = $request->input('extensionname');
        $user->email = $request->input('email');

        $user->save();
        
        $student_info = StudentInfo::find($idno);
        $student_info->address = $request->input('address');
        $student_info->contact_no = $request->input('contact_no');
        $student_info->last_school = $request->input('last_school_attended');
        $student_info->year_graduated = $request->input('year_graduated');
        $student_info->birthdate = $request->input('birthdate');
        $student_info->civil_status = $request->input('civil_status');
        $student_info->gen_ave = $request->input('gen_ave');
        $student_info->honor = $request->input('honors_received');
        $student_info->is_transferee = 0;
        $student_info->school = $request->input('name_of_school');
        $student_info->prev_course = $request->input('prev_course');
        
        $student_info->save();

        return ("Exam Schedules on $schedule" );
    }

}
