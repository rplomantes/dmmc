@extends('layouts.deanapp')
@section('content')
<?php
$user = \App\User::where('idno',$idno)->first();
$info = \App\StudentInfo::where('idno',$idno)->first();
?>
 <table class="table table-condensed">
        <tr><td>Reference No</td><td><span class = "label label-danger">{{$idno}}</span></td></tr>
        <tr><td>Student Name</td><td><strong>{{$user->lastname}}, {{$user->firstname}} {{$user->middlename}} {{$user->extensionname}}</strong></td></tr>
        <tr><td>Contact Number</td><td>{{$info->contact_no}}</td></tr>
        <tr><td>Email Address</td><td>{{$user->email}}</td></tr>
        <tr><td>Course Intended To Enroll</td><td>{{$info->course}}</td></tr>
        <tr><td>Second Course of Choice</td><td>{{$info->course2}}</td></tr>
        <tr><td colspan="2" align="center"><span style='color:red;font-size: 20pt; font-weight: bold'>ENTRANCE EXAM FAILED!!!</span></td></tr>
        <tr><td colspan="2" align="center"><i>This Student failed to qualify for enrollment at DMMC IHS !!</i></td></tr>
 </table>       
@stop


