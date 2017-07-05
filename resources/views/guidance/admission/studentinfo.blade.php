@extends('layouts.guidanceapp')
@section('content')
<style>
    .label{color: gray;}
</style>
<div class="row">
    <div class="col-sm-12">
        @if(count($idno)>0)
        <div class="alert alert-info">Your reference number is: <b>{{$idno}}.</b></div>
        <table class="table">
            <tr>
                <td>Name:</td>
                <td><h3>{{$firstname}} {{$extensionname}} {{$middlename}} {{$lastname}}</h3></td>
            </tr>
            <tr>
                <td>Course intended to enroll:</td>
                <td><h3>{{$course}} @if(($major) !== null) Major in {{$major}} @else @endif</h3></td>
            </tr>
        </table>
        @else
        @endif
    </div>
</div>
@stop
