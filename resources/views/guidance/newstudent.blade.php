@extends('layouts.guidanceapp')
@section('content')

<div class="row">
    <div class="col-sm-12">
        <div id="imaginary_container"> 
            <form>
                <div class="col-sm-2">Surname:</div>
                <input type="text"class="col-sm-2">
                <div class="col-sm-2">First Name:</div>
                <input type="text"class="col-sm-2">
                <div class="col-sm-2">Middle Name:</div>
                <input type="text"class="col-sm-2">
                
                
                <div class="col-sm-2">Address:</div>
                <input type="text"class="col-sm-10">
                
                <div class="col-sm-2">Contact No:</div>
                <input type="text"class="col-sm-5">
                <div class="col-sm-2">Email Address:</div>
                <input type="email"class="col-sm-3">
                
                <div class="col-sm-3">School last attended:</div>
                <input type="text"class="col-sm-9">
                
                <div class="col-sm-2">Year graduated:</div>
                <input type="text"class="col-sm-1">
                <div class="col-sm-1">GWA:</div>
                <input type="text"class="col-sm-1">
                <div class="col-sm-2">Honors Received:</div>
                <input type="text"class="col-sm-5">
                
                <div class="col-sm-12"> For Transferee:</div>
                <div class="col-sm-2">School:</div>
                <input type="text"class="col-sm-6">
                <div class="col-sm-1">Course:</div>
                <input type="text"class="col-sm-3">
                
            </form>
        </div>
    </div>
</div>
@stop
