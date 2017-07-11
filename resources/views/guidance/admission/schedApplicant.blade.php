@extends('layouts.guidanceapp')
@section('content')
<style>
    .label{color: gray;}
</style>
@if (count($errors) > 0)
<div class="alert alert-danger">
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif 
<div class="row">
    <div class='col-sm-12'>
        <form class="form form-horizontal" method="POST" action="{{url('/guidance','schedApplicant')}}">
            {{ csrf_field() }}
            <div class="form-group">
                <div class="col-sm-3">
                    <label class="label">Reference Number</label>
                    <b><input type="text" name="idno" class="form form-control" value = '{{$list->idno}}' readonly=""></b>
                </div><div class="col-sm-3">
                    <label class="label">Date Pre-registered</label>
                    <input type="text" class="form form-control" value = '{{ date ('M d, Y', strtotime ($list->created_at))}}' readonly="">
                </div>
                <div class="col-sm-3">
                    <label class="label">Intended Course</label>
                    <input type="text" name="course" class="form form-control" value = '{{$list->course}}' readonly="">
                </div><div class="col-sm-3">
                    <label class="label">Second Course</label>
                    <input type="text" name="course2" class="form form-control" value = '{{$list->course2}}' readonly="">
                </div>
            </div>
            <div class="form form-group">
                <div class="col-sm-12">
                    <label class="label">Student Name</label>
                </div>
                <div class="col-sm-3">
                    <input type="text" name="firstname" class="form form-control" value = '{{$list->firstname}}' placeholder="First Name" readonly="">
                </div>
                <div class="col-sm-3">
                    <input type="text" name="middlename" class="form form-control" value = '{{$list->middlename}}' placeholder="Middle Name" readonly="">
                </div>
                <div class="col-sm-3">
                    <input type="text" name="lastname" class="form form-control" value = '{{$list->lastname}}' placeholder="Last Name" readonly="">
                </div>
                <div class="col-sm-3">
                    <input type="text" name="extensionname" class="form form-control" value = '{{$list->extensionname}}' placeholder="Extension Name" readonly="">
                </div>
            </div>
            <div class="form form-group">
                <div class="col-sm-12">
                    <label class="label">Entrance Exam Schedule</label>
                    <select name="exam_date" id="exam_date" class='form form-control'>
                        <option value=''>Choose Entrance Exam Schedule</option>
                        @foreach ($dates as $date)
                        <option value='{{$date->id}}'>{{ date ('M d, Y (D) - g:i A', strtotime($date->datetime))}} - {{$date->place}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-12">
                    <input type="submit" class="form-control btn btn-success" value="Schedule Entrance Exam">
                </div>
            </div>
        </form>
    </div>
</div>
@stop