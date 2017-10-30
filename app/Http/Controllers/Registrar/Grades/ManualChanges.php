<?php

namespace App\Http\Controllers\Registrar\Grades;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Auth;

class ManualChanges extends Controller
{
    //
    public function __construct() {
        $this->middleware('auth');
    }

    //START COLLEGE/TESDA
    function college() {
        if (Auth::user()->accesslevel == "3") {
            return view('registrar.grades.manualchanges_college');
        }
    }
    function liststudents_college($id) {
        if (Auth::user()->accesslevel == "3") {
            $students = \App\GradeCollege::where('course_offering_id', $id)->get();
            return view('registrar.grades.liststudents_college', compact('students'));
        }
    }
}
