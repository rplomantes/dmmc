@extends('layouts.registrarapp')
@section('content')
<?php
$curriculum_years = \App\Curriculum::distinct()->where('program_code', $program_code)->where('is_current', 1)->get(['curriculum_year']);
$program_name = \App\CtrAcademicProgram::where('program_code', $program_code)->first(['program_name']);
?>

<style>
    .label{color: gray;}
</style>

<div class="row">
    <div class='col-sm-12'>
        <div id="imaginary_container">
            <form class="form-horizontal" role="form">
                {{ csrf_field() }}
                <input type="hidden" id="program_code" value="{{$program_code}}">
                <div class="form form-group">
                    <div class="col-sm-12">
                        <h4>Subject Offering</h4>
                        <h4>{{$program_name->program_name}}</h4>
                    </div>
                </div>
                <div class='form-group'>
                    <div class='col-sm-3'>
                        <label class='label'>Curriculum Year</label>
                        <select class='form form-control' id="curriculum_year">
                            <option value=''>Select Curriculum Year</option>
                            @foreach($curriculum_years as $curriculum_year)
                            <option value='{{$curriculum_year->curriculum_year}}'>{{$curriculum_year->curriculum_year}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class='col-sm-3'>
                        <label class='label'>Level</label>
                        <select class='form form-control' id="level">
                            <option value=''>Select Level</option>
                            <option value='1st'>1st</option>
                            <option value='2nd'>2nd</option>
                            <option value='3rd'>3rd</option>
                            <option value='4th'>4th</option>
                            <option value='5th'>5th</option>
                        </select>
                    </div>
                    <div class='col-sm-3'>
                        <label class='label'>Period</label>
                        <select class='form form-control' id="period">
                            <option value=''>Select Period</option>
                            <option value='1st'>1st Semester</option>
                            <option value='2nd'>2nd Semester</option>
                            <option value='Summer'>Summer</option>
                        </select>
                    </div>
                    <div class='col-sm-3'>
                        <label class='label'>Section</label>
                        <select class='form form-control' id="section" onchange="getList(level.value, period.value, curriculum_year.value, '{{$program_code}}', section.value)">
                            <option value="">Select Section</option>
                            <option value='1'>Section 1</option>
                            <option value='2'>Section 2</option>
                            <option value='3'>Section 3</option>
                            <option value='4'>Section 4</option>
                        </select>
                    </div>
                </div>
                <div class='form-group'>
                    <div class='col-sm-6' id='course'>
                    </div>
                    <div class='col-sm-6' id='course_offered'>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    function getList(level, period, curriculum_year, program_code, section){
    $.ajax({
    type: "GET",
            url: "/registrar/ajax/getlist/" + program_code + "/" + curriculum_year + "/" + period + "/" + level,
            success: function (data) {
            $('#course').html(data);
            }

    });
    getCourseOffered(level, period, curriculum_year, program_code, section);
    }

    function getCourseOffered(level, period, curriculum_year, program_code, section){
    $.ajax({
    type: "GET",
            url: "/registrar/ajax/getcourseoffered/" + program_code + "/" + curriculum_year + "/" + period + "/" + level + "/" + section,
            success: function (data) {
            $('#course_offered').html(data);
            }

    });
    }

    function addSubjecttoOffering(curriculum_year, level, period, section, course_code, program_code) {
    $.ajax({
    type: "GET",
            url: "/registrar/ajax/getsubject/" + program_code + "/" + curriculum_year + "/" + period + "/" + level + "/" + section + "/" + course_code,
            success: function (data) {
            $('#course_offered').html(data);
            }

    });
    }

    function removesubject(id) {
    array = {};
    array['id'] = id;
    array['program_code'] = $("#program_code").val();
    array['curriculum_year'] = $("#curriculum_year").val();
    array['section'] = $("#section").val();
    array['level'] = $("#level").val();
    array['period'] = $("#period").val();
    if (confirm("Are You Sure To Remove?")) {
    $.ajax({
    type: "GET",
            url: "/registrar/ajax/removesubject/" + id,
            data: array,
            success: function (data) {
            $('#course_offered').html(data);
            }

    });
    }
    }

    function addAllSubjects() {
    array = {};
    array['program_code'] = $("#program_code").val();
    array['curriculum_year'] = $("#curriculum_year").val();
    array['section'] = $("#section").val();
    array['level'] = $("#level").val();
    array['period'] = $("#period").val();
    array['course_code'] = $("#course_code").val();
    $.ajax({
    type: "GET",
    url: "/registrar/ajax/addallsubjects",
    data: array,
            success: function (data) {
            $('#course_offered').html(data);
            }

    });
    }
</script>
@stop