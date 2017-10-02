<?php

namespace App\Http\Controllers\Registrar\Grades;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Excel;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Auth;
use DB;

class ImportGrades extends Controller {

    public function __construct() {
        $this->middleware('auth');
    }

    //START COLLEGE/TESDA
    function college() {
        if (Auth::user()->accesslevel == "3") {
            return view('registrar.grades.import_grades_college');
        }
    }

    function importExcelCollege(Request $request) {
        if (Auth::user()->accesslevel == "3") {
            $row = 14;
            $path = Input::file('import_file')->getRealPath();
            Excel::selectSheets('Front')->load($path, function($reader) use ($row) {
                $uploaded = array();
                do {
                    $idno = $reader->getActiveSheet()->getCell('B' . $row)->getValue();
                    $prelim = $reader->getActiveSheet()->getCell('D' . $row)->getValue();
                    $midterm = $reader->getActiveSheet()->getCell('E' . $row)->getValue();
                    $final = $reader->getActiveSheet()->getCell('F' . $row)->getValue();
                    $final_grade = $reader->getActiveSheet()->getCell('G' . $row)->getValue();
                    $grade_point = $reader->getActiveSheet()->getCell('H' . $row)->getValue();
                    $remarks = $reader->getActiveSheet()->getCell('I' . $row)->getValue();

                    $uploaded[] = array('idno' => $idno, 'prelim' => $prelim, 'midterm' => $midterm, 'final' => $final, 'final_grade' => $final_grade, 'grade_point' => $grade_point, 'remarks' => $remarks);
                    $row++;
                } while (strlen($reader->getActiveSheet()->getCell('B' . $row)->getValue()) > 6);

                session()->flash('grades', $uploaded);
            });

            Excel::selectSheets('Front')->load($path, function($reader) {

                $course_code = $reader->getActiveSheet()->getCell('C1')->getValue();

                session()->flash('course', $course_code);
            });

            Excel::selectSheets('Front')->load($path, function($reader) {

                $prof_id = $reader->getActiveSheet()->getCell('B3')->getValue();

                session()->flash('prof', $prof_id);
            });

            $grades = session('grades');
            $course = session('course');
            $prof = session('prof');

            return view('registrar.grades.upload_grade', compact('grades', 'course', 'prof', 'request'));
        }
    }

    function saveExcelCollege(Request $request) {
        if (Auth::user()->accesslevel == "3") {

            $course_code = $request->input('course_code');
            $prelim = $request->input('prelim');
            $midterm = $request->input('midterm');
            $final = $request->input('final');
            $final_grade = $request->input('final_grade');
            $grade_point = $request->input('grade_point');
            $remarks = $request->input('remarks');

            //prelim
            foreach ($prelim as $key => $value) {
                if ($value != "" || $value != null || preg_match('/^[0-9]*$/', $value)) {
                    $grade_prelim = \App\GradeCollege::where('idno', $key)->where('course_code', $course_code)->first();
                    if (!empty($grade_prelim)) {
                        $grade_prelim->prelim = $value;
                        $grade_prelim->save();
                    }
                }
            }
            //midterm
            foreach ($midterm as $key => $value) {
                if ($value != "" || $value != null || preg_match('/^[0-9]*$/', $value)) {
                    $grade_midterm = \App\GradeCollege::where('idno', $key)->where('course_code', $course_code)->first();
                    if (!empty($grade_midterm)) {
                        $grade_midterm->midterm = $value;
                        $grade_midterm->save();
                    }
                }
            }
            //final
            foreach ($final as $key => $value) {
                if ($value != "" || $value != null || preg_match('/^[0-9]*$/', $value)) {
                    $final = \App\GradeCollege::where('idno', $key)->where('course_code', $course_code)->first();
                    if (!empty($grade_final)) {
                        $final->final = $value;
                        $final->save();
                    }
                }
            }
            //final grade
            foreach ($final_grade as $key => $value) {
                if ($value != "" || $value != null || preg_match('/^[0-9]*$/', $value)) {
                    $final_grade = \App\GradeCollege::where('idno', $key)->where('course_code', $course_code)->first();
                    if (!empty($final)) {
                        $final_grade->final_grade = $value;
                        $final_grade->save();
                    }
                }
            }
            //grade point
            foreach ($grade_point as $key => $value) {
                if ($value != "" || $value != null || preg_match('/^[0-9]*$/', $value)) {
                    $grade_point = \App\GradeCollege::where('idno', $key)->where('course_code', $course_code)->first();
                    if (!empty($grade_point)) {
                        $grade_point->grade_point = $value;
                        $grade_point->save();
                    }
                }
            }
            //remarks
            foreach ($remarks as $key => $value) {
                if ($value != "" || $value != null || preg_match('/^[0-9]*$/', $value)) {
                    $remarks = \App\GradeCollege::where('idno', $key)->where('course_code', $course_code)->first();
                    if (!empty($remarks)) {
                        $remarks->remarks = $value;
                        $remarks->save();
                    }
                }
            }
            return redirect('/registrar/import_grades/college');
        }
    }

    //END COLLEGE/TESDA
    //START SENIOR HIGHSCHOOL
    function shs() {
        if (Auth::user()->accesslevel == "3") {
            return view('registrar.grades.import_grades_shs');
        }
    }

    function importExcelSHS(Request $request) {
        if (Auth::user()->accesslevel == "3") {
            $row = 13;
            $path = Input::file('import_file')->getRealPath();
            Excel::selectSheets('Final Semestral Grade')->load($path, function($reader) use ($row) {
                $uploaded = array();
                do {
                    $idno = $reader->getActiveSheet()->getCell('B' . $row)->getValue();
                    ;
                    $first_qtr = $reader->getActiveSheet()->getCell('F' . $row)->getValue();
                    $second_qtr = $reader->getActiveSheet()->getCell('N' . $row)->getValue();
                    $final_grade = $reader->getActiveSheet()->getCell('V' . $row)->getValue();
                    $remarks = $reader->getActiveSheet()->getCell('Z' . $row)->getValue();

                    $uploaded[] = array('idno' => $idno, 'first_qtr' => $first_qtr, 'second_qtr' => $second_qtr, 'final_grade' => $final_grade, 'remarks' => $remarks);
                    $row++;
                } while (strlen($reader->getActiveSheet()->getCell('B' . $row)->getValue()) > 6);

                session()->flash('grades', $uploaded);
            });

//        Excel::selectSheets('Front')->load($path, function($reader){
//            
//            $course_code = $reader->getActiveSheet()->getCell('C1')->getValue();
//                        
//            session()->flash('course', $course_code);
//        });
//        
//        Excel::selectSheets('Front')->load($path, function($reader){
//            
//            $prof_id = $reader->getActiveSheet()->getCell('B3')->getValue();
//                        
//            session()->flash('prof', $prof_id);
//        });

            $grades = session('grades');
            $course = session('course');
            $prof = session('prof');

            return view('registrar.grades.upload_grade_shs', compact('grades', 'course', 'prof', 'request'));
        }
    }

}
