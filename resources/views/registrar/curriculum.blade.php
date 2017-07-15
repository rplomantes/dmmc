@extends('layouts.registrarapp')
@section('content')

<ul class="nav nav-tabs">
    <li class="active"><a href="{{url('/registrar/curriculum/college')}}">View</a></li>
    <li><a href="{{url('/registrar/curriculum/college/add')}}">Add</a></li>
</ul>
<br>

<div class="row">
    <div class="col-sm-10 col-sm-offset-1">
        <div id="imaginary_container">
            Select Program:<br>
            <select class="form-control" name="prodName" id="prodName">
                <option></option>
            </select><br>
        </div>
    </div>
</div>
@stop
