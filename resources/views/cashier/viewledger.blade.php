<?php
$student = \App\User::where('idno',$idno)->first();
$status =  \App\Status::where('idno',$idno)->first();
$ledgers = \App\ledger::where('idno',$idno)->where('categoryswitch','<=','3')->get();
?>

@extends('layouts.cashierapp')
@section('content')
<style>
    #duedisplay{color:purple;font-size: 30pt;font-weight: bold}
</style>
<div class="container-fluid">
    <div class="col-md-9">
        <div class="form-group">
            <a href="{{url('otherpayment',$idno)}}" class="btn btn-primary">Other Payment</a>
        </div>  
        <div class="form-group">
            <ul class="nav navbar-header">
                <li>Student Id : {{$student->idno}}</li>
                <li><b>Student Name : {{$student->lastname}}, {{$student->firstname}}</b></li> 
                    @if($status->status>=3)
                        @if($status->academic_type=="Senior High School")
                            <li>Grade/Section : {{$status->level}} - {{$status->section}}<li>
                        @else
                            <li>Course/Level : {{$status->program_code}} - {{$status->level}}
                        @endif
                    @else
                        <li>Remarks : <span style="color:red;font-weight: bold">Not Currently Enrolled</span></li>
                    @endif
            </ul>
        </div>        
    </div>
    <div class="col-md-3">
        
        <table class="table table-responsive"><tr><td align="center">
        Amount Due Today
        <td></tr>
        <tr><td align="right">    
        <div id="duedisplay">100,000.00</div>
        </td></tr></table>
        <a href="{{url('mainpayment',$idno)}}" class="btn btn-danger form-control">Go To Payment</a>
        
    </div>
<div class="col-md-12">
    @if(count($ledgers)>0)
    <h3>Main Account</h3>
    <table class="table table-responsive"><tr><td>Description</td><td>Amount</td><td>Discount</td><td>Payment</td><td>Balance</td></tr>
        @foreach
    @else
    @endif
</div>    
</div>
@stop
