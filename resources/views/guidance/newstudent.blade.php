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
                    <div class="col-sm-7"><h3>Add Applicant to Pre-registration</h3></div>
                    <div class="col-sm-4">
                        <input type="radio" name="status_upon_admission" value="Freshmen" checked> Freshman
                        <input type="radio" name="status_upon_admission" value="Transferee"> Transferee
                        <input type="radio" name="status_upon_admission" value="Returnee"> Returnee
                    </div>
                </div>
                <div class="form form-group"> 
                    <div class="col-sm-6">
                        <label class="label">Course Intended To Enroll </label>
                        <select name="course" id="course" class="form form-control" onchange="getMajor(this.value)">
                            <option value="">Please Select Intended Course</option>
                            @foreach($programs as $program)
                            <option value="{{$program->program_code}}">{{$program->program_code}} - {{$program->program_name}}</option>
                            @endforeach
                        </select>    
                    </div>
                    <div class="col-sm-6">
                        <label class="label">Major In </label>
                        <select name="major" id="major" class="form form-control">
                            <option value=""></option> 
                        </select>    
                    </div>
                </div>

                <div class="form form-group"> 
                    <div class="col-sm-6">
                        <label class="label">Second Choice </label>
                        <select name="course2" id="course2" class="form form-control" onchange="getMajor2(this.value)">
                            <option value="">Please Select Second Choice</option>
                            @foreach($programs as $program)
                            <option value="{{$program->program_code}}">{{$program->program_code}} - {{$program->program_name}}</option>
                            @endforeach
                        </select>    
                    </div>
                    <div class="col-sm-6">
                        <label class="label">Major In </label>
                        <select name="major2" id="major2" class="form form-control">
                            <option value="None"></option>
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
                        <input type="text" name="firstname" class="form form-control" placeholder="First Name" value="{{old('firstname')}}">
                    </div>    
                    <div class="col-sm-3">
                        <input type="text" name="middlename" class="form form-control" placeholder="Middle Name" value="{{old('firstname')}}">
                    </div> 
                    <div class="col-sm-3">
                        <input type="text" name="extensionname" class="form form-control" placeholder="Extension Name" value="{{old('extensionname')}}">
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
                        <input type="text" name="contact_no" class="form form-control" value="{{old('contact_no')}}">
                    </div>

                    <div class="col-sm-6">
                        <label class="label">Email Address </label>
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
                <div class="form form-group">
                    <div class="col-sm-12"><label class="label">If transferee</label></div>
                    <div class="col-sm-8">
                        <input type="text" name="name_of_school" class="form form-control" placeholder="Name of School" value="{{old('name_of_school')}}">
                    </div>
                    <div class="col-sm-4">
                        <input type="text" name="prev_course" class="form form-control" placeholder="Course" value="{{old('prev_course')}}">
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
function getMajor(course) {
    $.ajax({
        type: "GET",
        url: "/ajax/guidance/getMajor/" + course,
        success: function (data) {
            $('#major') .empty();
            $.each(data, function (index,ctr_academic_programs) {
                $('#major').append('<option value="' + ctr_academic_programs.major + '">' + ctr_academic_programs.major + '</option>');
            });
        }
    });
}
;
function getMajor2(course2) {
    $.ajax({
        type: "GET",
        url: "/ajax/guidance/getMajor2/" + course2,
        success: function (data) {
            $('#major2') .empty();
            $.each(data, function (index,ctr_academic_programs) {
                $('#major2').append('<option value="' + ctr_academic_programs.major + '">' + ctr_academic_programs.major + '</option>');
            });
        }
    });
}
;
</script>

@stop
