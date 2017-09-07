<?php

namespace App\Http\Controllers\Registrar\Curriculum;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

class SHSCurriculumController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    function curriculum(){
       $curriculums = \App\CtrAcademicProgram::distinct()->where('academic_type', 'Senior High School')->get(['program_code', 'track']);
       Return view ('registrar.curriculum.shs_view_curriculum', compact('curriculums'));
    }
    
    function list_curricula($track){
        return view('registrar.curriculum.shs_list_curriculum', compact('track'));
    }
    
    function viewcurriculum($curriculum_year, $track) {
        return view ('registrar.curriculum.shs_viewcurriculum', compact('track', 'curriculum_year'));
    }
}
