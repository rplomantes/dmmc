@extends('layouts.registrarapp')
@section('content')

<?php
$levels = \App\CtrAcademicProgram::distinct()->where('academic_type', "Senior High School")->get(['level']);
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
                        <select class="form form-control" name="level" onchange="getSection(this.value); getStudentList(this.value)">
                            <option value="">Select Level</option>
                            @foreach ($levels as $level)
                            <option value="{{$level->level}}">{{$level->level}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-sm-3">
                        <label class="label">Section</label>
                        <select class="form form-control" id="section">
                            <option>Select Section</option>
                        </select>
                    </div>
                    <div class="col-sm-5">
                        <label class="label">Adviser</label>
                        <select class="form form-control">
                            <option>Select Adviser</option>
                        </select>
                    </div>
                </div>
            </form>
            <div id="studentList" class="col-sm-6">
            
            </div>
            <div class="col-sm-6">
            Hello
            </div>
        </div>
    </div>
</div>
<script>
    function getSection(level) {
        $.ajax({
            type: "GET",
            url: "/ajax/sectioning_shs/" + level,
            success: function (data) {
                $('#section').html(data);
            }
        }
        );
    }
    function getStudentList(level) {
        $.ajax({
            type: "GET",
            url: "/ajax/sectioning_list/" + level,
            success: function (data) {
                $('#studentList').html(data);
            }
        }
        );
    }
</script>
@stop