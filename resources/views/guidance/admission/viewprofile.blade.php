@extends('layouts.guidanceapp')
@section('content')
<style>
    .label{color: gray;}
</style>
<div class="row">
    <div class='col-sm-12'>
        <h3>Student Information</h3>
        <table class='table'>
            <tr>
                <td>Reference No</td>
                <td>{{$list->idno}}</td>
            </tr>
            <tr>
                <td>Date Pre-registered</td>
                <td>{{ date ('M d, Y', strtotime ($list->created_at))}}</td>
            </tr>
            <tr>
                <td>Name</td>
                <td>{{$list->firstname}} {{$list->middlename}} {{$list->lastname}} {{$list->extensionname}}</td>
            </tr>
            <tr>
                <td>Address</td>
                <td>{{$list->address}}</td>
            </tr>
            <tr>
                <td>Birth Date</td>
                <td>{{$list->birthdate}}</td>
            </tr>
            <tr>
                <td>Civil Status</td>
                <td>{{$list->civil_status}}</td>
            </tr>
            <tr>
                <td>Contact Number</td>
                <td>{{$list->contact_no}}</td>
            </tr>
            <tr>
                <td>Email Address</td>
                <td>{{$list->email}}</td>
            </tr>
            <tr>
                <td>School Last Attended</td>
                <td>{{$list->last_school}}</td>
            </tr>
            <tr>
                <td>Year Graduated</td>
                <td>{{$list->year_graduated}}</td>
            </tr>
            <tr>
                <td>General Average</td>
                <td>{{$list->gen_ave}}</td>
            </tr>
            <tr>
                <td>Honor Received</td>
                <td>{{$list->honor}}</td>
            </tr>
            <tr>
                <td>If transferee</td>
                <td>School - {{$list->school}} <br>Course - {{$list->prev_course}}</td>
            </tr>
            
        </table>
        <h3>Course</h3>
        <table class='table'>
            <tr>
                <td>Intended Course to Enroll</td>
                <td>{{$list->course}}</td>
            </tr>
            <tr>
                <td>Major</td>
                <td>{{$list->major}}</td>
            </tr>
            <tr>
                <td>Second Choice</td>
                <td>{{$list->course2}}</td>
            </tr>
            <tr>
                <td>Major</td>
                <td>{{$list->major2}}</td>
            </tr>
        </table>
        <div class='btn btn-success col-sm-6'>Modify</div> 
        <div class='btn btn-primary col-sm-6'>Print Entrance Exam Slip</</div>
</div>
@stop
