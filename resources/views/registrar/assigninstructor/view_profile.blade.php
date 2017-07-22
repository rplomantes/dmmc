@extends('layouts.registrarapp')
@section('content')
<style>
    .label{color: gray;}
</style>

<div class="row">
    <div class='col-sm-12'>
        <div id="imaginary_container">
            <table class="table">
                <tr>
                    <td>ID Number:</td>
                    <td>{{$instructor->idno}}</td>
                </tr>
                <tr>
                    <td>Name:</td>
                    <td>{{$instructor->firstname}} {{$instructor->middlename}} {{$instructor->lastname}} {{$instructor->extensionname}}</td>
                </tr>
            </table>
        </div>
    </div>
</div>
@stop