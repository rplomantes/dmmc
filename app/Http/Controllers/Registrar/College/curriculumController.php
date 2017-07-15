<?php

namespace App\Http\Controllers\Registrar\College;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Curriculum;
use DB;

class curriculumController extends Controller {

    function index() {
       $programs=DB::select("Select distinct program_code, program_name from ctr_academic_programs where"); 
        return view('registrar/curriculum');
    }
    
    function add() {
        return view('registrar/addcurriculum');
    }

    public function addcurriculum(Request $request) {
                
        $curriculum = new Curriculum;
        
        $curriculum->curriculum_id = $request->input('curriculum_id');
        $curriculum->curriculum_year = $request->input('curriculum_year');
        $curriculum->program_code = $request->input('program_code');
        $curriculum->program_name = $request->input('program_name');
        $curriculum->course_code = $request->input('course_code');
        $curriculum->course_name = $request->input('course_name');
        $curriculum->units = $request->input('units');
        $curriculum->hours = $request->input('hours');
        $curriculum->level = $request->input('level');
        $curriculum->period = $request->input('period');
        $curriculum->course_type = $request->input('course_type');
        
        $curriculum->save();
        
        return view('registrar/addcurriculum');
    }

}
