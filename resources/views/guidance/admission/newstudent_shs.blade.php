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
                        <input type="radio" name="status_upon_admission" value="Freshmen" checked> Freshman
                        <input type="radio" name="status_upon_admission" value="Transferee"> Transferee
                        <input type="radio" name="status_upon_admission" value="Returnee"> Returnee
                    </div>
                </div>
                <div class="form form-group"> 
                    <div class="col-sm-6">
                        <label class="label">Track Intended To Enroll </label>
                        <select name="course" id="course" class="form form-control">
                            <option value="">Please Select Intended Track</option>
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
                        <label class="label">Second Choice </label>
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
                        <label class="label">Student Name </label>
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
                    <div class="col-sm-2">
                        <label class="label">Birth Date</label>
                        <select name='month' class='form-control'>
                            <option value=''>Month</option>
                            <option value='01'>January</option>
                            <option value='02'>February</option>
                            <option value='03'>March</option>
                            <option value='04'>April</option>
                            <option value='05'>May</option>
                            <option value='06'>June</option>
                            <option value='07'>July</option>
                            <option value='08'>August</option>
                            <option value='09'>September</option>
                            <option value='10'>October</option>
                            <option value='11'>November</option>
                            <option value='12'>December</option>
                        </select>
                        <!--<input type="date" name="month" class="form form-control" placeholder="yyyy-dd-mm" value="{{old('birthdate')}}">-->
                    </div>
                    <div class="col-sm-2">
                        <label class="label"> </label>
                        <select name='day' class='form-control'>
                            <option value=''>Day</option>
                            <option value='01'>01</option>
                            <option value='02'>02</option>
                            <option value='03'>03</option>
                            <option value='04'>04</option>
                            <option value='05'>05</option>
                            <option value='06'>06</option>
                            <option value='07'>07</option>
                            <option value='09'>08</option>
                            <option value='09'>09</option>
                            <option value='10'>10</option>
                            <option value='11'>11</option>
                            <option value='12'>12</option>
                            <option value='13'>13</option>
                            <option value='14'>14</option>
                            <option value='15'>15</option>
                            <option value='16'>16</option>
                            <option value='17'>17</option>
                            <option value='18'>18</option>
                            <option value='19'>19</option>
                            <option value='10'>20</option>
                            <option value='11'>21</option>
                            <option value='12'>22</option>
                            <option value='13'>23</option>
                            <option value='14'>24</option>
                            <option value='15'>25</option>
                            <option value='16'>26</option>
                            <option value='17'>27</option>
                            <option value='18'>28</option>
                            <option value='19'>29</option>
                            <option value='30'>30</option>
                            <option value='31'>31</option>
                        </select>
                    </div>
                    <div class="col-sm-2">
                        <label class="label"> </label>
                        <select name='year' class='form-control'>
                            <?php $startdate = date("Y"); $enddate = 1960; $years = range ($startdate,$enddate) ?>
                            <option value=''>Year</option>
                            @foreach ($years as $year)
                            <option value='{{$year}}'>{{$year}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-sm-6">
                        <label class="label">Civil Status</label>
                        <select name="civil_status" class="form form-control">
                            <option value="single">Single</option>
                            <option value="married">Married</option>
                            <option value="divorced">Divorced</option>
                            <option value="widowed">Widowed</option>
                        </select>
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
@stop
