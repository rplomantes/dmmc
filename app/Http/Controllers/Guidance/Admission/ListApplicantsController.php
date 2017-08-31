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
        return view('guidance.admission.listApplicants');
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

        if ($list->academic_type == 'College') {
            $programs = DB::Select("Select distinct program_code, program_name from ctr_academic_programs  where academic_type='College' or academic_type='TESDA'");
        } else if ($list->academic_type == 'TESDA') {
            $programs = DB::Select("Select distinct program_code, program_name from ctr_academic_programs  where academic_type='TESDA'");
        } else {
            $programs = DB::Select("Select distinct track from ctr_academic_programs  where academic_type='Senior High School'");
        }
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

        $idno = $request->idno;

        $user = User::where('idno', $idno)->first();
        $user->firstname = $request->firstname;
        $user->middlename = $request->middlename;
        $user->lastname = $request->lastname;
        $user->extensionname = $request->extensionname;
        $user->email = $request->email;
        $user->academic_program = "";

        $user->save();

        if ($request->input('name_of_school') == null) {
            $is_transferee = 0;
        } else {
            $is_transferee = 1;
        }

        $student_info = StudentInfo::where('idno', $idno)->first();
        $course = $student_info->course = $request->course;
        $student_info->course2 = $request->course2;
        $student_info->birthdate = $request->birthdate;
        $student_info->civil_status = $request->civil_status;
        $student_info->gender = $request->gender;
        $student_info->address = $request->address;
        $student_info->contact_no = $request->contact_no;
        $student_info->last_school = $request->last_school_attended;
        $student_info->year_graduated = $request->year_graduated;
        $student_info->birthdate = $request->birthdate;
        $student_info->civil_status = $request->civil_status;
        $student_info->gen_ave = $request->gen_ave;
        $student_info->honor = $request->honors_received;
        $student_info->is_transferee = $is_transferee;
        $student_info->school = $request->name_of_school;
        $student_info->prev_course = $request->prev_course;
        $student_info->status_upon_admission = $request->status_upon_admission;

        $student_info->save();

        $status = \App\Status::where('idno', $idno)->first();
        $status->academic_program = $this->getAcademicProgram($course);
        $status->academic_type = $this->getAcademicType($course);
        $status->program_code =  $this->getProgramCode($course);
        $status->program_name =  $this->getProgramCode($course);
        $status->program_name =  $this->getProgramName($course);

        $status->save();

        if ($request->input('is_exam') == 1) {

            $EntranceExam = EntranceExam::where('idno', $idno)->first();

            $EntranceExam->course_intended = $request->course;
            $EntranceExam->second_choice = $request->course2;
            $EntranceExam->exam_schedule = $request->exam_date;

            $EntranceExam->save();
        } else {
            
        }

        return redirect("guidance/viewinfo/$idno");
    }

    function getAcademicProgram($course) {
        if ($course == 'ABM' or $course == 'STEM' or $course == 'GAS' or $course == 'HUMMS') {
            $academic_program = \App\CtrAcademicProgram::where('track', $course)->first();
            return $academic_program->academic_program;
        } else {
            $academic_program = \App\CtrAcademicProgram::where('program_code', $course)->first();
            return $academic_program->academic_program;
        }
    }

    function getAcademicType($course) {
        if ($course == 'ABM' or $course == 'STEM' or $course == 'GAS' or $course == 'HUMMS') {
            $academic_program = \App\CtrAcademicProgram::where('track', $course)->first();
            return $academic_program->academic_type;
        } else {
            $academic_program = \App\CtrAcademicProgram::where('program_code', $course)->first();
            return $academic_program->academic_type;
        }
    }
    
    function getProgramCode($course) {
        if ($course == 'ABM' or $course == 'STEM' or $course == 'GAS' or $course == 'HUMMS') {
            $academic_program = \App\CtrAcademicProgram::where('track', $course)->first();
            return $academic_program->program_code;
        } else {
            $academic_program = \App\CtrAcademicProgram::where('program_code', $course)->first();
            return $academic_program->program_code;
        }
    }
    
    function getProgramName($course) {
        if ($course == 'ABM' or $course == 'STEM' or $course == 'GAS' or $course == 'HUMMS') {
            $academic_program = \App\CtrAcademicProgram::where('track', $course)->first();
            return $academic_program->program_name;
        } else {
            $academic_program = \App\CtrAcademicProgram::where('program_code', $course)->first();
            return $academic_program->program_name;
        }
    }

}
