<?php

namespace App\Http\Controllers\Guidance\Admission;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
Use Illuminate\Support\Facades\DB;
use App\EntranceExam;
use PDF;

function __construct() {
    
}

class ExamScheduleController extends Controller {

//
    public function __construct() {
        $this->middleware('auth');
    }

    function schedule($idno) {
        if (Auth::user()->accesslevel == "1") {
            $dates = DB::table('entrance_exam_schedules')
                    ->where('is_remove', '=', 0)
                    ->orderBy('datetime', 'asc')
                    ->get();

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
            return view('guidance.admission.schedApplicant', compact('list', 'dates', 'value', 'exam'));
        }
    }

    function schedApplicant(Request $request) {
        if (Auth::user()->accesslevel == "1") {
            $this->validate($request, [
                'exam_date' => 'required'
            ]);
            return $this->createSchedapplicant($request);
        }
    }

    function createSchedapplicant($request) {

        $EntranceExam = new EntranceExam;

        $idno = $EntranceExam->idno = $request->idno;
        $EntranceExam->course_intended = $request->course;
        $EntranceExam->second_choice = $request->course2;
        $EntranceExam->exam_result = "";
        $EntranceExam->exam_description = "";
        $EntranceExam->exam_schedule = $request->exam_date;
        $EntranceExam->date_issued = date('Y-m-d');
        $EntranceExam->issued_by = Auth::user()->idno;
        $EntranceExam->graded_by = "";
        $EntranceExam->remarks = "";

        $EntranceExam->save();

        return redirect("guidance/viewinfo/$idno");

        //return app('App\Http\Controllers\Guidance\Admission\ListApplicantsController')->viewinfo($idno);
    }

    function printAdmission($idno) {
        if (Auth::user()->accesslevel == "1") {

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

            $pdf = PDF::loadView('guidance.print.admissionSlip', compact('list', 'exam'));
            return $pdf->stream("admission_slip_$idno.pdf");
        }
    }

}
