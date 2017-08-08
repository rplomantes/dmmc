@extends('layouts.registrarapp')
@section('content')
<style>
    .label{color: gray;}
</style>

<div class="row">
    <div class='col-sm-12'>
        <div id="imaginary_container">
            <h3>Instructor's Profile</h3>
            <table class="table table-condensed">
                <tr>
                    <td class="col-sm-4">ID Number:</td>
                    <td class="col-sm-8">{{$instructor->idno}}</td>
                </tr>
                <tr>
                    <td>Name:</td>
                    <td>{{$instructor->firstname}} {{$instructor->middlename}} {{$instructor->lastname}} {{$instructor->extensionname}}</td>
                </tr>
                <tr>
                    <td>Email:</td>
                    <td>{{$instructor->email}}</td>
                </tr>
                <tr>
                    <td colspan="2">
                        
            <?php
            $user = \App\User::where('id', $instructor->id)->first();
            $school_year = \App\CtrSchoolYear::where('academic_type', 'College')->first();
            $loads = \App\CourseOffering::where('instructor_id', $user->id)->where('school_year', $school_year->school_year)->where('period', $school_year->period)->get();

            $courses = \App\CourseOffering::distinct()->where('school_year', $school_year->school_year)->where('period', $school_year->period)->get(['program_code']);
            ?>

            Subject Load:
            @if (count($loads)>0)
            <table class="table table-condensed">
                <thead>
                <th class="col-sm-2">Subject Code</th>
                <th class="col-sm-4">Section</th>
                <th class="col-sm-3">Schedule</th>
                <th class="col-sm-3">Room</th>
                </thead>
                <tbody>
                    @foreach($loads as $load)
                    <tr>
                        <td>
                            <?php
                            $schedules = \App\Schedule::where('course_offering_id', $load->id)->get();
                            ?>
                            @if ($load->program_code=='Senior High School')
                            {{$load->course_name}}
                            @else
                            {{$load->course_code}}
                            @endif

                        </td>
                        <td>
                            @if ($load->program_code=='Senior High School')
                            {{$load->track}} - {{$load->level}} - {{$load->section}}
                            @else 
                            {{$load->program_code}} - {{$load->level}} year - section {{$load->section}}
                            @endif
                        </td>
                        <td>
                            <?php
                            $schedule2s = \App\Schedule::distinct()->where('course_offering_id', $load->id)->get(['time_start', 'time_end', 'room']);
                            ?>
                            @foreach ($schedule2s as $schedule2)
                            <?php
                            $days = \App\Schedule::where('course_offering_id', $load->id)->where('time_start', $schedule2->time_start)->where('time_end', $schedule2->time_end)->where('room', $schedule2->room)->get(['day']);
                            ?>
                            @foreach ($days as $day){{$day->day}}@endforeach {{date('g:i A', strtotime($schedule2->time_start))}} - {{date('g:i A', strtotime($schedule2->time_end))}} <br>
                            <!--{{$schedule2->day}} {{$schedule2->time_start}} - {{$schedule2->time_end}}<br>-->
                            @endforeach
                        </td>
                        <td>
                            <?php
                            $schedule3s = \App\Schedule::distinct()->where('course_offering_id', $load->id)->get(['time_start', 'time_end', 'room']);
                            ?>
                            @foreach ($schedule3s as $schedule3)
                            {{$schedule3->room}}<br>
                            @endforeach
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @else
            <br><div class="alert alert-danger">No Subject Loaded!!</div>
            @endif
                    </td>
                </tr>
                <tr>
                    <td><a href="{{url('registrar', array('assign_instructor', 'modify_shs', $instructor->id))}}"><div class="col-sm-12 btn btn-success">Modify</div></a></td>
                    <td><a href="{{url('registrar', array('assign_instructor', 'loadsubjects_shs', $instructor->id))}}"><div class="col-sm-12 btn btn-primary">Load Subjects</div></a></td>
                </tr>
            </table>
        </div>
    </div>
</div>
@stop