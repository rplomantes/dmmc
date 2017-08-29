<?php

namespace App\Http\Controllers\Guidance\Admission;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use PDF;

class reportsController extends Controller {

    //
    function index() {
        $academic_types = DB::select('select distinct academic_type from ctr_academic_programs');
        return view('guidance.reports.exam_result', compact('academic_types'));
    }
    
    function generate(Request $request){
        $this->validate($request, [
            'acad_type' => 'required'
        ]);
        return $this->generateNow($request);
    }

    function generateNow($request) {

        $prog=$request->acad_prog;
        $type=$request->acad_type;
        
        if ($type!=='TESDA') {
        
        $lists = DB::select("SELECT * FROM users JOIN student_infos on student_infos.idno = users.idno JOIN statuses ON statuses.idno = users.idno JOIN entrance_exams ON entrance_exams.idno = users.idno JOIN entrance_exam_schedules ON entrance_exam_schedules.id = entrance_exams.exam_schedule WHERE (statuses.academic_program = '$prog' or student_infos.course='$prog') and entrance_exams.exam_result = 'Passed' and statuses.academic_type = '$type' and statuses.status = 1");
        } else {
        $lists = DB::select("SELECT * FROM users JOIN student_infos on student_infos.idno = users.idno JOIN statuses ON statuses.idno = users.idno JOIN entrance_exams ON entrance_exams.idno = users.idno JOIN entrance_exam_schedules ON entrance_exam_schedules.id = entrance_exams.exam_schedule WHERE statuses.academic_type = '$type' and entrance_exams.exam_result = 'Passed' and statuses.academic_type = '$type' and statuses.academic_type = '$type' and statuses.status = 1");
        }
        $program = $request;
        
        $pdf = PDF::loadView('guidance.print.report', compact('lists', 'program'));
        return $pdf->stream("report.pdf");
    }

}
