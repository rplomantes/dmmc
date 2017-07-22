@extends('layouts.registrarapp')
@section('content')
<style>
    .label{color: gray;}
</style>
<?php
$school_year = \App\CtrSchoolYear::where('academic_type', 'College')->first();
?>
<div class="row">
    <div class='col-sm-12'>
        <div id="imaginary_container">
            <h3>{{$course_offering->course_code}} - {{$course_offering->course_name}}</h3>
            <h4>{{$course_offering->level}} year - @if ($course_offering->period== '1st') 1st Semester @elseif ($course_offering->period== '2nd') 2nd Semester @elseif ($course_offering->period== 'Summer') Summer @else @endif</h4>
            <h4>Section: {{$course_offering->section}}</h4>

            <input type="hidden" id="school_year" value="{{$school_year->school_year}}">
            <input type="hidden" id="period" value="{{$school_year->period}}">
            <input type="hidden" id="course_id" value="{{$course_offering->id}}">



            <!--Top-->
            <div class="col-sm-3">
                <label class="label">Room</label>
                <select class="form form-control" id="room">
                    <option value="">Select Room</option>
                    <option value="Rm 101">Rm 101</option>
                    <option value="Rm 102">Rm 102</option>
                    <option value="Rm 103">Rm 103</option>
                    <option value="Rm 104">Rm 104</option>
                </select>
            </div>

            <div class="col-sm-3">
                <label class="label">Day</label>
                <input id="day" class="form form-control">
            </div>
            <div class="col-sm-3">
                <label class="label">Time</label>
                <input id="time" class="form form-control">
            </div>
            <div class="col-sm-3">
                <label class="label"><br></label>
                <input type="submit" value="Add" class="col-sm-6 btn btn-info" onclick="addschedule(room2.value)">
            </div>


            <!--left side-->
            <div class="col-sm-6">
                <h4>Subject Schedule</h4>
                <div id="popSched">
                    <table class="table table-condensed">
                        <thead>
                        <th class="col-sm-3">Room</th>
                        <th class="col-sm-3">Day</th>
                        <th class="col-sm-3">Time</th>
                        <th class="col-sm-3">Delete</th>
                        </thead>
                        <tbody>
                            @foreach ($schedules as $schedule)
                            <tr>
                                <td><input onchange="changeroom('{{$schedule->id}}', this.value)" id="room" type="text" class="form form-control" value="{{$schedule->room}}"></td>
                                <td><input onchange="changeday('{{$schedule->id}}', this.value)" id="day" type="text" class="form form-control" value="{{$schedule->day}}"></td>
                                <td><input onchange="changetime('{{$schedule->id}}', this.value)" id="time" type="text" class="form form-control" value="{{$schedule->time}}"></td>
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
                <select class="form form-control" id='room2' onchange="getexistingsched(this.value)">
                    <option value="">Select Room</option>
                    <option value="Rm 101">Rm 101</option>
                    <option value="Rm 102">Rm 102</option>
                    <option value="Rm 103">Rm 103</option>
                    <option value="Rm 104">Rm 104</option>
                </select>
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
            url: "/registrar/ajax/getexistingsched/" + room2,
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
            url: "/registrar/ajax/changeroom_college/" + sched_id + "/" + value,
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
            url: "/registrar/ajax/changeday_college/" + sched_id + "/" + value,
            data:array,
            success: function (data) {
            $('#showsched').html(data);
            }
    });
    }

    function changetime(sched_id, value) {
    array = {};
    array['school_year'] = $("#school_year").val();
    array['period'] = $("#period").val();
    array['room'] = $("#room2").val();
    $.ajax({
    type: "GET",
            url: "/registrar/ajax/changetime_college/" + sched_id + "/" + value,
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
            url: "/registrar/ajax/deletesched_college/" + sched_id,
            data:array,
            success: function (data) {
            $('#popSched').html(data);
            getexistingsched(room2);
            }
    });
    }
    
    function addschedule(room2){
    array = {};
    array['school_year'] = $("#school_year").val();
    array['period'] = $("#period").val();
    array['course_offering_id'] = $("#course_id").val();
    array['room'] = $("#room").val();
    array['day'] = $("#day").val();
    array['time'] = $("#time").val();
    $.ajax({
    type: "GET",
            url: "/registrar/ajax/addschedule_college",
            data: array,
            success: function (data) {
            $('#popSched').html(data);
            getexistingsched(room2);
            }

    });
    }
</script>
@stop