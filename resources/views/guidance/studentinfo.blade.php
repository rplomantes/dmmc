@extends('layouts.guidanceapp')
@section('content')
<style>
    .label{color: gray;}
</style>
<div class="row">
    <div class="col-sm-12">
        @if(count($refno)>0)
        <div class="alert alert-info">Your reference number is: <b>{{$refno}}.</b></div>
        @else
        @endif
    </div>
    <table class="table">
        <tr>
            <td>Name:</td>
            <td><h3>{{$firstname}} {{$extensionname}} {{$middlename}} {{$lastname}}</h3></td>
        </tr>
        <tr>
            <td>Course intended to enroll:</td>
            <td><h3>{{$course1}} @if(($major1) !== null) Major in {{$major1}} @else @endif</h3></td>
        </tr>
    </table>
</div>
@stop
