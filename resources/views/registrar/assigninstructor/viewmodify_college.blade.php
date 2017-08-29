@extends('layouts.registrarapp')
@section('content')
<style>
    .label{color: gray;}
</style>

<div class="row">
    <div class='col-sm-12'>
        <div id="imaginary_container">
            @if (count($errors) > 0)
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif
            <form class="form-horizontal" role="form" method="POST" action="{{ url('/registrar',array('assign_instructor','modifyinfo_college'))}}">
                {{ csrf_field() }}
                <input type='hidden' value='{{$user->id}}' name='id'>
                <div class="form form-group">
                    <div class="col-sm-12"><h3>Modify Instructor Profile</h3></div>
                </div>
                <div class="form form-group">
                    <div class="col-sm-3">
                        <label class="label">ID No</label>
                        <input class="form form-control" id="idno" type="text" name="idno" value="{{$user->idno}}" readonly="">
                    </div>
                </div>
                <div class="form form-group">
                    <div class="col-sm-12">
                        <label class="label">Instructor Name </label>
                    </div>
                    <div class="col-sm-3">
                        <input type="text" name ="lastname" class="form form-control" placeholder="Last Name" value="{{$user->lastname}}">
                    </div>    
                    <div class="col-sm-3">
                        <input type="text" name="firstname" class="form form-control" placeholder="First Name" value="{{$user->firstname}}">
                    </div>    
                    <div class="col-sm-3">
                        <input type="text" name="middlename" class="form form-control" placeholder="Middle Name" value="{{$user->middlename}}">
                    </div> 
                    <div class="col-sm-3">
                        <input type="text" name="extensionname" class="form form-control" placeholder="Extension Name" value="{{$user->extensionname}}">
                    </div> 
                </div>
                <div class="form form-group">
                    <div class="col-sm-6">
                        <label class="label">Email Address </label>
                        <input type="email" name="email" class="form form-control" value="{{$user->email}}">
                    </div>
                </div>
                <div class="form form-group">
                    <div class="col-sm-12">
                        <input type="submit" name="submit" value="Modify Instructor Profile" class="form form-control btn btn-primary">    
                    </div>    
                </div>
            </form>
        </div>
    </div>
</div>
@stop