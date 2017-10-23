<?php

namespace App\Http\Controllers\Registrar\Reports;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use PDF;
use DB;

class reportsController extends Controller {

    //
    public function __construct() {
        $this->middleware('auth');
    }

    function enrollment_report() {
        if (Auth::user()->accesslevel == "3") {
            return view('registrar.reports.enrollment_report');
        }
    }

    function generate_enrollmentreport(Request $request) {
        if (Auth::user()->accesslevel == "3") {
            if ($request->date == NULL) {
                $date = "";
            } else {
                $date = "and date_enrolled = '" . $request->date . "'";
            }

            if ($request->program_code == NULL) {
                $program_code = "";
            } else {
                $program_code = "and (program_code = '" . $request->program_code . "' or track = '" . $request->program_code . "')";
            }

            if ($request->level == NULL) {
                $level = "";
            } else {
                $level = "and level = '" . $request->level . "'";
            }

            if ($request->category == NULL) {
                $category = "";
            } else {
                $category = "and isnew = '" . $request->category . "'";
            }

            $lists = DB::Select("Select * from statuses where status=4 $date $program_code $level $category");

            $pdf = PDF::loadView('registrar.print.enrollment_report', compact('lists'));
            return $pdf->stream("enrollment_report.pdf");
        }
    }

}
