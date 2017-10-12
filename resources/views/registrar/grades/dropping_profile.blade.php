@extends('layouts.registrarapp')
@section('content')
<style>
    .label{color: gray;}
</style>
<?php
$student = \App\User::where('idno', $idno)->first();
$status = \App\Status::where('idno', $idno)->first();
$student_info = \App\StudentInfo::where('idno', $idno)->first();
$school_year = \App\CtrSchoolYear::where('academic_type', $status->academic_type)->first();
$courses = \App\GradeCollege::where('idno', $idno)->where('school_year', $school_year->school_year)->where('period', $school_year->period)->get();
$course_offerings = \App\CourseOffering::where('program_code', $status->program_code)->where('school_year', $school_year->school_year)->where('period', $school_year->period)->get();
?>
{{ csrf_field() }}
<input type="hidden" value="{{$idno}}" id="idno" name="idno">
<input type="hidden" value="{{$school_year->school_year}}" id="school_year" name="school_year">
<input type="hidden" value="{{$school_year->period}}" id="period" name="period">
<input type="hidden" value="{{$status->program_code}}" id="program_code" name="program_code">

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
    <div class="col-sm-6" id='courses'>
        Subjects:
        <table class="table table-condensed table-striped">
            <thead>
                <tr>
                    <th>Subject Code</th>
                    <th>Subject Name</th>
                    <th>Section</th>
                    <th>Drop</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($courses as $course)
                <?php $section = \App\CourseOffering::where('id', $course->course_offering_id)->first(); ?>
                <tr>
                    <td>{{$course->course_code}}</td>
                    <td>{{$course->course_name}}</td>
                    <td>{{$section->section}}</td>
                    <td>
                        @if ($course->is_drop == 0)
                        <a href="javascript:void(0)" onclick="dropcourse('{{$course->course_offering_id}}')">Drop</a>
                        @else
                        Dropped
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="col-sm-6">
        Subjects Offered:
        <table class="table table-condensed table-striped">
            <thead>
                <tr>
                    <th>Subject Code</th>
                    <th>Subject Name</th>
                    <th>Section</th>
                    <th>Add</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($course_offerings as $course_offering)
                <tr>
                    <td>{{$course_offering->course_code}}</td>
                    <td>{{$course_offering->course_name}}</td>
                    <td>{{$course_offering->section}}</td>
                    <td><a href="javascript:void(0)" onclick="addtocourse('{{$course_offering->id}}')">Add</a></td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<script>
    function addtocourse(id) {
    array = {};
    array['school_year'] = $("#school_year").val();
    array['period'] = $("#period").val();
    array['idno'] = $("#idno").val();
    array['program_code'] = $("#program_code").val();
    if (confirm("Are you sure to add this subject?")){
    $.ajax({
    type: "GET",
            url: "/registrar/ajax/adding_course/" + id,
            data: array,
            success: function (data) {
            $('#courses').html(data);
            }

    });
    }
    }
    function dropcourse(id) {
    array = {};
    array['school_year'] = $("#school_year").val();
    array['period'] = $("#period").val();
    array['idno'] = $("#idno").val();
    array['program_code'] = $("#program_code").val();
    if (confirm("Are you sure to drop this subject?")){
    $.ajax({
    type: "GET",
            url: "/registrar/ajax/drop_course/" + id,
            data: array,
            success: function (data) {
            $('#courses').html(data);
            }

    });
    }
    }
</script>
@stop