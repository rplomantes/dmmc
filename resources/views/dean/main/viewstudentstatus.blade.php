@extends('layouts.deanapp')
@section('content')
<?php
$user = \App\User::where('idno',$idno)->first();
$info = \App\StudentInfo::where('idno',$idno)->first();
$status = \App\Status::where('idno',$idno)->first();
$academic_program = $status->academic_program;
$programs = \Illuminate\Support\Facades\DB::Select("Select distinct program_code, program_name from ctr_academic_programs where academic_program = '$academic_program'");
$levels = \Illuminate\Support\Facades\DB::Select("Select level from ctr_academic_programs where program_code = '" . $info->course . "'");
?>

    <table class="table table-condensed">
        <tr><td>Reference No</td><td><span class = "label label-danger">{{$idno}}</span></td></tr>
            <tr><td>Student Name</td><td><strong>{{$user->lastname}}, {{$user->firstname}} {{$user->middlename}} {{$user->extensionname}}</strong></td></tr>
                <tr><td>Contact Number</td><td>{{$info->contact_no}}</td></tr>
                    <tr><td>Email Address</td><td>{{$user->email}}</td></tr>
                        <tr><td>Course Intended To Enroll</td><td>{{$info->course}}</td></tr>
                            <tr><td>Second Course of Choice</td><td>{{$info->course2}}</td></tr>
        @if($status->status==0)
            <tr><td colspan="2" align="center"><h3 class="label-danger" style="color:#ffffff;padding:10px">Please See Guidance for Entrance Exam</h3></td></tr>
        @elseif($status->status==1)
            <tr><td colspan="2">
                
            @if($status->academic_program=="CBEAS" OR $status->academic_program=="CAMPS" )    
                <form class="form-horizontal" method="POST" action="{{url('dean',array('main','selectsubject'))}}">    
                {{ csrf_field() }}
                <input type="hidden" name="academic_program" value="{{$status->academic_program}}">
                    <div class="form form-group">       
                        <div class="col-sm-12">
                            <label>Select Course To Register</label>
                                <select name="program_code" class="form form-control">
                                    @foreach($programs as $program)
                                        <option value="{{$program->program_code}}"
                                            @if($program->program_code == $info->course)
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
                                    <option value="{{$level->level}}">{{$level->level}}</option>
                                    @endforeach
                                </select>
                        </div> 
                    </div>
                    <div class="form form-group">
                        <div class="col-sm-12">
                            <input type="submit" value="Select Subjects>>" class="form form-control btn btn-primary">
                        </div>    
                    </div>    
                    
                </form>
            @elseif($status->academic_program=="Senior High School")
            @elseif($status->academic_program=="TESDA")
            @endif
            
            </td></tr>        
        @endif
           
    </table>    
  
@stop