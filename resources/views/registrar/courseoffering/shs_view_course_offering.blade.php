@extends('layouts.registrarapp')
@section('content')
<?php
$curriculum_years = \App\Curriculum::distinct()->where('track', $track)->where('is_current', 1)->get(['curriculum_year']);
$levels = \App\Curriculum::distinct()->where('track', $track)->where('is_current', 1)->orderBy('level')->get(['level']);
//$program_name = \App\CtrAcademicProgram::where('program_code', $program_code)->first(['program_name']);
?>

<style>
    .label{color: gray;}
</style>

<div class="row">
    <div class='col-sm-12'>
        <div id="imaginary_container">
            <form class="form-horizontal" role="form">
                {{ csrf_field() }}
                <input type="hidden" id="track" value="{{$track}}">
                <div class="form form-group">
                    <div class="col-sm-12">
                        <h4>Subject Offering</h4>
                        <h4>{{$track}}</h4>
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
                        <select class='form form-control' id="level" onchange="getSection(this.value)">
                            <option value=''>Select Level</option>
                            @foreach($levels as $level)
                            <option value='{{$level->level}}'>{{$level->level}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class='col-sm-3'>
                        <label class='label'>Section</label>
                        <select class='form form-control' id="section" onchange="getList(level.value, curriculum_year.value, '{{$track}}', section.value)">
                            <option value="">Select Section</option>
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
    function getList(level, curriculum_year, track, section){
    $.ajax({
    type: "GET",
            url: "/registrar/ajax/shs/getlist/" + track + "/" + curriculum_year + "/" + level,
            success: function (data) {
            $('#course').html(data);
            }

    });
    getCourseOffered(level, curriculum_year, track, section);
    }

    function getCourseOffered(level, curriculum_year, track, section){
    $.ajax({
    type: "GET",
            url: "/registrar/ajax/shs/getcourseoffered/" + track + "/" + curriculum_year + "/" + level + "/" + section,
            success: function (data) {
            $('#course_offered').html(data);
            }

    });
    }

    function addSubjecttoOffering(curriculum_year, level, section, course_code, track) {
    $.ajax({
    type: "GET",
            url: "/registrar/ajax/shs/getsubject/" + track + "/" + curriculum_year + "/" + level + "/" + section + "/" + course_code,
            success: function (data) {
            $('#course_offered').html(data);
            }

    });
    }

    function removesubject(id) {
    array = {};
    array['id'] = id;
    array['track'] = $("#track").val();
    array['curriculum_year'] = $("#curriculum_year").val();
    array['section'] = $("#section").val();
    array['level'] = $("#level").val();
    if (confirm("Are You Sure To Remove?")) {
    $.ajax({
    type: "GET",
            url: "/registrar/ajax/shs/removesubject/" + id,
            data: array,
            success: function (data) {
            $('#course_offered').html(data);
            }

    });
    }
    }

    function addAllSubjects() {
    array = {};
    array['track'] = $("#track").val();
    array['curriculum_year'] = $("#curriculum_year").val();
    array['section'] = $("#section").val();
    array['level'] = $("#level").val();
    array['course_code'] = $("#course_code").val();
    $.ajax({
    type: "GET",
    url: "/registrar/ajax/shs/addallsubjects",
    data: array,
            success: function (data) {
            $('#course_offered').html(data);
            }

    });
    }
    function getSection(level) {
    array = {};   
    array['track'] = $("#track").val();
        $.ajax({
            type: "GET",
            url: "/registrar/ajax/shs_course_offering/getsection/" + level,
            data: array,
            success: function (data) {
                $('#section').html(data);
            }
        }
        );
    }
</script>
@stop