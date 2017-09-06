<?php

namespace App\Http\Controllers\Registrar\Grades;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Excel;
use Illuminate\Support\Facades\Input;
use DB;

class ImportGrades extends Controller {

    //
    function college() {
        return view('registrar.grades.import_grades_college');
    }

    function importExcel2(){
        if (Input::hasFile('import_file')){
            
            $path = Input::file('import_file')->getRealPath();
            
            Excel::selectSheets('Front')->load('$path', function($reader){
                
                // reader methods
                
            })->get();
        }
    }
    
    function importExcel() {
        if (Input::hasFile('import_file')) {

            $row = 14;
            $path = Input::file('import_file')->getRealPath();

            $data = Excel::selectSheets('Front')->load($path, function($reader) {
                $reader->limitRows(false, 13);
                        
                })->get();

            if (!empty($data) && $data->count()) {

                foreach ($data as $key => $value) {
                   
                    DB::table('grade_colleges')
                            ->where(['idno'=> $value->idno])
                            ->where(['course_code'=> $value->course_code])
                            ->update(['prelim'=> $value->prelim,'midterm'=> $value->midterm,'final'=> $value->final,'final_grade'=> $value->final_grade,'grade_point'=> $value->grade_point,'remarks'=> $value->remarks,]);

                }
                    
                dd('Insert Record successfully.');

            }
        }

        return back();
    }
    
//     function importExcel(){
//        if(Input::hasFile('import_file')){
//            $test=14;
//            $path = Input::file('import_file')->getRealPath();
//            Excel::selectSheets('Front')->load($path, function($reader) use ($test){
//                $uploaded = array();
//                do{
//                    $idno = $reader->getActiveSheet()->getCell('A'.$test)->getOldCalculatedValue();
//                    
//                    $prelim = $reader->getActiveSheet()->getCell('D'.$test)->getOldCalculatedValue();
//                    $midterm = $reader->getActiveSheet()->getCell('E'.$test)->getOldCalculatedValue();
//                    $final = $reader->getActiveSheet()->getCell('F'.$test)->getOldCalculatedValue();
//                    $final_grade = $reader->getActiveSheet()->getCell('G'.$test)->getOldCalculatedValue();
//                    $grade_point = $reader->getActiveSheet()->getCell('H'.$test)->getOldCalculatedValue();
//                    $remarks = $reader->getActiveSheet()->getCell('I'.$test)->getOldCalculatedValue();
//                    $uploaded[] = array('idno'=>$idno,'prelim'=>$prelim,'midterm'=>$midterm,'final'=>$final,'final_grade'=>$final_grade,'grade_point'=>$grade_point,'remarks'=>$remarks);
//                    $test++;
//                }while(strlen($reader->getActiveSheet()->getCell('A'.$test)->getOldCalculatedValue())>1);
//                
//                session()->flash('grades', $uploaded);
//                
//            });
//            $grades = session('grades');
//                return view('registrar.grades.upload_grade',compact('grades', 'test'));
//        }
//    }

    
    function confirmImport(){
        
    }

}
