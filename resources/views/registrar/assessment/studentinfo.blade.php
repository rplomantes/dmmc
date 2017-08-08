@extends('layouts.registrarapp')
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
$user = \App\User::where('idno', $idno)->first();
$student_info = \App\StudentInfo::where('idno', $idno)->first();
?>
<div class="row">
    <div class="col-sm-12">

        <h3>Student Information</h3>
        <table class='table table-condensed'>
            <tr>
                <td>ID No</td>
                <td><b>{{$idno}}</b></td>
            </tr>
            <tr>
                <td>Name</td>
                <td>{{$user->firstname}} {{$user->middlename}} {{$user->lastname}} {{$user->extensionname}}</td>
            </tr>
            <tr>
                <td>Address</td>
                <td>{{$student_info->address}}</td>
            </tr>
            <tr>
                <td>Birth Date</td>
                <td>{{$student_info->birthdate}}</td>
            </tr>
            <tr>
                <td>Civil Status</td>
                <td>{{$student_info->civil_status}}</td>
            </tr>
            <tr>
                <td>Contact Number</td>
                <td>{{$student_info->contact_no}}</td>
            </tr>
            <tr>
                <td>Email Address</td>
                <td>{{$user->email}}</td>
            </tr>
            <tr>
                @if ($status->academic_type!=="Senior High School")
                <td>Course</td>
                <td>{{$status->program_name}}</td>
                @else
                <td>Strand</td>
                <td>{{$status->track}}</td>
                @endif
            </tr>

        </table>
        
        @if ($status->status==2)
        <a href="{{url('registrar',array('assessment_of_payment',$idno))}}"><div class='btn btn-primary col-sm-12'>Assess Payment</div></a>
        <br>
        @elseif ($status->status=1)
        <a href="{{url('registrar',array('assessment_of_subject',$idno))}}"><div class='btn btn-primary col-sm-12'>Assess Subject</div></a>
        <br>
        @endif
               
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
    </div>
</div>
@stop
