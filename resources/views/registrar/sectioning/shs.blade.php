@extends('layouts.registrarapp')
@section('content')

<?php
$levels = \App\CtrAcademicProgram::distinct()->where('academic_type', "Senior High School")->get(['level']);
$tracks = \App\CtrAcademicProgram::distinct()->where('academic_type', "Senior High School")->get(['track']);
$advisers = \App\User::where('accesslevel', 10)->get();
?>
<style>
    .label{color: gray;}
</style>

<div class="row">
    <div class='col-sm-12'>
        <div id="imaginary_container">
            <form class="form-horizontal">
                <div class="form form-group">
                    <div class="col-sm-3">
                        <label class="label">Level</label>
                        <select class="form form-control" id="level" name="level">
                            <option value="">Select Level</option>
                            @foreach ($levels as $level)
                            <option value="{{$level->level}}">{{$level->level}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-sm-3">
                        <label class="label">Strand</label>
                        <select class="form form-control" id="track" name="track" onchange="getSection(level.value, this.value); getStudentList(level.value, this.value)">
                            <option value="">Select Strand</option>
                            @foreach ($tracks as $track)
                            <option value="{{$track->track}}">{{$track->track}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-sm-3">
                        <label class="label">Section</label>
                        <select class="form form-control" id="section" name="section" onchange="getSectionList(this.value, level.value)">
                            <option>Select Section</option>
                        </select>
                    </div>
                    <div class="col-sm-3">
                        <label class="label">Class Adviser</label>
                        <select class="form form-control" id="adviser" name="adviser" onchange="assignAdviser(this.value)">
                            <option value="">Select Adviser</option>
                            @foreach ($advisers as $adviser)
                            <option value="{{$adviser->idno}}">{{$adviser->lastname}}, {{$adviser->firstname}} {{$adviser->middlename}} {{$adviser->extensionname}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </form>
            <div id="studentList" class="col-sm-6">
            
            </div>
            <div id="sectionlist" class="col-sm-6">
            
            </div>
        </div>
    </div>
</div>
<script>
    function getSection(level, track) {
        $.ajax({
            type: "GET",
            url: "/ajax/sectioning_shs/" + level + "/" + track,
            success: function (data) {
                $('#section').html(data);
            }
        }
        );
    }
    function getStudentList(level, track) {
        $.ajax({
            type: "GET",
            url: "/ajax/sectioning_list/" + level + "/" + track,
            success: function (data) {
                $('#studentList').html(data);
            }
        }
        );
    }
    function getSectionList(section, level){
        $.ajax({
            type: "GET",
            url: "/ajax/sectioning_sectioninglist/" + section + "/" + level,
            success: function (data) {
                $('#sectionlist').html(data);
            }
        }
        );
    }
    function addtosection(idno, level, track){
        array = {};
        array['section'] = $("#section").val();
        array['level'] = $("#level").val();
        array['track'] = $("#track").val();
        $.ajax({
            type: "GET",
            url: "/ajax/sectioning/addtosection/" + idno,
            data: array,
            success: function(data) {
                $('#sectionlist').html(data);
            }
        });
        getStudentList(level, track);
    }
    function removetosection(idno, level, track){
        array = {};
        array['section'] = $("#section").val();
        array['level'] = $("#level").val();
        array['track'] = $("#track").val();
        $.ajax({
            type: "GET",
            url: "/ajax/sectioning/removetosection/" + idno,
            data: array,
            success: function(data) {
                $('#sectionlist').html(data);
            }
        });
        getStudentList(level, track);
    }
    function assignAdviser(adviser){
        array = {};
        array['section'] = $("#section").val();
        array['level'] = $("#level").val();
        array['track'] = $("#track").val();
        $.ajax({
            type: "GET",
            url: "/ajax/sectioning/assignadviser/" + adviser,
            data: array,
            success: function(data) {
            }
        });
    }
</script>
@stop