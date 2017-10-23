@extends('layouts.registrarapp')
@section('content')
<style>
    .label{color: gray;}
</style>
<?php
    $school_year = \App\CtrGradeSchoolYear::where('academic_type', 'Senior High School')->first();
?>
<div class="row">
    <div class='col-sm-12'>
        <div id="imaginary_container">
            <h3>{{$course_offering->track}}</h3>
            <h3>{{$course_offering->course_name}}</h3>
            <h4>{{$course_offering->level}} - @if ($course_offering->period== '1st') 1st Semester @elseif ($course_offering->period== '2nd') 2nd Semester @elseif ($course_offering->period== 'Summer') Summer @else @endif</h4>
            <h4>Section: {{$course_offering->section}}</h4>

            <input type="hidden" id="school_year" value="{{$school_year->school_year}}">
            <input type="hidden" id="period" value="{{$school_year->period}}">
            <input type="hidden" id="course_id" value="{{$course_offering->id}}">

            <!--Top-->
            <div class="col-sm-3">
                <label class="label">Room</label>
                <input id="room" class="form form-control">
            </div>

            <!--            <div class="col-sm-3">
                            <label class="label">Day</label>
                            <input id="day" class="form form-control">
                        </div>-->

            <div class="col-sm-2">
                <label class="label">Day</label>
                <select id="day" class="form form-control" >
                    <option value="">Select Day</option>
                    <option value="M">Mon</option>
                    <option value="T">Tue</option>
                    <option value="W">Wed</option>
                    <option value="Th">Thur</option>
                    <option value="F">Fri</option>
                    <option value="Sa">Sat</option>
                    <option value="Su">Sun</option>
                </select>
            </div>
            <div class="col-sm-2">
                <label class="label">Time Start</label>
                <input id="time_start" class="form form-control" placeholder="24 hour format">
            </div>
            <div class="col-sm-2">
                <label class="label">Time End</label>
                <input id="time_end" class="form form-control" placeholder="24 hour format">
            </div>
            <div class="col-sm-3">
                <label class="label"><br></label>
                <input type="submit" value="Add" class="col-sm-6 btn btn-info" onclick="addschedule()">
            </div>


            <!--left side-->
            <div class="col-sm-6">
                <h4>Subject Schedule</h4>
                <div id="popSched">
                    <table class="table table-condensed">
                        <thead>
                        <th class="col-sm-4">Room</th>
                        <th class="col-sm-2">Day</th>
                        <th class="col-sm-3">Start</th>
                        <th class="col-sm-3">End</th>
                        <th class="col-sm-1">Delete</th>
                        </thead>
                        <tbody>
                            @foreach ($schedules as $schedule)
                            <tr>
                                <td><input onchange="changeroom('{{$schedule->id}}', this.value)" type="text" class="form form-control" value="{{$schedule->room}}"></td>
                                <!--<td><input onchange="changeday('{{$schedule->id}}', this.value)" id="day" type="text" class="form form-control" value="{{$schedule->day}}"></td>-->
                                <td>
                                    <select onchange="changeday('{{$schedule->id}}', this.value)"class="form form-control">
                                        <option value="">Select Day</option>
                                        <option value="M" @if ($schedule->day==='M') selected="selected" @endif>Mon</option>
                                        <option value="T" @if ($schedule->day==='T') selected="selected" @endif>Tue</option>
                                        <option value="W" @if ($schedule->day==='W') selected="selected" @endif>Wed</option>
                                        <option value="Th" @if ($schedule->day==='Th') selected="selected" @endif>Thur</option>
                                        <option value="F" @if ($schedule->day==='F') selected="selected" @endif>Fri</option>
                                        <option value="Sa" @if ($schedule->day==='Sa') selected="selected" @endif>Sat</option>
                                        <option value="Su" @if ($schedule->day==='Su') selected="selected" @endif>Sun</option>
                                    </select>
                                </td>
                                <td><input onchange="changetime_start('{{$schedule->id}}', this.value)" type="text" class="form form-control" value="{{$schedule->time_start}}"></td>
                                <td><input onchange="changetime_end('{{$schedule->id}}', this.value)" type="text" class="form form-control" value="{{$schedule->time_end}}"></td>
                                <td><div class="col-sm-12 btn btn-danger" onclick="deletesched('{{$schedule->id}}')">Delete</div></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!--Right Side-->
            <div class="col-sm-6">
                <h4>Room Directory</h4>
                <label class="label">Room</label>
                <input id="room2" class="form form-control" onchange="getexistingsched(this.value)">
                <div id='showsched'>

                </div>
            </div>
        </div>
    </div>
