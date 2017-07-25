@extends('layouts.registrarapp')
@section('content')
<style>
    .label{color: gray;}
</style>

<div class="row">
    <div class='col-sm-12'>
        <div id="imaginary_container">
            <h3>Instructor's Profile</h3>
            <table class="table table-condensed">
                <tr>
                    <td class="col-sm-4">ID Number:</td>
                    <td class="col-sm-8">{{$instructor->idno}}</td>
                </tr>
                <tr>
                    <td>Name:</td>
                    <td>{{$instructor->firstname}} {{$instructor->middlename}} {{$instructor->lastname}} {{$instructor->extensionname}}</td>
                </tr>
                <tr>
                    <td>Email:</td>
                    <td>{{$instructor->email}}</td>
                </tr>
                <tr>
                    <td><a href="{{url('registrar', array('assign_instructor', 'modify', $instructor->id))}}"><div class="col-sm-12 btn btn-success">Modify</div></a></td>
                    <td><a href="{{url('registrar', array('assign_instructor', 'loadsubjects', $instructor->id))}}"><div class="col-sm-12 btn btn-primary">Load Subjects</div></a></td>
                </tr>
            </table>
        </div>
    </div>
</div>
@stop