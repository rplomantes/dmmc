@extends('layouts.guidanceapp')
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
<div class="row">
    <div class="col-sm-12">

        <h3>Student Information</h3>
        <table class='table table-condensed'>
            <tr>
                <td>ID No</td>
                <td><b>{{$list->idno}}</b></td>
            </tr>
            <tr>
                <td>Date Pre-registered</td>
                <td>{{ date ('M d, Y', strtotime ($list->created_at))}}</td>
            </tr>
            <tr>
                <td>Name</td>
                <td>{{$list->firstname}} {{$list->middlename}} {{$list->lastname}} {{$list->extensionname}}</td>
            </tr>
            <tr>
                <td>Address</td>
                <td>{{$list->street}} {{$list->barangay}} {{$list->municipality}} {{$list->province}} {{$list->zip}}</td>
            </tr>
            <tr>
                <td>Birth Date</td>
                <td>{{$list->birthdate}}</td>
            </tr>
            <tr>
                <td>Gender</td>
                <td>{{$list->gender}}</td>
            </tr>
            <tr>
                <td>Civil Status</td>
                <td>{{$list->civil_status}}</td>
            </tr>
            <tr>
                <td>Contact Number</td>
                <td>{{$list->contact_no}}</td>
            </tr>
            <tr>
                <td>Email Address</td>
                <td>{{$list->email}}</td>
            </tr>
            <tr>
                <td>School Last Attended</td>
                <td>{{$list->last_school}}</td>
            </tr>
            <tr>
                <td>Year Graduated</td>
                <td>{{$list->year_graduated}}</td>
            </tr>
            <tr>
                <td>General Average</td>
                <td>{{$list->gen_ave}}</td>
            </tr>
            <tr>
                <td>Honor Received</td>
                <td>{{$list->honor}}</td>
            </tr>
            <tr>
                <td width="40%">If transferee</td>
                <td>School - {{$list->school}} <br>Course - {{$list->prev_course}}</td>
            </tr>

        </table>
        @if ($list->academic_type == 'College')
        <h3>Course</h3>
        <table class='table'>
            <tr>
                <td width="40%">Intended Course to Enroll</td>
                <td>{{$list->course}}</td>
            </tr>
            <tr>
                <td>Second Choice</td>
                <td>{{$list->course2}}</td>
            </tr>
        </table>
        @elseif ($list->academic_type=='Senior High School')
        <h3>Senior High School</h3>
        <table class='table'>
            <tr>
                <td width="40%">Intended Strand to Enroll</td>
                <td>{{$list->course}}</td>
            </tr>
            <tr>
                <td>Second Choice</td>
                <td>{{$list->course2}}</td>
            </tr>
        </table>
        @else
        <!--<div class='alert alert-danger'>No Department yet has been set to the Applicant. Please see administrator.</div>-->
        @endif
        
        <?php
        $status = \App\Status::where('idno', $list->idno)->first();
        ?>
        
        @if ($value==1)
        <h3>Entrance Exam</h3>
        <table class='table'>
            <tr>
                <td width="40%">Entrance Exam Schedule</td>
                <td>{{ date ('M d, Y (D) - g:i A', strtotime($exam->datetime))}} - {{$exam->place}}</td>
            </tr>
            <tr>
                <td>Entrance Exam Result</td>
                <td>{{$exam->exam_result}}</td>
            </tr>
        </table>
            @if ($status->status==0)
            <table class="table-condensed col-sm-12">
                <tr>
                    <td class="col-sm-6"><a href="{{url('guidance',array('viewmodifyinfo',$list->idno))}}"><div class='btn btn-primary col-sm-12'>Modify</div></a></td>
                    <td class="col-sm-6"><a href="{{url('guidance',array('admission_slip',$list->idno))}}" target="_blank"><div class='btn btn-success col-sm-12'>Print Entrance Exam Slip</div></a></td>
                </tr>
            </table>
            @elseif ($status->status==1)
            <a href="{{url('guidance',array('viewmodifyinfo',$list->idno))}}"><div class='btn btn-primary col-sm-12'>Modify</div></a>

            @elseif ($status->status==-1)
            <div class="alert alert-danger">Sorry you have failed the Entrance Exam!!!</div>
            <a href="{{url('guidance',array('viewmodifyinfo',$list->idno))}}"><div class='btn btn-primary col-sm-12'>Modify</div></a>
            @elseif ($status->status==2)

            @endif
        @else
        
            @if ($status->status==1)
            <a href="{{url('guidance',array('viewmodifyinfo',$list->idno))}}"><div class='btn btn-primary col-sm-12'>Modify</div></a> 
            @endif
            <table class="table-condensed col-sm-12">
                <tr>
                    <td class="col-sm-6"><a href="{{url('guidance',array('viewmodifyinfo',$list->idno))}}"><div class='btn btn-primary col-sm-12'>Modify</div></a></td>
                    <td class="col-sm-6"><a href="{{url('guidance',array('schedule_applicant',$list->idno))}}"><div class='btn btn-success col-sm-12'>Schedule Entrance Exam</div></a></td>
                </tr>
            </table>
        @endif
        
        @if($status->status!==-1)
        <br>
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
