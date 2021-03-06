<?php

namespace App\Http\Controllers\Registrar\Curriculum;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use DB;

class CollegeCurriculumController extends Controller {

    public function __construct() {
        $this->middleware('auth');
    }

    function curriculum() {
        if (Auth::user()->accesslevel == "3") {
            $curriculums = \App\CtrAcademicProgram::distinct()->where('academic_type', 'College')->get(['program_code', 'program_name']);
            Return view('registrar.curriculum.college_view_curriculum', compact('curriculums'));
        }
    }

    function list_curricula($program_code) {
        if (Auth::user()->accesslevel == "3") {
            return view('registrar.curriculum.college_list_curriculum', compact('program_code'));
        }
    }

    function viewcurriculum($curriculum_year, $program_code) {
        if (Auth::user()->accesslevel == "3") {
            return view('registrar.curriculum.college_viewcurriculum', compact('program_code', 'curriculum_year'));
        }
    }

}
