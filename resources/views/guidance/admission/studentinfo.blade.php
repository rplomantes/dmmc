@extends('layouts.guidanceapp')
@section('content')
<style>
    .label{color: gray;}
</style>
<div class="row">
    <div class="col-sm-12">
        @if ($value==1)
        @foreach ($exams as $exam)
        <div class="alert alert-danger">Entrance exam already scheduled on <b>{{$exam->exam_schedule}}</b></div>
        @endforeach
        @endif
        
        @if(count($dates)<=0)
        <div class="alert alert-danger">No Entrance Exam schedule has been set to the system. Please see administrator.</div>
        @else
        @endif
        
        @if (count($errors) > 0)
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif       
        <form class="form-horizontal" role="form" method="POST" action="{{ url('/guidance', 'schedule_applicant') }}">
            {{ csrf_field() }}
            <div class="form form-group">
                <div class="col-sm-3">
                    <label class="label">Reference Number</label>
                    <b><input type="text" name="idno" class="form form-control" value = '{{$list->idno}}' readonly=""></b>
                </div><div class="col-sm-3">
                    <label class="label">Date Pre-registered</label>
                    <input type="text" class="form form-control" value = '{{ date ('M d, Y', strtotime ($list->created_at))}}' readonly="">
                </div>
                <div class="col-sm-3">
                    <label class="label">Intended Course</label>
                    <input type="text" name="course" class="form form-control" value = '{{$list->course}} @if(($list->major) !== null)Major in {{$list->major}} @else @endif' readonly="">
                </div><div class="col-sm-3">
                    <label class="label">Second Course</label>
                    <input type="text" name="course2" class="form form-control" value = '{{$list->course2}} @if(($list->major2) !== null)Major in {{$list->major2}} @else @endif' readonly="">
                </div>
            </div>
            <div class="form form-group">
                <div class="col-sm-12">
                    <label class="label">Student Name</label>
                </div>
                <div class="col-sm-3">
                    <input type="text" name="firstname" class="form form-control" value = '{{$list->firstname}}' placeholder="First Name">
                </div>
                <div class="col-sm-3">
                    <input type="text" name="middlename" class="form form-control" value = '{{$list->middlename}}' placeholder="Middle Name">
                </div>
                <div class="col-sm-3">
                    <input type="text" name="lastname" class="form form-control" value = '{{$list->lastname}}' placeholder="Last Name">
                </div>
                <div class="col-sm-3">
                    <input type="text" name="extensionname" class="form form-control" value = '{{$list->extensionname}}' placeholder="Extension Name">
                </div>
            </div>
            
            <div class="form form-group">
                    <div class="col-sm-6">
                        <label class="label">Birth Date</label>
                        <input type="date" name="birthdate" class="form form-control" placeholder="yyyy-dd-mm" value='{{$list->birthdate}}'>
                    </div>
                    <div class="col-sm-6">
                        <label class="label">Civil Status</label>
                        <select name="civil_status" class="form form-control">
                            <option value=''></option>
                            <option value="single" <?php if($list->civil_status=='single'){echo "selected=\"selected\""; }?>>Single</option>
                            <option value="married" <?php if($list->civil_status=='married'){echo "selected=\"selected\""; }?>>Married</option>
                            <option value="divorced" <?php if($list->civil_status=='divorced'){echo "selected=\"selected\""; }?>>Divorced</option>
                            <option value="widowed" <?php if($list->civil_status=='widowed'){echo "selected=\"selected\""; }?>>Widowed</option>
                        </select>
                    </div>
                </div>
            
            <div class='form form-group'>
                <div class="col-sm-12">
                    <label class="label">Address</label>
                    <input type="text" name="address" class="form form-control" value = '{{$list->address}}' placeholder="First Name">
                </div>
            </div>
            <div class="form form-group">
                <div class="col-sm-6">
                    <label class="label">Contact Number</label>
                    <input type="text" name="contact_no" class="form form-control" value="{{$list->contact_no}}">
                </div>

                <div class="col-sm-6">
                    <label class="label">Email Address </label>
                    <input type="email" name="email" class="form form-control" value="{{$list->email}}">
                </div>
            </div>    

            <div class="form form-group">
                <div class="col-sm-6">
                    <label class="label">School Last Attended</label>
                    <input type="text" name="last_school_attended" class="form form-control" value="{{$list->last_school}}">
                </div>
                <div class="col-sm-2">
                    <label class="label">Year Graduated</label>
                    <input type="text" name="year_graduated" class="form form-control" value="{{$list->year_graduated}}">
                </div>
                <div class="col-sm-2">
                    <label class="label">General Average</label>
                    <input type="text" name="gen_ave" class="form form-control" value="{{$list->gen_ave}}">
                </div>
                <div class="col-sm-2">
                    <label class="label">Honor Received</label>
                    <input type="text" name="honors_received" class="form form-control" value="{{$list->honor}}">
                </div>        
            </div>
            <div class="form form-group">
                <div class="col-sm-12"><label class="label">If transferee</label></div>
                <div class="col-sm-8">
                    <input type="text" name="name_of_school" class="form form-control" placeholder="Name of School" value="{{$list->school}}">
                </div>
                <div class="col-sm-4">
                    <input type="text" name="prev_course" class="form form-control" placeholder="Course" value="{{$list->prev_course}}">
                </div>
            </div>
            <div class="form form-group">
                <div class="col-sm-12"><label class="label">Entrance Exam Date</label></div>
                @if ($value==0)
                <div class="col-sm-12">
                    <select class='form form-control' name="exam_date" >
                        <option value=''>Choose Entrance Exam Schedule</option>
                        @foreach ($dates as $date)
                        <option value='{{ date ('M d, Y (D) - g:i a', strtotime($date->datetime))}} - {{$date->place}}'>{{$date->datetime}} - {{$date->place}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
                @else
                <div class="col-sm-12">
                    <select class='form form-control' name="exam_date" disabled>
                        <option value=''>Choose Entrance Exam Schedule</option>
                    </select>
                </div>
            </div>
                @endif
                
            <div class="form form-group">
                <div class="col-sm-12">
                    <input type="submit" name="submit" value="Process Admission Exam" class="form form-control btn btn-success">    
                </div>    
            </div>
        </form>
        
    </div>
</div>
@stop
