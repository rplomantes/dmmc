<?php

namespace App\Http\Controllers\Registrar\Curriculum;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

class CurriculumController extends Controller
{
    function curriculum(){
       $curriculums = \App\CtrAcademicProgram::distinct()->where('academic_type', 'College')->orWhere('academic_type', 'TESDA')->get(['program_code', 'program_name']);
       Return view ('registrar.curriculum.view_curriculum', compact('curriculums'));
    }
    
    function list_curricula($program_code){
        return view('registrar.curriculum.list_curriculum', compact('program_code'));
    }
    
    function viewcurriculum($curriculum_year, $program_code) {
        return view ('registrar.curriculum.viewcurriculum', compact('program_code', 'curriculum_year'));
    }
}
