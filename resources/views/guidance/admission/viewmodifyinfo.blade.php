@extends('layouts.guidanceapp')
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
            <form class="form-horizontal" role="form" method="POST" action="{{ url('/guidance','modifyinfo') }}">
                {{ csrf_field() }}
                <div class="form form-group">
                    <div class="col-sm-12"><h3>Modify Applicant Profile</h3></div>
                </div>
                <div class="form form-group">
                    <div class="col-sm-6">
                        <label class="label">Reference No</label>
                        <input class="form form-control" id="idno" type="text" name="idno" value="{{$list->idno}}" readonly="">
                    </div>
                    <div class="col-sm-6">
                        <input onclick="hideinput()" type="radio" name="status_upon_admission" value="Freshmen"
                               @if ($list->status_upon_admission== 'Freshmen')
                               checked
                               @endif
                               > Freshman
                               <input onclick="displayinput()" type="radio" name="status_upon_admission" value="Transferee"
                               @if ($list->status_upon_admission== 'Transferee')
                               checked
                               @endif
                               > Transferee
                               <input onclick="hideinput()" type="radio" name="status_upon_admission" value="Returnee"
                               @if ($list->status_upon_admission== 'Returnee')
                               checked
                               @endif
                               > Returnee
                    </div>
                </div>

                @if ($list->academic_type=='College' or $list->academic_type == 'TESDA')

                <div class="form form-group"> 
                    <div class="col-sm-12">
                        <label class="label">Course Intended To Enroll </label>
                        <select name="course" id="course" class="form form-control">
                            <option value="">Please Select Intended Course</option>
                            @foreach($programs as $program)
                            <option value="{{$program->program_code}}"
                                    @if ($list->course== $program->program_code)
                                    selected='selected'
                                    @endif
                                    >{{$program->program_code}} - {{$program->program_name}}</option>
                            @endforeach
                        </select> 
                    </div>
                </div>

                <div class="form form-group"> 
                    <div class="col-sm-12">
                        <label class="label">Second Choice </label>
                        <select name="course2" id="course2" class="form form-control">
                            <option value="">Please Select Second Choice</option>
                            <option value="">None</option>
                            @foreach($programs as $program)
                            <option value="{{$program->program_code}}"
                                    @if ($list->course2== $program->program_code)
                                    selected='selected'
                                    @endif>{{$program->program_code}} - {{$program->program_name}}</option>
                            @endforeach
                        </select>    
                    </div>
                </div>

                @elseif ($list->academic_type=='Senior High School')

                <div class="form form-group"> 
                    <div class="col-sm-12">
                        <label class="label">Strand Intended To Enroll </label>
                        <select name="course" id="course" class="form form-control">
                            <option value="">Please Select Intended Strand</option>
                            @foreach($programs as $program)
                            <option value="{{$program->track}}"
                                    @if ($list->course== $program->track)
                                    selected='selected'
                                    @endif
                                    >{{$program->track}}</option>
                            @endforeach
                        </select> 
                    </div>
                </div>

                <div class="form form-group"> 
                    <div class="col-sm-12">
                        <label class="label">Second Choice </label>
                        <select name="course2" id="course2" class="form form-control">
                            <option value="">Please Select Second Choice</option>
                            <option value="">None</option>
                            @foreach($programs as $program)
                            <option value="{{$program->track}}"
                                    @if ($list->course2== $program->track)
                                    selected='selected'
                                    @endif>{{$program->track}}</option>
                            @endforeach
                        </select>    
                    </div>
                </div>
                @else
                <div class='alert alert-danger'>No Department yet has been set to the Applicant. Please see administrator.</div>
                @endif

                <div class="form form-group">
                    <div class="col-sm-12">
                        <label class="label">Student Name </label>
                    </div>
                    <div class="col-sm-3">
                        <input type="text" name ="lastname" class="form form-control" placeholder="Last Name" value="{{$list->lastname}}">
                    </div>    
                    <div class="col-sm-3">
                        <input type="text" name="firstname" class="form form-control" placeholder="First Name" value="{{$list->firstname}}">
                    </div>    
                    <div class="col-sm-3">
                        <input type="text" name="middlename" class="form form-control" placeholder="Middle Name" value="{{$list->middlename}}">
                    </div> 
                    <div class="col-sm-3">
                        <input type="text" name="extensionname" class="form form-control" placeholder="Extension Name" value="{{$list->extensionname}}">
                    </div> 
                </div>

                <div class="form form-group">
                    <div class="col-sm-6">
                        <label class="label">Birth Date</label>
                        <div class="input-group stylish-input-group">
                            <input type="date" name="birthdate" id="datepicker" class="form form-control" placeholder="yyyy-dd-mm" value="{{$list->birthdate}}">
                            <span class="input-group-addon">
                                <span class="fa fa-calendar"></span> 
                            </span>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <label class="label">Civil Status</label>
                        <select name="civil_status" class="form form-control">
                            <option value="single" @if ($list->civil_status== 'single')
                                    selected='selected'
                                    @endif>Single</option>
                            <option value="married"@if ($list->civil_status== 'married')
                                    selected='selected'
                                    @endif>Married</option>
                            <option value="divorced"@if ($list->civil_status== 'divorced')
                                    selected='selected'
                                    @endif>Divorced</option>
                            <option value="widowed"@if ($list->civil_status== 'widowed')
                                    selected='selected'
                                    @endif>Widowed</option>
                        </select>
                    </div>
                    <div class="col-sm-3">
                        <label class="label">Gender</label>
                        <select name="gender" class="form form-control">
                            <option value="Male" @if ($list->gender== 'Male')
                                    selected='selected'
                                    @endif>Male</option>
                            <option value="Female"@if ($list->gender== 'Female')
                                    selected='selected'
                                    @endif>Female</option>
                        </select>
                    </div>
                </div>

                <div class="form form-group">
                        <div class="col-sm-12">
                            <label class="label">Address*</label>
                        </div>
                        <div class="col-sm-6">
                            <input type="text" name="street" placeholder="House/Lot & Block No., Street, Subdivision" class="form form-control" value="{{$list->street}}">
                        </div>
                        <div class="col-sm-6">
                            <input type="text" name="barangay" placeholder="Barangay" class="form form-control" value="{{$list->barangay}}">
                        </div>
                </div>
                <div class="form form-group">
                        <div class="col-sm-12">
                            <label class="label"></label>
                        </div>
                        <div class="col-sm-5">
                            <input type="text" name="municipality" placeholder="City/Municipality (REQUIRED)" class="form form-control" value="{{$list->municipality}}">
                        </div>
                        <div class="col-sm-5">
                            <input type="text" name="province" class="form form-control" placeholder="Province (REQUIRED)" value="{{$list->province}}">
                        </div>
                        <div class="col-sm-2">
                            <input type="text" name="zip" class="form form-control" placeholder="ZIP Code" value="{{$list->zip}}">
                        </div>
                </div>

                <div class="form form-group">
                    <div class="col-sm-6">
                        <label class="label">Contact Number</label>
                        <input type="text" name="contact_no" class="form form-control" value="{{$list->contact_no}}">
                    </div>

                    <div class="col-sm-6">
                        <label class="label">Email Address </label>
                        <input type="email" name="email" class="form form-control" value="{{$list->email}}">
                    </div>
                </div>    

                <div class="form form-group">
                    <div class="col-sm-6">
                        <label class="label">School Last Attended</label>
                        <input type="text" name="last_school_attended" class="form form-control" value="{{$list->last_school}}">
                    </div>
                    <div class="col-sm-2">
                        <label class="label">Year Graduated</label>
                        <input type="text" name="year_graduated" class="form form-control" value="{{$list->year_graduated}}">
                    </div>
                    <div class="col-sm-2">
                        <label class="label">General Average</label>
                        <input type="text" name="gen_ave" class="form form-control" value="{{$list->gen_ave}}">
                    </div>
                    <div class="col-sm-2">
                        <label class="label">Honor Received</label>
                        <input type="text" name="honors_received" class="form form-control" value="{{$list->honor}}">
                    </div>        
                </div>
                <div id="transferee" class="form form-group" style="display:none">
                    <div class="col-sm-12"><label class="label">If transferee</label></div>
                    <div class="col-sm-8">
                        <input type="text" name="name_of_school" class="form form-control" placeholder="Name of School" value="{{$list->school}}">
                    </div>
                    <div class="col-sm-4">
                        <input type="text" name="prev_course" class="form form-control" placeholder="Course/Strand" value="{{$list->prev_course}}">
                    </div>
                </div>
                @if ($value==1)
                <div class="form form-group">
                    <div class="col-sm-6">
                        <input type="hidden" name="is_exam" value="1">
                        <label class="label">Entrance Exam Schedule</label>
                        <select name="exam_date" id="exam_date" class='form form-control'>
                            <option value=''>Choose Entrance Exam Schedule</option>
                            @foreach ($dates as $date)
                            <option value='{{$date->id}}'
                                    @if ($date->id==$exam->exam_schedule) selected='selected' @endif
                                    >{{ date ('M d, Y (D) - g:i A', strtotime($date->datetime))}} - {{$date->place}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-sm-6">
                        <label class="label">Exam Result</label><br>
                        <select @if($list->status>=2)disabled="disabled" @else @endif class="form form-control" name="exam_result[{{$list->idno}}]" onchange="changevalue('{{$list->idno}}', this.value)">
                                 <option value="">Not Yet Graded</option>
                            <option value="Passed"
                                    @if($exam->exam_result == "Passed")
                                    selected="selected"
                                    @endif>Passed</option>
                            <option value="Failed"
                                    @if($exam->exam_result == "Failed")
                                    selected="selected"
                                    @endif>Failed</option>
                        </select>
                    </div>
                </div>
                @else 
                <input type="hidden" name="is_exam" value="0">
                @endif
                <div class="form form-group">
                    <div class="col-sm-12">
                        <input type="submit" name="submit" value="Modify Student Profile" class="form form-control btn btn-primary">    
                    </div>    
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    function changevalue(idno, value) {
        $.ajax({
            type: "GET",
            url: "/guidance/ajax/changevalue/" + idno + "/" + value,
            data: "",
            success: function (data) {
            }
        });
//        alert(idno + " " +value);
    }

    function displayinput() {
        $('#transferee').show();
    }
    function hideinput() {
        $('#transferee').hide();
    }
</script>
@stop
