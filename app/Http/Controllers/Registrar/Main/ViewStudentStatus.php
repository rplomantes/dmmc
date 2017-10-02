<?php

namespace App\Http\Controllers\Registrar\Main;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ViewStudentStatus extends Controller {

    public function __construct() {
        $this->middleware('auth');
    }

    function index($idno) {
        if (Auth::user()->accesslevel == "3") {
            $student_status = \App\Status::where('idno', $idno)->first();
            if ($student_status->academic_program == Auth::user()->academic_program AND Auth::user()->accesslevel == '2' or Auth::user()->accesslevel == '3') {
                $status = $student_status->status;
                if ($status <= 1 AND $status >= 0) {
                    return view('registrar.main.viewstudentstatus', compact('idno', 'status'));
                } elseif ($status >= 2) {
                    return view('registrar.main.studentstatus2', compact('idno', 'student_status'));
                } elseif ($status == -1) {
                    return view('registrar.failed', compact('idno', 'status'));
                }
            } else {
                return view('registrar.unauthorized');
            }
        }
    }

//
}
