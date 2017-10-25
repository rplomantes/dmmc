@extends('layouts.registrarapp')
@section('content')
<style>
    .label{color: gray;}
</style>
<?php
$student = \App\User::where('idno', $idno)->first();
?>
<div class="row">
    <div class='col-sm-12'>
        <div class="form-group">
            <ul class="nav navbar-header">
                <li>Student ID : {{$student->idno}}</li>
                <li><b>Student Name : {{strtoupper($student->lastname)}}, {{$student->firstname}}</b></li>
                @if($status->academic_type=="Senior High School")
                <li>Grade/Section : {{$status->level}} - {{$status->section}}<li>
                    @else
                <li>Course/Level : {{$status->program_code}} - {{$status->level}}
                    @endif
            </ul>
        </div>
    </div>
</div>
<hr>
<div class="row">
    <div class="col-sm-12">
        @foreach ($levels as $level)
        <table class="table table-bordered">
            <?php $periods = \App\GradeShs::distinct()->where('idno', $idno)->where('level', $level->level)->get(['period']); ?>
            <tr><th>{{$level->level}}</th><th></th><th></th><th></th><th></th><th></th></tr>    
            @foreach ($periods as $period)
            <tr><th>{{$period->period}} Semester</th><th>1st Quarter</th><th>2nd Quarter</th><th>Final Grade</th><th>Grade Point</th><th>Remarks</th></tr>
            <?php $courses = \App\GradeShs::where('idno', $idno)->where('level', $level->level)->where('period', $period->period)->get(); ?>
            @foreach ($courses as $course)
            <tr><td>{{$course->course_name}}</td><td>{{$course->first_qtr}}</td><td>{{$course->second_qtr}}</td><td>{{$course->final_grade}}</td><td>{{$course->grade_point}}</td><td>{{$course->remarks}}</td></tr>
            @endforeach
            @endforeach
        </table>
        @endforeach
    </div>
</div>

@stop
