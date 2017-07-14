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

        $prog=$request->input('acad_prog');
        
        $lists = DB::select("SELECT * FROM users JOIN statuses ON statuses.idno = users.idno JOIN entrance_exams ON entrance_exams.idno = users.idno JOIN entrance_exam_schedules ON entrance_exam_schedules.id = entrance_exams.exam_schedule WHERE statuses.academic_program = '$prog' and entrance_exams.exam_result = 'Passed'");

        $program = $request;
        
        $pdf = PDF::loadView('guidance.print.report', compact('lists', 'program'));
        return $pdf->stream("report.pdf");
    }

}
