@extends('layouts.registrarapp')
@section('content')
<style>
    .label{color: gray;}
</style>
<?php

$levels = \App\CourseOffering::distinct()->orderBy('level')->get(['level']);
$sections = \App\CourseOffering::distinct()->orderBy('section')->get(['section']);
?>
<div class="row">
    <div class='col-sm-12'>
        <div id="imaginary_container">
            <h3>Subject Scheduling</h3>
            <div class="form form-group">

                <div class="col-sm-12">
                    <div class="col-sm-6">
                        <label class="label">Select Course</label>
                        <select id="program_code" class="form form-control">
                            <option value="">Select Course</option>
                            @foreach ($program_codes as $program_code)
                            <option value="{{$program_code->program_code}}">{{$program_code->program_code}}</option>
                            @endforeach
                        </select>
                    </div>

                    <input type="hidden" id="school_year" value="{{$school_year->school_year}}">
                    <input type="hidden" id="period" value="{{$school_year->period}}">

                    <div id="yearsection">
                        <div class="col-sm-3">
                            <label class="label">Level</label>
                            <select id="level" class="form form-control">
                                <option value="">Select Level</option>
                                @foreach($levels as $level)
                                <option value='{{$level->level}}'>{{$level->level}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-sm-3">
                            <label class="label">Section</label>
                            <select id="section" class="form form-control" onchange="getyearsection(program_code.value)">
                                <option value="">Select Section</option>
                                @foreach($sections as $section)
                                <option value='{{$section->section}}'>{{$section->section}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-12" id="courses">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<script>
    function getyearsection(program_code) {
        array = {};
        array['school_year'] = $("#school_year").val();
        array['period'] = $("#period").val();
        array['section'] = $("#level").val();
        array['level'] = $("#section").val();
        $.ajax({
            type: "GET",
            url: "/registrar/ajax/tesda/getyearsection/" + program_code,
            data: array,
            success: function (data) {
                $('#courses').html(data);
            }

        });
    }
</script>
@stop