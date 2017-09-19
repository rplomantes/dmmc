@extends('layouts.guidanceapp')
@section('content')
<style>
    .label{color: gray;}
</style>
<div class="row">
    <div class="col-sm-12">
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
            @if(count($programs)>0)
            <form class="form-horizontal" role="form" method="POST" action="{{ url('/guidance','addapplicant') }}">
                {{ csrf_field() }}
                <input type="hidden" value=<?php $refid=uniqid(); echo $refid;?> name="refno">
                <div class="form form-group">
                    <div class="col-sm-7"><h3>Senior High School Pre-registration Form</h3></div>
                    <div class="col-sm-4">
                        <input type="radio" name="status_upon_admission" value="Freshmen" checked onclick="hideinput()"> Freshman
                        <input type="radio" name="status_upon_admission" value="Transferee" onclick="displayinput()"> Transferee
                        <input type="radio" name="status_upon_admission" value="Returnee" onclick="hideinput()"> Returnee
                    </div>
                </div>
                <div class="form form-group"> 
                    <div class="col-sm-6">
                        <label class="label">Strand Intended To Enroll* </label>
                        <select name="course" id="course" class="form form-control">
                            <option value="">Please Select Intended Strand</option>
                            @foreach($programs as $program)
                            <option value="{{$program->track}}"
                                    @if(old('course')== $program->track )
                                    selected = "selected"
                                    @endif
                                    >{{$program->track}}</option>
                            @endforeach
                        </select>    
                    </div> 
                    <div class="col-sm-6">
                        <label class="label">Second Choice* </label>
                        <select name="course2" id="course2" class="form form-control">
                            <option value="">Please Select Second Choice</option>
                            @foreach($programs as $program)
                            <option value="{{$program->track}}">{{$program->track}}</option>
                            @endforeach
                        </select>    
                    </div>
                </div>

                <div class="form form-group">
                    <div class="col-sm-12">
                        <label class="label">Student Name* </label>
                    </div>
                    <div class="col-sm-3">
                        <input type="text" name ="lastname" class="form form-control" placeholder="Last Name" value="{{old('lastname')}}">
                    </div>    
                    <div class="col-sm-3">
                        <input type="text" name="firstname" class="form form-control" placeholder="First Name" value="{{old('firstname')}}">
                    </div>    
                    <div class="col-sm-3">
                        <input type="text" name="middlename" class="form form-control" placeholder="Middle Name" value="{{old('middlename')}}">
                    </div> 
                    <div class="col-sm-3">
                        <input type="text" name="extensionname" class="form form-control" placeholder="Extension Name" value="{{old('extensionname')}}">
                    </div> 
                </div>
                
                <div class="form form-group">
                    <div class="col-sm-6">
                        <label class="label">Birth Date*</label>
                        <div class="input-group stylish-input-group">
                            <input type="date" name="birthdate" id="datepicker" class="form form-control" placeholder="yyyy-dd-mm" value="{{old('birthdate')}}">
                            <span class="input-group-addon">
                                <span class="fa fa-calendar"></span> 
                            </span>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <label class="label">Civil Status</label>
                        <select name="civil_status" class="form form-control">
                            <option value="single">Single</option>
                            <option value="married">Married</option>
                            <option value="divorced">Divorced</option>
                            <option value="widowed">Widowed</option>
                        </select>
                    </div>
                    <div class="col-sm-3">
                        <label class="label">Gender</label>
                        <select name="gender" class="form form-control">
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                        </select>
                    </div>
                </div>

                <div class="form form-group"> 
                    <div class="col-sm-12">
                        <label class="label">Address*</label>
                        <input type="text" name="address" class="form form-control" value="{{old('address')}}">
                    </div>
                </div>

                <div class="form form-group">
                    <div class="col-sm-6">
                        <label class="label">Contact Number*</label>
                        <input type="text" name="contact_no" class="form form-control" value="{{old('contact_no')}}">
                    </div>

                    <div class="col-sm-6">
                        <label class="label">Email Address* </label>
                        <input type="email" name="email" class="form form-control" value="{{old('email')}}">
                    </div>
                </div>    

                <div class="form form-group">
                    <div class="col-sm-6">
                        <label class="label">School Last Attended</label>
                        <input type="text" name="last_school_attended" class="form form-control" value="{{old('last_school_attended')}}">
                    </div>
                    <div class="col-sm-2">
                        <label class="label">Year Graduated</label>
                        <input type="text" name="year_graduated" class="form form-control" value="{{old('year_graduated')}}">
                    </div>
                    <div class="col-sm-2">
                        <label class="label">General Average</label>
                        <input type="text" name="gen_ave" class="form form-control" value="{{old('gen_ave')}}">
                    </div>
                    <div class="col-sm-2">
                        <label class="label">Honor Received</label>
                        <input type="text" name="honors_received" class="form form-control" value="{{old('honors_received')}}">
                    </div>        
                </div>
                <div id='transferee' class="form form-group" style='display:none'>
                    <div class="col-sm-12"><label class="label">If transferee</label></div>
                    <div class="col-sm-8">
                        <input type="text" name="name_of_school" class="form form-control" placeholder="Name of School" value="{{old('name_of_school')}}">
                    </div>
                    <div class="col-sm-4">
                        <input type="text" name="prev_course" class="form form-control" placeholder="Course/Strand" value="{{old('prev_course')}}">
                    </div>
                </div>
                <div class="form form-group">
                    <div class="col-sm-12">
                        <input type="submit" name="submit" value="Add Applicant to Pre-registration" class="form form-control btn btn-primary">    
                    </div>    
                </div>
            </form>
        </div>
        @else
        <div class="alert alert-danger">No program or course has been set to the system.  Please see administrator.</div>
        @endif
    </div>
</div>

<script>
function displayinput(){
    $('#transferee').show();
}
function hideinput(){
    $('#transferee').hide();
}
</script>
@stop
