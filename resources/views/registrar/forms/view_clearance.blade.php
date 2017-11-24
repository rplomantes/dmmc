@extends('layouts.registrarapp')
@section('content')
<style>
    .label{color: gray;}
</style>

<?php
$programs = \App\CtrAcademicProgram::distinct()->where('academic_type', 'College')->orWhere('academic_type', 'TESDA')->get(['program_code', 'program_name']);
$tracks = \App\CtrAcademicProgram::distinct()->where('academic_type', 'Senior High School')->get(['track']);
$levels = \App\CtrAcademicProgram::distinct()->get(['level']);
?>
<div class="row">
    <div class="col-sm-12">
        <div class="row">
            <div class="col-sm-10">
                <h3>Clearance Form</h3>
            </div>
            <div class="col-sm-2">
                <a href="{{url('registrar', array('forms','REGForm01-2011_blank'))}}" target="_blank"><div class="btn btn-danger col-sm-12">Print Blank</div></a>
            </div>
        </div>
        <form class="form-horizontal" method="post" target="_blank" action="{{url('registrar', array('forms', 'REGForm01-2011_bulk'))}}">
            {{ csrf_field() }}
            <div class="form form-group">
                <div class="col-sm-4">
                    <label class="label"> Course/Track:</label>
                    <select class="form-control" name="course" id="course">
                        <option value=''>Select Course/Strand</option>
                        @foreach ($programs as $program)
                        <option value="{{$program->program_code}}">{{$program->program_name}}</option>
                        @endforeach
                        @foreach ($tracks as $track)
                        <option value="{{$track->track}}">{{$track->track}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-sm-3">
                    <label class="label"> Year/Grade:</label>
                    <select class="form-control" name="level" id="level" onchange="selectSection(this.value, course.value)">
                        <option value="">Select Year/Grade</option>
                        @foreach ($levels as $level)
                        <option value="{{$level->level}}">{{$level->level}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-sm-3">
                    <label class="label"> Section:</label>
                    <select class="form-control" name="section" id="section" required="required">
                        <option value="">Select Section</option>
                    </select>
                </div>
                <div class="col-sm-2">
                    <label class="label"> </label>
                    <input type="submit" value="Print All" class="col-sm-12 btn btn-success">
                </div>
            </div>
        </form>
    </div>
</div>
<div class="row">

    <div class="col-sm-12">
        <div id="imaginary_container"> 
            <div class="input-group stylish-input-group">
                <input type="text" id="search" class="form-control"  placeholder="Search Student" >
                <span class="input-group-addon">
                    <span class="fa fa-search"></span>      
                </span>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-12">
        <div id ="displaystudent">
        </div>    
    </div>    
</div>

<!--Ajax Module-->
<script type="text/javascript">
    function selectSection(level, course) {
        $.ajax({
            type: "GET",
            url: "/registrar/ajax/clearance_sections/" + course + "/" + level,
            success: function (data) {
                $('#section').html(data);
            }
        });
    }

    $(document).ready(function () {
        $("#search").keypress(function (e) {
            var theEvent = e || window.event;
            var key = theEvent.keyCode || theEvent.which;
            var array = {};
            array['search'] = $("#search").val();
            if (key == 13) {
                $.ajax({
                    type: "GET",
                    url: "/registrar/ajax/studentclearancelist",
                    data: array,
                    success: function (data) {
                        $("#displaystudent").html(data);
                        $("#search").val("");
                    }
                });
            }
        })
    })
</script>  
@stop
