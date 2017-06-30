@extends('layouts.guidanceapp')
@section('content')
<style>
    .label{color: gray;}
</style>    
<h3>Add Applicant to Pre-registration</h3>
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
                <div class="form form-group"> 
                    <div class="col-sm-6">
                        <label class="label">Course Intended To Enroll </label>
                        <select name="course" id="course" class="form form-control">
                            @foreach($programs as $program)
                                <option value="">Please Select Intended Course</option>
                                <option value="{{$program->program_code}}">{{$program->program_code}}</option>
                            @endforeach
                        </select>    
                    </div>
                    <div class="col-sm-6">
                        <label class="label">Major In </label>
                        <select name="major" id="major" class="form form-control">
                            <div id="listmajor">
                            </div>    
                        </select>    
                    </div>
                </div>    
            
                <div class="form form-group">
                    <div class="col-sm-12">
                        <label class="label">Student Name 
                    </div>
                    <div class="col-sm-3">
                        <input type="text" name ="lastname" class="form form-control" placeholder="Last Name" value="{{old('lastname')}}">
                    </div>    
                    <div class="col-sm-3">
                        <input type="text" name="firstname" class="form form-control" placeholder="First Name">
                    </div>    
                    <div class="col-sm-3">
                        <input type="text" name="middlename" class="form form-control" placeholder="Middle Name">
                    </div> 
                     <div class="col-sm-3">
                        <input type="text" name="extensionname" class="form form-control" placeholder="Extension Name">
                    </div> 
                </div>
                 
                <div class="form form-group"> 
                    <div class="col-sm-12">
                        <label class="label">Address</label>
                            <input type="text" name="address" class="form form-control" value="{{old('address')}}">
                    </div>
                </div>
                 
                <div class="form form-group">
                    <div class="col-sm-6">
                        <label class="label">Contact Number</label>
                            <input type="text" name="contactno" class="form form-control">
                    </div>
                    
                    <div class="col-sm-6">
                        <label class="label">Email Address </label>
                            <input type="email" name="email" class="form form-control">
                    </div>
                </div>    
                 
                <div class="form form-group">
                    <div class="col-sm-6">
                        <label class="label">School Last Attended</label>
                            <input type="text" name="last_school_attended" class="form form-control">
                    </div>
                    <div class="col-sm-2">
                        <label class="label">Year Graduated</label>
                            <input type="text" name="year_graduated" class="form form-control">
                    </div>
                    <div class="col-sm-2">
                        <label class="label">GWA</label>
                            <input type="text" name="gwa" class="form form-control">
                    </div>
                    <div class="col-sm-2">
                        <label class="label">Honors Received</label>
                            <input type="text" name="honors_received" class="form form-control">
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
                <div class="alert alert-danger">No Program or Course Has Been Set To The System.  Please See Administrator.</div>
          @endif
    </div>
</div>
@stop
