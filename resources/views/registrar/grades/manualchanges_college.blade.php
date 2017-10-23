@extends('layouts.registrarapp')
@section('content')
<?php
$instructors = \App\User::where('accesslevel', 10)->get();
?>
<style>
    .label{color: gray;}
</style>
<div class="row">
    <div class="col-sm-12">
        <h3>Manual Changing of Grades - COLLEGE/TESDA</h3>
        <form class="form-horizontal" action="{{url('/')}}" method="POST">
            {{ csrf_field() }}
            <div class="form form-group">
                <div class="col-sm-4">
                    <label class="label">Instructor</label>
                    <select class="form form-control" name="instructor" id="instructor">
                        <option value="">Select Instructor</option>
                        @foreach ($instructors as $instructor)
                        <option value="{{$instructor->id}}">{{$instructor->lastname}}, {{$instructor->firstname}} {{$instructor->extensionname}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-sm-4">
                    <label class="label">School Year</label>
                    <select class="form form-control" name="school_year" id="school_year">
                        <option value="">Select School Year</option>
                        <option value="2017">2017</option>
                    </select>
                </div>
                <div class="col-sm-4">
                    <label class="label">Period</label>
                    <select class="form form-control" name="period" id="period" onchange="displayclassess(instructor.value)">
                        <option value="">Select Period</option>
                        <option value="1st">1st Semester</option>
                        <option value="2nd">2nd Semester</option>
                        <option value="summer">Summer</option>
                    </select>
                </div>
            </div>
        </form>
    </div>
    <div class="col-sm-12" id="listcourses">
    </div>
</div>
<script>
    function displayclassess(instructor) {
        array = {};
        array['period'] = $("#period").val();
        array['school_year'] = $("#school_year").val();
        $.ajax({
            type: "GET",
            url: "/ajax/manualchange_college/displaysubjects/" + instructor,
            data: array,
            success: function (data) {
               $('#listcourses').html(data);
            }

        });
    }
</script>
@stop