<?php

namespace App\Http\Controllers\Guidance\Admission;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
Use Illuminate\Support\Facades\DB;
use App\EntranceExamSchedule;

class ExamSchedCreatorController extends Controller {

    //
    public function __construct() {
        $this->middleware('auth');
    }

    function createSched() {
        if (Auth::user()->accesslevel == "1") {
            $scheds = DB::Select("select * from entrance_exam_schedules order by is_remove");
            return view('guidance.admission.createExamSched', compact('scheds'));
        }
    }

    function addexamsched() {
        if (Auth::user()->accesslevel == '1') {
            return view('guidance.admission.addExamSched');
        } else {
            Return ('Not Authorized');
        }
    }

    function addsched(Request $request) {
        if (Auth::user()->accesslevel == "1") {
            $this->validate($request, [
                'datetime' => 'required',
                'place' => 'required',
                'is_remove' => 'required',
            ]);

            return $this->createexamsched($request);
        }
    }

    function createexamsched($request) {

        $exam_sched = new EntranceExamSchedule;

        $exam_sched->datetime = $request->datetime;
        $exam_sched->place = $request->place;
        $exam_sched->is_remove = $request->is_remove;

        $exam_sched->save();

        return redirect('guidance/exam_sched_creator');
    }

    function viewmodifysched($id) {
        if (Auth::user()->accesslevel == "1") {

            $schedules = DB::table('entrance_exam_schedules')
                    ->where('id', '=', $id)
                    ->first();

            return view('guidance.admission.viewmodifysched', compact('schedules'));
        }
    }

    function updatesched(Request $request) {
        if (Auth::user()->accesslevel == "1") {

            $this->validate($request, [
                'datetime' => 'required',
                'place' => 'required',
                'is_remove' => 'required',
            ]);

            return $this->updateexamsched($request);
        }
    }

    function updateexamsched($request) {

        $id = $request->input('id');

        $exam_sched = EntranceExamSchedule::where('id', $id)->first();
        $exam_sched->datetime = $request->datetime;
        $exam_sched->place = $request->place;
        $exam_sched->is_remove = $request->is_remove;

        $exam_sched->save();

        return redirect('guidance/exam_sched_creator');
    }

    function deletesched($id) {
        if (Auth::user()->accesslevel == "1") {


            $exam_sched = EntranceExamSchedule::where('id', $id)->first();
            $exam_sched->is_remove = 1;

            $exam_sched->save();

            return redirect('guidance/exam_sched_creator');
        }
    }

}
