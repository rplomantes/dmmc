<?php

namespace App\Http\Controllers\Registrar\Curriculum;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use DB;

class TesdaCurriculumController extends Controller {

    public function __construct() {
        $this->middleware('auth');
    }

    function curriculum() {
        if (Auth::user()->accesslevel == "3") {
            $curriculums = \App\CtrAcademicProgram::distinct()->where('academic_type', 'TESDA')->get(['program_code', 'program_name']);
            Return view('registrar.curriculum.tesda_view_curriculum', compact('curriculums'));
        }
    }

    function list_curricula($program_code) {
        if (Auth::user()->accesslevel == "3") {
            return view('registrar.curriculum.tesda_list_curriculum', compact('program_code'));
        }
    }

    function viewcurriculum($curriculum_year, $program_code) {
        if (Auth::user()->accesslevel == "3") {
            return view('registrar.curriculum.tesda_viewcurriculum', compact('program_code', 'curriculum_year'));
        }
    }

}