</div>
<script>
    function getexistingsched(room2) {
    array = {};
    array['school_year'] = $("#school_year").val();
    array['period'] = $("#period").val();
    array['section'] = $("#level").val();
    array['level'] = $("#section").val();
    $.ajax({
    type: "GET",
            url: "/registrar/ajax/getexistingsched_shs/" + room2,
            data: array,
            success: function (data) {
            $('#showsched').html(data);
            }

    });
    }

    function changeroom(sched_id, value) {
    array = {};
    array['school_year'] = $("#school_year").val();
    array['period'] = $("#period").val();
    array['room'] = $("#room2").val();
    $.ajax({
    type: "GET",
            url: "/registrar/ajax/changeroom_shs/" + sched_id + "/" + value,
            data:array,
            success: function (data) {
            $('#showsched').html(data);
            }
    });
    }

    function changeday(sched_id, value) {
    array = {};
    array['school_year'] = $("#school_year").val();
    array['period'] = $("#period").val();
    array['room'] = $("#room2").val();
    $.ajax({
    type: "GET",
            url: "/registrar/ajax/changeday_shs/" + sched_id + "/" + value,
            data:array,
            success: function (data) {
            $('#showsched').html(data);
            }
    });
    }

    function changetime_start(sched_id, value) {
    array = {};
    array['school_year'] = $("#school_year").val();
    array['period'] = $("#period").val();
    array['room'] = $("#room2").val();
    $.ajax({
    type: "GET",
            url: "/registrar/ajax/changetime_start_shs/" + sched_id + "/" + value,
            data:array,
            success: function (data) {
            $('#showsched').html(data);
            }
    });
    }
    
    function changetime_end(sched_id, value) {
    array = {};
    array['school_year'] = $("#school_year").val();
    array['period'] = $("#period").val();
    array['room'] = $("#room2").val();
    $.ajax({
    type: "GET",
            url: "/registrar/ajax/changetime_end_shs/" + sched_id + "/" + value,
            data:array,
            success: function (data) {
            $('#showsched').html(data);
            }
    });
    }

    function deletesched(sched_id) {
    array = {};
    array['course_id'] = $("#course_id").val();
    room2 = $("#room2").val();
    $.ajax({
    type: "GET",
            url: "/registrar/ajax/deletesched_shs/" + sched_id,
            data:array,
            success: function (data) {
            $('#popSched').html(data);
            getexistingsched(room2);
            }
    });
    }

    function addschedule(){
    array = {};
    array['school_year'] = $("#school_year").val();
    array['period'] = $("#period").val();
    array['course_offering_id'] = $("#course_id").val();
    array['room'] = $("#room").val();
    array['day'] = $("#day").val();
    array['time_start'] = $("#time_start").val();
    array['time_end'] = $("#time_end").val();
    room2 = $("#room2").val();
    $.ajax({
    type: "GET",
            url: "/registrar/ajax/addschedule_shs",
            data: array,
            success: function (data) {
            $('#popSched').html(data);
            getexistingsched(room2);
            }

    });
    }

    $(document).ready(function() {
    src = "{{ URL::to('registrar/ajax/room/autocomplete_shs')}}";
    $("#room").autocomplete({
    source: function(request, response) {
    $.ajax({
    url: src,
            dataType: "json",
            data: {
            term : request.term
            },
            success: function(data) {
            response(data);
            }
    });
    },
            minLength: 1,
    });
    $("#room2").autocomplete({
    source: function(request, response) {
    $.ajax({
    url: src,
            dataType: "json",
            data: {
            term : request.term
            },
            success: function(data) {
            response(data);
            }
    });
    },
            minLength: 1,
    });
    });
</script>
@stop