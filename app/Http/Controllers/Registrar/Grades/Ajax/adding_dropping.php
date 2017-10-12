<?php

namespace App\Http\Controllers\Registrar\Grades\Ajax;

use Illuminate\Support\Facades\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
Use Illuminate\Support\Facades\DB;

class adding_dropping extends Controller {

    //
    function getmainstudentlist() {
        if (Request::ajax()) {
            $search = Input::get("search");
            $lists = DB::select("SELECT * FROM `users` join statuses on users.idno = statuses.idno join student_infos on student_infos.idno = users.idno where statuses.status = 4 and (statuses.academic_type='College' or statuses.academic_type='TESDA') and (users.lastname like '%$search%' or users.firstname like '%$search%' or users.idno like '%$search%') order by users.lastname asc");
            return view('registrar.grades.ajax.getmainstudentlist', compact('lists'));
        }
    }

    function addcourse($id) {
        if (Request::ajax()) {
            $idno = Input::get("idno");
            $status = \App\Status::where('idno', $idno)->first();

            $offering = \App\CourseOffering::where('id', $id)->first();

            $checksubject = \App\GradeCollege::where('idno', $idno)->where('course_code', $offering->course_code)->get();
            if (count($checksubject) == 0) {
                //add in grades
                $newgrade = new \App\GradeCollege;
                $newgrade->idno = $idno;
                $newgrade->course_offering_id = $id;
                $newgrade->course_code = $offering->course_code;
                $newgrade->course_name = $offering->course_name;
                $newgrade->level = $offering->level;
                $newgrade->lec = $offering->lec;
                $newgrade->lab = $offering->lab;
                $newgrade->hours = $offering->hours;
                $newgrade->school_year = $offering->school_year;
                $newgrade->period = $offering->period;
                $newgrade->percent_tuition = $offering->percent_tuition;
                $newgrade->save();

                //add in ledger
                if ($status->type_of_account == "regular") {
                    $tfr = \App\CtrCollegeTuition::where('program_code', $status->program_code)->where('level', $status->level)->first();
                    $tuitionrate = $tfr->per_unit;
                    $this->getCollegeTuition($idno, $status->school_year, $status->period, $status->level, $status->program_code, $tuitionrate, $offering->course_code);
                }
                $this->recomputeduedate($idno);
            }
            $data = "Subjects: <table class=\"table table-condensed table-striped\">
            <thead>
                <tr>
                    <th>Subject Code</th>
                    <th>Subject Name</th>
                    <th>Section</th>
                    <th>Drop</th>
                </tr>
            </thead>
            <tbody>";
            $courses = \App\GradeCollege::where('idno', $idno)->where('school_year', $status->school_year)->where('period', $status->period)->get();
            foreach ($courses as $course) {
                $section = \App\CourseOffering::where('id', $course->course_offering_id)->first();
                
                if ($course->is_drop == 0){
                    $dropped= "<a href=\"javascript:void(0)\" onclick=\"dropcourse('".$course->course_offering_id."')\">Drop</a>";
                }else{
                    $dropped = "Dropped";
                }
                
                $data = $data . "<tr>
                    <td>" . $course->course_code . "</td>
                    <td>" . $course->course_name . "</td>
                    <td>" . $section->section . "</td>
                    <td>" . $dropped . "</td>
                </tr>";
            }
            $data = $data . "</tbody></table>";
            return $data;
        }
    }

    function recomputeduedate($idno) {
        $status = \App\Status::where('idno', $idno)->first();
        $totalTuition = DB::Select("Select sum(amount) as amounts from ledgers where school_year = $status->school_year and idno=$idno and period = '$status->period' and (category_switch = 1 or category_switch = 3)");

        $total = 0;
        foreach ($totalTuition as $totalTuitions) {
            $total = $totalTuitions->amounts;
        }
        $plans = \App\CtrDueDate::where('academic_type', $status->academic_type)->where('plan', $status->plan)->get();

        if ($status->plan == 'full') {

            $oldledgerduedates = \App\LedgerDueDate::where('idno', $idno)->where('school_year', $status->school_year)->where('period', $status->period)->where('due_switch', 0)->first();
            $oldledgerduedates->amount = $total;
            $oldledgerduedates->amount2 = $total;
            $oldledgerduedates->save();
        } else {
            $down = \App\LedgerDueDate::where('idno', $idno)->where('school_year', $status->school_year)->where('period', $status->period)->where('due_switch', 0)->first();
            $increase = ($total - $down->amount) / count($plans);
            foreach ($plans as $paln) {

                $oldledgerduedates = \App\LedgerDueDate::where('idno', $idno)->where('school_year', $status->school_year)->where('period', $status->period)->where('due_switch', 1)->where('due_date', $paln->due_date)->first();
                $oldledgerduedates->amount = $increase;
                $oldledgerduedates->amount2 = $increase;
                $oldledgerduedates->save();

                //$this->compute12percent($down, $totalTuition, $plans, $idno);
            }
        }
    }

