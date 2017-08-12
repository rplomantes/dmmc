@extends('layouts.deanapp')
@section('content')
<style>
    .label{color: gray;}
    .bs-wizard {margin-top: 40px;}

/*Form Wizard*/
.bs-wizard {border-bottom: solid 1px #e0e0e0; padding: 0 0 10px 0;}
.bs-wizard > .bs-wizard-step {padding: 0; position: relative;}
.bs-wizard > .bs-wizard-step + .bs-wizard-step {}
.bs-wizard > .bs-wizard-step .bs-wizard-stepnum {color: #595959; font-size: 16px; margin-bottom: 5px;}
.bs-wizard > .bs-wizard-step .bs-wizard-info {color: #999; font-size: 14px;}

.bs-wizard > .bs-wizard-step .bs-wizard-stepnum-active {color: #053f6f; font-size: 16px; margin-bottom: 5px;}
.bs-wizard > .bs-wizard-step .bs-wizard-info-active {color: #3097d1; font-size: 14px;}

.bs-wizard > .bs-wizard-step > .bs-wizard-dot-active {position: absolute; width: 30px; height: 30px; display: block; background: #3097d1; top: 45px; left: 50%; margin-top: -15px; margin-left: -15px; border-radius: 50%;} 
.bs-wizard > .bs-wizard-step > .bs-wizard-dot-active:after {content: ' '; width: 14px; height: 14px; background: #053f6f; border-radius: 50px; position: absolute; top: 8px; left: 8px; } 

.bs-wizard > .bs-wizard-step > .bs-wizard-dot {position: absolute; width: 30px; height: 30px; display: block; background: darkgray; top: 45px; left: 50%; margin-top: -15px; margin-left: -15px; border-radius: 50%;} 
.bs-wizard > .bs-wizard-step > .bs-wizard-dot:after {content: ' '; width: 14px; height: 14px; background: gray; border-radius: 50px; position: absolute; top: 8px; left: 8px; } 

.bs-wizard > .bs-wizard-step > .progress {position: relative; border-radius: 0px; height: 8px; box-shadow: none; margin: 20px 0;}
.bs-wizard > .bs-wizard-step > .progress > .progress-bar {width:0px; box-shadow: none; background: gray;}
.bs-wizard > .bs-wizard-step.complete > .progress > .progress-bar {width:100%;}
.bs-wizard > .bs-wizard-step.active > .progress > .progress-bar {width:50%;}
.bs-wizard > .bs-wizard-step:first-child.active > .progress > .progress-bar {width:0%;}
.bs-wizard > .bs-wizard-step:last-child.active > .progress > .progress-bar {width: 100%;}
.bs-wizard > .bs-wizard-step.disabled > .bs-wizard-dot {background-color: #f5f5f5;}
.bs-wizard > .bs-wizard-step.disabled > .bs-wizard-dot:after {opacity: 0;}
.bs-wizard > .bs-wizard-step:first-child  > .progress {left: 50%; width: 50%;}
.bs-wizard > .bs-wizard-step:last-child  > .progress {width: 50%;}
.bs-wizard > .bs-wizard-step.disabled a.bs-wizard-dot{ pointer-events: none; }
/*END Form Wizard*/
</style>
<?php
$user = \App\User::where('idno',$idno)->first();
$info = \App\StudentInfo::where('idno',$idno)->first();
$status = \App\Status::where('idno',$idno)->first();
$academic_program = $status->academic_program;
$academic_type = $status->academic_type;

if($academic_type=="College"){
    $programs = \Illuminate\Support\Facades\DB::Select("Select distinct program_code, program_name from ctr_academic_programs where academic_program = '$academic_program'");
    $levels = \Illuminate\Support\Facades\DB::Select("Select level from ctr_academic_programs where program_code = '" . $info->course . "'");
}
else if($academic_type=="Senior High School"){
    $tracks = \Illuminate\Support\Facades\DB::Select("Select distinct track from ctr_academic_programs where academic_program = '$academic_program'");
    $levels = \Illuminate\Support\Facades\DB::Select("Select distinct level from ctr_academic_programs where track ='". $info->course ."'");
    
}
else if($academic_type == "Basic Education"){
    
}
else if($academic_type=="TESDA"){
    $programs = \Illuminate\Support\Facades\DB::Select("Select distinct program_code, program_name from ctr_academic_programs where academic_program = '$academic_program'");
    $levels = \Illuminate\Support\Facades\DB::Select("Select level from ctr_academic_programs where program_code = '" . $info->course . "'");
    
}
?>

    <table class="table table-condensed">
        <tr><td>Reference No</td><td><span class = "label label-danger">{{$idno}}</span></td></tr>
            <tr><td>Student Name</td><td><strong>{{$user->lastname}}, {{$user->firstname}} {{$user->middlename}} {{$user->extensionname}}</strong></td></tr>
                <tr><td>Contact Number</td><td>{{$info->contact_no}}</td></tr>
                    <tr><td>Email Address</td><td>{{$user->email}}</td></tr>
        @if($status->academic_program=="CBEAS" OR $status->academic_program=="CAMPS" )             
                        <tr><td>Course Intended To Enroll</td><td>{{$info->course}}</td></tr>
                            <tr><td>Second Course of Choice</td><td>{{$info->course2}}</td></tr>
        @else
                         <tr><td>Track Intended To Enroll</td><td>{{$info->course}}</td></tr>
                            <tr><td>Second Track of Choice</td><td>{{$info->course2}}</td></tr>
        @endif
        @if($status->status==0)
            <tr><td colspan="2" align="center"><h3 class="label-danger" style="color:#ffffff;padding:10px">Please See Guidance for Entrance Exam</h3></td></tr>
        @elseif($status->status==1)
            <tr><td colspan="2">
                
            @if($status->academic_program=="CBEAS" OR $status->academic_program=="CAMPS" )    
                <form class="form-horizontal" method="POST" action="{{url('dean',array('main','selectsubjectcollege'))}}">    
                {{ csrf_field() }}
                <input type="hidden" name="academic_program" value="{{$status->academic_program}}">
                <input type="hidden" name="idno" value="{{$idno}}">
                
                    <div class="form form-group">       
                        <div class="col-sm-12">
                            <label>Select Course To Register</label>
                                <select name="program_code" class="form form-control">
                                    @foreach($programs as $program)
                                        <option value="{{$program->program_code}}"
                                            @if($program->program_code == $status->program_code)
                                            selected="selected"
                                            @endif>{{$program->program_name}}</option>
                                    @endforeach
                                </select>
                        </div>
                    </div>
                    <div class="form form-group">    
                        <div class="col-sm-12">
                            <label>Select Level</label>
                               <select name="level" class="form form-control">
                                    @foreach($levels as $level)
                                    <option value="{{$level->level}}"
                                            @if($status->level == $level->level)
                                            selected="selected"
                                            @endif
                                            >{{$level->level}}</option>
                                    @endforeach
                                </select>
                        </div> 
                    </div>
                    <div class="form form-group">
                        <div class="col-sm-12">
                            <input type="submit" value="Next >> Select Subjects" class="form form-control btn btn-primary">
                        </div>    
                    </div>    
                    
                </form>
            @elseif($status->academic_program=="Senior High School")
             <form class="form-horizontal" method="POST" action="{{url('dean',array('main','selectsubjectshs'))}}">    
                {{ csrf_field() }}
                <input type="hidden" name="academic_program" value="{{$status->academic_program}}">
                <input type="hidden" name="idno" value="{{$idno}}">
                
                    <div class="form form-group">       
                        <div class="col-sm-12">
                            <label>Select Track To Register</label>
                                <select name="track" class="form form-control">
                                    @foreach($tracks as $track)
                                        <option value="{{$track->track}}"
                                            @if($track->track == $info->course)
                                            selected="selected"
                                            @endif>{{$track->track}}</option>
                                    @endforeach
                                </select>
                        </div>
                    </div>
                    <div class="form form-group">    
                        <div class="col-sm-12">
                            <label>Select Level</label>
                               <select name="level" class="form form-control">
                                    @foreach($levels as $level)
                                    <option value="{{$level->level}}"
                                            @if($status->level == $level->level)
                                            selected="selected"
                                            @endif
                                            >{{$level->level}}</option>
                                    @endforeach
                                </select>
                        </div> 
                    </div>
                    <div class="form form-group">
                        <div class="col-sm-12">
                            <input type="submit" value="Next >> Select Subjects" class="form form-control btn btn-primary">
                        </div>    
                    </div>    
                    
                </form>
            
            @elseif($status->academic_program=="TESDA")
            <form class="form-horizontal" method="POST" action="{{url('dean',array('main','selectsubjecttesda'))}}">    
                {{ csrf_field() }}
                <input type="hidden" name="academic_program" value="{{$status->academic_program}}">
                <input type="hidden" name="idno" value="{{$idno}}">
               <div class="form form-group">       
                        <div class="col-sm-12">
                            <label>Select Course To Register</label>
                                <select name="program_code" class="form form-control">
                                    @foreach($programs as $program)
                                        <option value="{{$program->program_code}}"
                                            @if($program->program_code == $status->program_code)
                                            selected="selected"
                                            @endif>{{$program->program_name}}</option>
                                    @endforeach
                                </select>
                        </div>
                    </div>
                    <div class="form form-group">    
                        <div class="col-sm-12">
                            <label>Select Level</label>
                               <select name="level" class="form form-control">
                                    @foreach($levels as $level)
                                    <option value="{{$level->level}}"
                                            @if($status->level == $level->level)
                                            selected="selected"
                                            @endif
                                            >{{$level->level}}</option>
                                    @endforeach
                                </select>
                        </div> 
                    </div>
                    <div class="form form-group">
                        <div class="col-sm-12">
                            <input type="submit" value="Next >> Select Subjects" class="form form-control btn btn-primary">
                        </div>    
                    </div>    
                    
                </form>
            @endif
            
            </td></tr>        
        @endif
           
    </table>    
  @if($status->status!==-1)
        <div class="row">
            <div class="row bs-wizard" style="border-bottom:0;">
                
                <div
                    @if ($status->status==0) 
                        class="col-xs-3 bs-wizard-step active" 
                    @else
                        class="col-xs-3 bs-wizard-step complete" 
                    @endif
                >
                  <div class="text-center bs-wizard-stepnum">Step 1: Guidance Office</div>
                  <div class="progress"><div class="progress-bar"></div></div>
                  <a href="javascript:void(0)"
                    @if ($status->status==0) 
                        class="bs-wizard-dot-active" 
                    @else
                        class="bs-wizard-dot" 
                    @endif
                ></a>
                  <div class="bs-wizard-info text-center">Take Entrance Exam</div>
                </div>
                
                <div
                    @if ($status->status==1) 
                        class="col-xs-3 bs-wizard-step active" 
                    @elseif ($status->status==2 or $status->status==3 or $status->status==4)
                        class="col-xs-3 bs-wizard-step complete"
                    @else
                        class="col-xs-3 bs-wizard-step"
                    @endif
                >
                  <div class="text-center bs-wizard-stepnum">Step 2: Dean's/Principal's Office</div>
                  <div class="progress"><div class="progress-bar"></div></div>
                  <a href="javascript:void(0)"
                    @if ($status->status==1) 
                        class="bs-wizard-dot-active" 
                    @elseif ($status->status==2 or $status->status==3 or $status->status==4)
                        class="bs-wizard-dot"
                    @else
                        class="bs-wizard-dot"
                    @endif
                ></a>
                  <div class="bs-wizard-info text-center">Assess your Subjects</div>
                </div>
                
                <div
                    @if ($status->status==2) 
                        class="col-xs-3 bs-wizard-step active" 
                    @elseif ($status->status==3 or $status->status==4)
                        class="col-xs-3 bs-wizard-step complete"
                    @else
                        class="col-xs-3 bs-wizard-step"
                    @endif
                >
                  <div class="text-center bs-wizard-stepnum">Step 3: Registrar's Office</div>
                  <div class="progress"><div class="progress-bar"></div></div>
                  <a href="javascript:void(0)"
                    @if ($status->status==2) 
                        class="bs-wizard-dot-active" 
                    @elseif ($status->status==3 or $status->status==4)
                        class="bs-wizard-dot"
                    @else
                        class="bs-wizard-dot"
                    @endif
                ></a>
                  <div class="bs-wizard-info text-center">Assess Payment</div>
                </div>
                
                <div
                    @if ($status->status==3) 
                        class="col-xs-3 bs-wizard-step active" 
                    @elseif ($status->status==4)
                        class="col-xs-3 bs-wizard-step complete"
                    @else
                        class="col-xs-3 bs-wizard-step"
                    @endif
                >
                  <div class="text-center bs-wizard-stepnum">Step 4: Cashier's Office</div>
                  <div class="progress"><div class="progress-bar"></div></div>
                  <a href="javascript:void(0)"
                    @if ($status->status==3) 
                        class="bs-wizard-dot-active" 
                    @elseif ($status->status==4)
                        class="bs-wizard-dot"
                    @else
                        class="bs-wizard-dot"
                    @endif
                ></a>
                  <div class="bs-wizard-info text-center">Go to Cashier for Payment</div>
                </div>
            </div>
        </div>
  @endif
@stop
