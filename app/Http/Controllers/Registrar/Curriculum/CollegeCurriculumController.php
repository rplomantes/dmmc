<?php

namespace App\Http\Controllers\Registrar\Curriculum;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

class CollegeCurriculumController extends Controller
{
    function curriculum(){
       $curriculums = \App\CtrAcademicProgram::distinct()->where('academic_type', 'College')->orWhere('academic_type', 'TESDA')->get(['program_code', 'program_name']);
       Return view ('registrar.curriculum.college_view_curriculum', compact('curriculums'));
    }
    
    function list_curricula($program_code){
        return view('registrar.curriculum.college_list_curriculum', compact('program_code'));
    }
    
    function viewcurriculum($curriculum_year, $program_code) {
        return view ('registrar.curriculum.college_viewcurriculum', compact('program_code', 'curriculum_year'));
    }
}