    function getdiscountrate($type, $discount_code) {
        if ($type == 'tf') {
            return \App\CtrDiscount::where('discount_code', $discount_code)->first()->tuition_fee;
        } elseif ($type == 'of') {
            return \App\CtrDiscount::where('discount_code', $discount_code)->first()->other_fee;
        }
    }

    function getCollegeTuition($idno, $school_year, $period, $level, $program_code, $tuitionrate, $course_code) {
        $grades = \App\GradeCollege::where('idno', $idno)->where('school_year', $school_year)->where('period', $period)->where('course_code', $course_code)->get();
        $chartofaccount = \App\ChartOfAccount::where('accounting_name', "Tuition Fees")->first();
        if (count($grades) > 0) {
            foreach ($grades as $grade) {
                $addledger = new \App\ledger;
                $addledger->idno = $idno;
                $addledger->program_code = $program_code;
                $addledger->level = $level;
                $addledger->school_year = $school_year;
                $addledger->period = $period;
                $addledger->category = "Tuition Fee";
                $addledger->description = $grade->course_code;
                $addledger->receipt_details = "Tuition Fee";
                $addledger->receipt_type = "OR";
                $addledger->accounting_code = $chartofaccount->accounting_code;
                $addledger->category_switch = "3";
                $addledger->amount = (($grade->lec * $tuitionrate * $grade->percent_tuition / 100) + (($grade->lab * $tuitionrate * $grade->percent_tuition / 100) * 3));
                $addledger->save();
                $this->getSpecialFee($grade->course_code, $level, $program_code, $school_year, $period, $idno);
            }
        }
    }

    function getSpecialFee($course_code, $level, $program_code, $school_year, $period, $idno) {
        $fees = \App\CtrSpecialFee::where('course_code', $course_code)->get();
        if (count($fees) > 0) {
            foreach ($fees as $fee) {
                $addledger = new \App\ledger;
                $addledger->idno = $idno;
                $addledger->program_code = $program_code;
                $addledger->level = $level;
                $addledger->school_year = $school_year;
                $addledger->period = $period;
                $addledger->category = $fee->category;
                $addledger->description = $fee->description;
                $addledger->receipt_details = $fee->receipt_details;
                $addledger->receipt_type = $fee->receipt_type;
                $addledger->accounting_code = $fee->accounting_code;
                $addledger->category_switch = $fee->category_switch;
                $addledger->amount = $fee->amount;
                $addledger->save();
            }
        }
    }

    function dropcourse($id) {
        if (Request::ajax()) {
            $idno = Input::get("idno");
            $status = \App\Status::where('idno', $idno)->first();
            $course = \App\GradeCollege::where('idno', $idno)->where('school_year', $status->school_year)->where('period', $status->period)->where('is_drop', 0)->where('course_offering_id', $id)->first();

            $removeledger = \App\ledger::where('idno', $idno)->where('school_year', $status->school_year)->where('period', $status->period)->where('description', $course->course_code)->where('category_switch', 3)->first();
            if (count($removeledger) > 0) {

                $course->is_drop = 1;
                $course->save();

                if ($removeledger->payment == 0.00) {
                    $removeledger->delete();
                } else {
                    $payment = $removeledger->payment;
                    $removeledger->delete();
                    $ledgers = \App\ledger::where('idno', $idno)->where('school_year', $status->school_year)->where('period', $status->period)->orderBy('id', 'asc')->get();
                    foreach ($ledgers as $ledger) {
                        $course = \App\ledger::where('id', $ledger->id)->first();
                        if ($payment != 0) {
                            if ($course->amount > $course->payment) {
                                $add = $course->amount - $course->payment;
                                if ($add > $payment) {
                                    $course->payment = $payment + $course->payment;
                                    $course->save();
                                    $payment = 0;
                                } else {
                                    $course->payment = $add + $course->payment;
                                    $course->save();
                                    $payment = $payment - $add;
                                }
                            }
                        }
                    }
                }
            }
            $data = "Subjects: <table class=\"table table-condensed table-striped\">
            <thead>
                <tr>
                    <th>Subject Code</th>
                    <th>Subject Name</th>
                    <th>Section</th>
                    <th>Drop</th>
                </tr>
            </thead>
            <tbody>";
            $courses = \App\GradeCollege::where('idno', $idno)->where('school_year', $status->school_year)->where('period', $status->period)->get();
            foreach ($courses as $course) {
                $section = \App\CourseOffering::where('id', $course->course_offering_id)->first();
                
                if ($course->is_drop == 0){
                    $dropped= "<a href=\"javascript:void(0)\" onclick=\"dropcourse('".$course->course_offering_id."')\">Drop</a>";
                }else{
                    $dropped = "Dropped";
                }
                
                $data = $data . "<tr>
                    <td>" . $course->course_code . "</td>
                    <td>" . $course->course_name . "</td>
                    <td>" . $section->section . "</td>
                    <td>" . $dropped . "</td>
                </tr>";
            }
            $data = $data . "</tbody></table>";
            
            $this->recomputeduedate($idno);
            
            return $data;
        }
    }

}
