<?php

namespace App\Http\Controllers\Registrar\Main;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use PDF;

class StudentProfile extends Controller {

    public function __construct() {
        $this->middleware('auth');
    }

    //
    function index($idno) {
        if (Auth::user()->accesslevel == "3") {

//        if (count($levels)>0){ 
//            foreach ($levels as $level){
//                $courses = \App\Curriculum::where('curriculum_year', $student_info->curriculum_year)
//                            ->where('level', $level->level)
//                            ->where('program_code', $status->program_code)
//                            ->where('period', $level->period)
//                            ->get(['course_code', 'course_name']);
//                
//                $curriculum = "<table class=\'table table-condensed\'><thead><th class=\"col-sm-1\">Subject Code</th><th class=\"col-sm-4\">Subject Name</th><th class=\"col-sm-1\">Remarks</th></thead>";
//            
//                foreach ($courses as $course){
//                $curriculum = $curriculum."<tr><td>" . $course->course_code . "</td>"
//                        . "<td>" . $course->course_name . "</td>"
//                        . "<td>". $this->getRemarks($idno ,$course->course_code) . "</td></tr>";
//                }
//                $curriculum = $curriculum. "</table>";
//                
//            }
//            
//        }

            return view('registrar.studentprofile', compact('idno'));
        }
    }

    function getRemarks($idno, $course_code) {
        if (Auth::user()->accesslevel == "3") {
            $grade = \App\GradeCollege::where('idno', $idno)->where('course_code', $course_code)->get();
            if (count($grade) > 0) {
                foreach ($grade as $grades) {
                    $data = $grades->remarks;
                    return $data;
                }
            } else {
                return "";
            }
        }
    }

    function update(Request $request) {
        if (Auth::user()->accesslevel == "3") {

            $updateuser = \App\User::where('idno', $request->idno)->first();
            $updateuser->firstname = $request->firstname;
            $updateuser->middlename = $request->middlename;
            $updateuser->lastname = $request->lastname;
            $updateuser->email = $request->email;
            $updateuser->save();

            $updatestudentinfo = \App\StudentInfo::where('idno', $request->idno)->first();
            $updatestudentinfo->address = $request->address;
            $updatestudentinfo->contact_no = $request->contact_no;
            $updatestudentinfo->birthdate = $request->birthdate;
            $updatestudentinfo->place_of_birth = $request->place_of_birth;
            $updatestudentinfo->citizenship = $request->citizenship;
            $updatestudentinfo->civil_status = $request->civil_status;
            $updatestudentinfo->religion = $request->religion;
            $updatestudentinfo->gender = $request->gender;

            $updatestudentinfo->pri_school = $request->pri_school;
            $updatestudentinfo->pri_address = $request->pri_address;
            $updatestudentinfo->pri_from = $request->pri_from;
            $updatestudentinfo->pri_to = $request->pri_to;
            $updatestudentinfo->pri_degree = $request->pri_degree;

            $updatestudentinfo->sec_school = $request->sec_school;
            $updatestudentinfo->sec_address = $request->sec_address;
            $updatestudentinfo->sec_from = $request->sec_from;
            $updatestudentinfo->sec_to = $request->sec_to;
            $updatestudentinfo->sec_degree = $request->sec_degree;

            $updatestudentinfo->ter_school = $request->ter_school;
            $updatestudentinfo->ter_address = $request->ter_address;
            $updatestudentinfo->ter_from = $request->ter_from;
            $updatestudentinfo->ter_to = $request->ter_to;
            $updatestudentinfo->ter_degree = $request->ter_degree;

            $updatestudentinfo->voc_school = $request->voc_school;
            $updatestudentinfo->voc_address = $request->voc_address;
            $updatestudentinfo->voc_from = $request->voc_from;
            $updatestudentinfo->voc_to = $request->voc_to;
            $updatestudentinfo->voc_degree = $request->voc_degree;

            $updatestudentinfo->oth_school = $request->oth_school;
            $updatestudentinfo->oth_address = $request->oth_address;
            $updatestudentinfo->oth_from = $request->oth_from;
            $updatestudentinfo->oth_to = $request->oth_to;
            $updatestudentinfo->oth_degree = $request->oth_degree;

            $updatestudentinfo->pri_awards = $request->pri_awards;
            $updatestudentinfo->pri_awards_year = $request->pri_awards_year;
            $updatestudentinfo->sec_awards = $request->sec_awards;
            $updatestudentinfo->sec_awards_year = $request->sec_awards_year;
            $updatestudentinfo->ter_awards = $request->ter_awards;
            $updatestudentinfo->ter_awards_year = $request->ter_awards_year;

            $updatestudentinfo->hobbies = $request->hobbies;
            $updatestudentinfo->sports = $request->sports;
            $updatestudentinfo->talents = $request->talents;

            $updatestudentinfo->emergency_contact_person = $request->emergency_contact_person;
            $updatestudentinfo->emergency_relationship = $request->emergency_relationship;
            $updatestudentinfo->emergency_address = $request->emergency_address;
            $updatestudentinfo->emergency_contact_no = $request->emergency_contact_no;

            $updatestudentinfo->save();

            $this->addFamily($request);

            return back();
        }
    }

    function addFamily($request) {
        if (Auth::user()->accesslevel == "3") {

            $checkfather = \App\Family::where('id', $request->father_id)->where('idno', $request->idno)->where('family_role', "Father")->first();
            if (count($checkfather) > 0) {
                $checkfather->name = $request->father_name;
                $checkfather->birthdate = $request->father_bday;
                $checkfather->occupation = $request->father_occupation;
                $checkfather->income = $request->father_income;
                $checkfather->save();
            } else {
                $addfather = new \App\Family;
                $addfather->idno = $request->idno;
                $addfather->name = $request->father_name;
                $addfather->birthdate = $request->father_bday;
                $addfather->occupation = $request->father_occupation;
                $addfather->income = $request->father_income;
                $addfather->family_role = "Father";
                $addfather->save();
            }

            $checkmother = \App\Family::where('id', $request->mother_id)->where('idno', $request->idno)->where('family_role', "Mother")->first();
            if (count($checkmother) > 0) {
                $checkmother->name = $request->mother_name;
                $checkmother->birthdate = $request->mother_bday;
                $checkmother->occupation = $request->mother_occupation;
                $checkmother->income = $request->mother_income;
                $checkmother->save();
            } else {
                $addmother = new \App\Family;
                $addmother->idno = $request->idno;
                $addmother->name = $request->mother_name;
                $addmother->birthdate = $request->mother_bday;
                $addmother->occupation = $request->mother_occupation;
                $addmother->income = $request->mother_income;
                $addmother->family_role = "Mother";
                $addmother->save();
            }
        }
    }

    function printProfile($idno) {
        if (Auth::user()->accesslevel == "3") {
            $pdf = PDF::loadView('registrar.print.studentInformationSheet', compact('idno'));
            $pdf->setPaper(array(0, 0, 612.00, 936.0));
            return $pdf->stream("student_information_sheet_$idno.pdf");
        }
    }

}
