<?php

namespace App\Http\Controllers\Guidance\Admission;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
Use Illuminate\Support\Facades\DB;
use App\EntranceExamSchedule;

class ExamSchedCreatorController extends Controller {

    //
    function createSched() {
        $scheds = DB::Select("select * from entrance_exam_schedules order by is_remove");
        return view('guidance.admission.createExamSched', compact('scheds'));
    }
    
    function addexamsched() {
        return view('guidance.admission.addExamSched');
    }
    
    function addsched(Request $request) {
        $this->validate($request, [
            'datetime'=>'required',
            'place'=>'required',
            'is_remove'=>'required',
            
        ]);
        
        return $this->createexamsched($request);
    }
    
    function createexamsched($request) {
        
        $exam_sched = new EntranceExamSchedule;
        
        $exam_sched->datetime = $request->input('datetime');
        $exam_sched->place = $request->input('place');
        $exam_sched->is_remove = $request->input('is_remove');
        
        $exam_sched -> save();
        
      return redirect('guidance/exam_sched_creator');  
    }
    
    function viewmodifysched($id) {
        
        $schedules = DB::table('entrance_exam_schedules')
                ->where ('id','=',$id)
                ->first();

        return view('guidance.admission.viewmodifysched', compact('schedules'));
    }
    
    function updatesched(Request $request) {
        
        $this->validate($request, [
            'datetime'=>'required',
            'place'=>'required',
            'is_remove'=>'required',
            
        ]);

        return $this->updateexamsched($request);
    }
    
    function updateexamsched($request){

        $id=$request->input('id');
        
        $exam_sched = EntranceExamSchedule::where('id', $id)->first();
        $exam_sched->datetime = $request->input('datetime');
        $exam_sched->place = $request->input('place');
        $exam_sched->is_remove = $request->input('is_remove');
        
        $exam_sched -> save();
        
        return redirect('guidance/exam_sched_creator');
    }
    
    function deletesched($id){

        
        $exam_sched = EntranceExamSchedule::where('id', $id)->first();
        $exam_sched->is_remove = 1;
        
        $exam_sched -> save();
        
        return redirect('guidance/exam_sched_creator');
    }

}
