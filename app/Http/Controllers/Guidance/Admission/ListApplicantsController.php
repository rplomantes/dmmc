<?php

namespace App\Http\Controllers\Guidance\Admission;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
Use Illuminate\Support\Facades\DB;
use App\User;
use App\StudentInfo;
use App\EntranceExam;

class listApplicantsController extends Controller {

    //
    function listApplicants() {
        $lists = DB::Select("SELECT * FROM `users` join statuses on users.idno = statuses.idno join student_infos on student_infos.idno = users.idno where statuses.status = 0 or statuses.status = 1 or statuses.status = -1 order by users.lastname asc");
        return view('guidance.admission.listApplicants', compact('lists'));
    }

    function viewinfo($idno) {

        $list = DB::table('users')
                ->join('statuses', 'users.idno', '=', 'statuses.idno')
                ->join('student_infos', 'users.idno', '=', 'student_infos.idno')
                ->where('users.idno', '=', $idno)
                ->orderBy('users.lastname', 'asc')
                ->first();

        $exam = DB::table('entrance_exams')
                ->join('entrance_exam_schedules', 'entrance_exams.exam_schedule', '=', 'entrance_exam_schedules.id')
                ->where('idno', '=', $idno)
                ->first();

        if (count($exam) == 0) {
            $value = 0;
        } else {
            $value = 1;
        }
        return view('guidance.admission.studentinfo', compact('list', 'value', 'exam'));
    }

    function viewmodifyinfo($idno) {

        $list = DB::table('users')
                ->join('statuses', 'users.idno', '=', 'statuses.idno')
                ->join('student_infos', 'users.idno', '=', 'student_infos.idno')
                ->where('users.idno', '=', $idno)
                ->orderBy('users.lastname', 'asc')
                ->first();

        $exam = DB::table('entrance_exams')
                ->join('entrance_exam_schedules', 'entrance_exams.exam_schedule', '=', 'entrance_exam_schedules.id')
                ->where('idno', '=', $idno)
                ->first();

        if (count($exam) == 0) {
            $value = 0;
        } else {
            $value = 1;
        }

        $dates = DB::table('entrance_exam_schedules')
                ->where('is_remove', '=', 0)
                ->orderBy('datetime', 'asc')
                ->get();

        $programs = DB::Select("Select distinct program_code, program_name from ctr_academic_programs");

        return view('guidance.admission.viewmodifyinfo', compact('list', 'exam', 'programs', 'dates', 'value'));
    }

    function modifyinfo(Request $request) {

        $this->validate($request, [
            'lastname' => 'required',
            'firstname' => 'required',
            'course' => 'required',
            'email' => 'required',
            'birthdate' => 'required',
            'address' => 'required',
            'contact_no' => 'required'
        ]);

        return $this->updateinfo($request);
    }

    function updateinfo($request) {

        $idno = $request->input('idno');

        $user = User::where('idno', $idno)->first();
        $user->firstname = $request->input('firstname');
        $user->middlename = $request->input('middlename');
        $user->lastname = $request->input('lastname');
        $user->extensionname = $request->input('extensionname');
        $user->email = $request->input('email');
        $user->academic_program = "";

        $user->save();

        if ($request->input('name_of_school') == null) {
            $is_transferee = 0;
        } else {
            $is_transferee = 1;
        }

        $student_info = StudentInfo::where('idno', $idno)->first();
        $course=$student_info->course = $request->input('course');
        $student_info->course2 = $request->input('course2');
        $student_info->birthdate = $request->input('birthdate');
        $student_info->civil_status = $request->input('civil_status');
        $student_info->address = $request->input('address');
        $student_info->contact_no = $request->input('contact_no');
        $student_info->last_school = $request->input('last_school_attended');
        $student_info->year_graduated = $request->input('year_graduated');
        $student_info->birthdate = $request->input('birthdate');
        $student_info->civil_status = $request->input('civil_status');
        $student_info->gen_ave = $request->input('gen_ave');
        $student_info->honor = $request->input('honors_received');
        $student_info->is_transferee = $is_transferee;
        $student_info->school = $request->input('name_of_school');
        $student_info->prev_course = $request->input('prev_course');
        $student_info->status_upon_admission = $request->input('status_upon_admission');

        $student_info->save();
        
        $status = \App\Status::where('idno', $idno)->first();
        $status->academic_program = $this->getAcademicProgram($course);
        $status->academic_type = $this->getAcademicType($course);

        $status->save();

        if ($request->input('is_exam') == 1) {

            $EntranceExam = EntranceExam::where('idno', $idno)->first();

            $EntranceExam->course_intended = $request->input('course');
            $EntranceExam->second_choice = $request->input('course2');
            $EntranceExam->exam_schedule = $request->input('exam_date');

            $EntranceExam->save();
        } else {
            
        }

        return redirect("guidance/viewinfo/$idno");
    }

    function getAcademicProgram($course) {
        $academic_program = \App\CtrAcademicProgram::where('program_code', $course)->first();
        return $academic_program->academic_program;
    }
    
    function getAcademicType($course){
        $academic_type = \App\CtrAcademicProgram::where('program_code',$course)->first();
        return $academic_type->academic_type;
    }

}
