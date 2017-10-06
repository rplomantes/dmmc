@extends('layouts.registrarapp')
@section('content')
<?php
$user = \App\User::where('idno', $idno)->first();
$student_info = \App\StudentInfo::where('idno', $idno)->first();
$getfather = \App\Family::where('idno', $idno)->where('family_role', "Father")->first();
$getmother = \App\Family::where('idno', $idno)->where('family_role', "Mother")->first();
?>
<style>
    .label{color: gray;}
</style>
<div class="row">
    <div class="col-sm-12">
        <div id="imaginary_container"> 
            <div class="panel-group" id="accordion">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <div align="center">STUDENT INFORMATION</div>
                        </h4>
                    </div>
                </div>
                <form method="post" action="{{url('registrar', array('update_profile'))}}">
                    {{ csrf_field() }}
                    <input type="hidden" name="idno" value="{{$idno}}">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <a data-toggle="collapse" data-parent="#accordion" href="#personalinformation">
                                    PERSONAL INFORMATION</a>
                            </h4>
                        </div>
                        <div id="personalinformation" class="panel-collapse collapse">
                            <div class="panel-body">
                                <table class="table table-condensed">
                                    <tr>
                                        <td><label class="label">Lastname</label><input class="form form-control" type="text" value="{{$user->lastname}}" name="lastname" placeholder="Lastname"></td>
                                        <td><label class="label">Firstname</label><input class="form form-control" type="text" value="{{$user->firstname}}" name="firstname" placeholder="Firstname"></td>
                                        <td><label class="label">Middlename</label><input class="form form-control" type="text" value="{{$user->middlename}}" name="middlename" placeholder="Middlename"></td>
                                        <td><label class="label">Extension Name</label><input class="form form-control" type="text" value="{{$user->extensionname}}" name="extensionname" placeholder="Extensionname"></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2"><label class="label">No. & Street, Brgy, Town/City, Province</label><input class="form form-control" type="text" value="{{$student_info->address}}" name="address" placeholder="No. & Street, Brgy, Town/City, Province"></td>
                                        <td><label class="label">Contact Number:</label><input class="form form-control" type="text" value="{{$student_info->contact_no}}" name="contact_no" placeholder="Contact Number"></td>
                                        <td><label class="label">LRN:</label><input class="form form-control" type="text" value="{{$student_info->lrn}}" name="lrn" placeholder="LRN"></td>
                                    </tr>
                                    <tr>
                                        <td><label class="label">Date of Birth</label><input class="form form-control" type="text" value="{{$student_info->birthdate}}" onchange='getAge()' id="datepicker" name="birthdate" placeholder="yyyy/mm/dd"></td>
                                        <td><label class="label">Age</label><input class="form form-control" type="text" placeholder="Age" id='age'></td>
                                        <td><label class="label">Place of Birth</label><input class="form form-control" type="text" value="{{$student_info->place_of_birth}}" name="place_of_birth" placeholder="Place of Birth"></td>
                                        <td><label class="label">Citizenship</label><input class="form form-control" type="text" value="{{$student_info->citizenship}}" name="citizenship" placeholder="Citizenship"></td>
                                    </tr>
                                    <tr>
                                        <td><label class="label">Civil Status</label>
                                            <select name="civil_status" class="form form-control">
                                                <option value="single" @if ($student_info->civil_status== 'single')
                                                        selected='selected'
                                                        @endif>Single</option>
                                                <option value="married"@if ($student_info->civil_status== 'married')
                                                        selected='selected'
                                                        @endif>Married</option>
                                                <option value="divorced"@if ($student_info->civil_status== 'divorced')
                                                        selected='selected'
                                                        @endif>Divorced</option>
                                                <option value="widowed"@if ($student_info->civil_status== 'widowed')
                                                        selected='selected'
                                                        @endif>Widowed</option>
                                            </select>
                                        </td>
                                        <td><label class="label">Religion</label><input class="form form-control" type="text" value="{{$student_info->religion}}" name="religion" placeholder="Religion"></td>   
                                        <td><label class="label">Gender</label>
                                            <select name="gender" class="form form-control">
                                                <option value="Male" @if ($student_info->gender== 'Male')
                                                        selected='selected'
                                                        @endif>Male</option>
                                                <option value="Female"@if ($student_info->gender== 'Female')
                                                        selected='selected'
                                                        @endif>Female</option>
                                            </select>
                                        </td>
                                        <td><label class="label">Email Address</label><input class="form form-control" type="email" value="{{$user->email}}" name="email" placeholder="Email Address" required=""></td>                                
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <a data-toggle="collapse" data-parent="#accordion" href="#fbackground">
                                    FAMILY BACKGROUND</a>
                            </h4>
                        </div>
                        <div id="fbackground" class="panel-collapse collapse">
                            <div class="panel-body">
                                <table class="table table-condensed">
                                    <tr>
                                        <td>
                                            <label class="label">Father</label>
                                            <input type="hidden" @if(count($getfather)>0) value="{{$getfather->id}}" @else value="" @endif name="father_id">
                                                   <input class="form form-control" name="father_name" @if(count($getfather)>0) value="{{$getfather->name}}" @else value="" @endif placeholder="Father's Name">
                                        </td>
                                        <td>
                                            <label class="label">Mother</label>
                                            <input type="hidden" @if(count($getmother)>0) value="{{$getmother->id}}" @else value="" @endif name="mother_id">
                                                   <input class="form form-control" name="mother_name" @if(count($getmother)>0) value="{{$getmother->name}}" @else value="" @endif placeholder="Mother's Name">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <label class="label">Birthdate</label>
                                            <input class="form form-control" name="father_bday" @if(count($getfather)>0) value="{{$getfather->birthdate}}" @else value="" @endif placeholder="yyyy-mm-dd">
                                        </td>
                                        <td>
                                            <label class="label">Birthdate</label>
                                            <input class="form form-control" name="mother_bday" @if(count($getmother)>0) value="{{$getmother->birthdate}}" @else value="" @endif placeholder="yyyy-mm-dd">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <label class="label">Occupation/Employer</label>
                                            <input class="form form-control" name="father_occupation" @if(count($getfather)>0) value="{{$getfather->occupation}}" @else value="" @endif placeholder="Father's Occupation">
                                        </td>
                                        <td>
                                            <label class="label">Occupation/Employer</label>
                                            <input class="form form-control" name="mother_occupation" @if(count($getmother)>0) value="{{$getmother->occupation}}" @else value="" @endif placeholder="Mother's Occupation">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <label class="label">Monthly Income</label>
                                            <input class="form form-control" name="father_income" @if(count($getfather)>0) value="{{$getfather->income}}" @else value="" @endif placeholder="Father's Monthly Income">
                                        </td>
                                        <td>
                                            <label class="label">Monthly Income</label>
                                            <input class="form form-control" name="mother_income" @if(count($getmother)>0) value="{{$getmother->income}}" @else value="" @endif placeholder="Mother's Monthly Income">
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <a data-toggle="collapse" data-parent="#accordion" href="#ebackground">
                                    EDUCATIONAL BACKGROUND</a>
                            </h4>
                        </div>
                        <div id="ebackground" class="panel-collapse collapse">
                            <div class="panel-body">
                                <table class="table table-condensed">
                                    <tr>
                                        <td><label class="label">Primary</label><input class="form form-control" name="pri_school" value="{{$student_info->pri_school}}" placeholder="School"></td>
                                        <td><label class="label"> </label><input class="form form-control" name="pri_address" value="{{$student_info->pri_address}}" placeholder="Address"></td>
                                        <td><label class="label"> </label><input class="form form-control" name="pri_from" value="{{$student_info->pri_from}}" placeholder="From"></td>
                                        <td><label class="label"> </label><input class="form form-control" name="pri_to" value="{{$student_info->pri_to}}" placeholder="To"></td>
                                        <td><label class="label"> </label><input class="form form-control" name="pri_degree" value="{{$student_info->pri_degree}}" placeholder="Degree/Major"></td>
                                    </tr>
                                    <tr>
                                        <td><label class="label">Secondary</label><input class="form form-control" name="sec_school" value="{{$student_info->sec_school}}" placeholder="School"></td>
                                        <td><label class="label"> </label><input class="form form-control" name="sec_address" value="{{$student_info->sec_address}}" placeholder="Address"></td>
                                        <td><label class="label"> </label><input class="form form-control" name="sec_from" value="{{$student_info->sec_from}}" placeholder="From"></td>
                                        <td><label class="label"> </label><input class="form form-control" name="sec_to" value="{{$student_info->sec_to}}" placeholder="To"></td>
                                        <td><label class="label"> </label><input class="form form-control" name="sec_degree" value="{{$student_info->sec_degree}}" placeholder="Degree/Major"></td>
                                    </tr>
                                    <tr>
                                        <td><label class="label">Tertiary</label><input class="form form-control" name="ter_school" value="{{$student_info->ter_school}}" placeholder="School"></td>
                                        <td><label class="label"> </label><input class="form form-control" name="ter_address" value="{{$student_info->ter_address}}" placeholder="Address"></td>
                                        <td><label class="label"> </label><input class="form form-control" name="ter_from" value="{{$student_info->ter_from}}" placeholder="From"></td>
                                        <td><label class="label"> </label><input class="form form-control" name="ter_to" value="{{$student_info->ter_to}}" placeholder="To"></td>
                                        <td><label class="label"> </label><input class="form form-control" name="ter_degree" value="{{$student_info->ter_degree}}" placeholder="Degree/Major"></td>
                                    </tr>
                                    <tr>
                                        <td><label class="label">Vocational</label><input class="form form-control" name="voc_school" value="{{$student_info->voc_school}}" placeholder="School"></td>
                                        <td><label class="label"> </label><input class="form form-control" name="voc_address" value="{{$student_info->voc_address}}" placeholder="Address"></td>
                                        <td><label class="label"> </label><input class="form form-control" name="voc_from" value="{{$student_info->voc_from}}" placeholder="From"></td>
                                        <td><label class="label"> </label><input class="form form-control" name="voc_to" value="{{$student_info->voc_to}}" placeholder="To"></td>
                                        <td><label class="label"> </label><input class="form form-control" name="voc_degree" value="{{$student_info->voc_degree}}" placeholder="Degree/Major"></td>
                                    </tr>
                                    <tr>
                                        <td><label class="label">Others</label><input class="form form-control" name="oth_school" value="{{$student_info->oth_school}}" placeholder="School"></td>
                                        <td><label class="label"> </label><input class="form form-control" name="oth_address" value="{{$student_info->oth_address}}" placeholder="Address"></td>
                                        <td><label class="label"> </label><input class="form form-control" name="oth_from" value="{{$student_info->oth_from}}" placeholder="From"></td>
                                        <td><label class="label"> </label><input class="form form-control" name="oth_to" value="{{$student_info->oth_to}}" placeholder="To"></td>
                                        <td><label class="label"> </label><input class="form form-control" name="oth_degree" value="{{$student_info->oth_degree}}" placeholder="Degree/Major"></td>
                                    </tr>
                                </table>
                                <table class="table table-condensed">
                                    <tr>
                                        <td><label class="label">Academic Honors/Awards Received</label><input class="form form-control" name="pri_awards" value="{{$student_info->pri_awards}}" placeholder="Primary"></td>
                                        <td><label class="label"> </label><input class="form form-control" name="pri_awards_year" value="{{$student_info->pri_awards_year}}" placeholder="School/Year"></td>
                                    </tr>
                                    <tr>
                                        <td><label class="label">Academic Honors/Awards Received</label><input class="form form-control" name="sec_awards" value="{{$student_info->sec_awards}}" placeholder="Secondary"></td>
                                        <td><label class="label"> </label><input class="form form-control" name="sec_awards_year" value="{{$student_info->sec_awards_year}}" placeholder="School/Year"></td>
                                    </tr>
                                    <tr>
                                        <td><label class="label">Academic Honors/Awards Received</label><input class="form form-control" name="ter_awards" value="{{$student_info->ter_awards}}" placeholder="Tertiary"></td>
                                        <td><label class="label"> </label><input class="form form-control" name="ter_awards_year" value="{{$student_info->ter_awards_year}}" placeholder="School/Year"></td>
                                    </tr>
                                </table>
                                <table class="table table-condensed">
                                    <tr>
                                        <td><label class="label">Position/Leadership held in Schools Attended</label><input class="form form-control" name="pri_lead" value="{{$student_info->pri_lead}}" placeholder="Primary"></td>
                                        <td><label class="label"> </label><input class="form form-control" name="pri_lead_year" value="{{$student_info->pri_lead_year}}" placeholder="School/Year"></td>
                                    </tr>
                                    <tr>
                                        <td><label class="label">Position/Leadership held in Schools Attended</label><input class="form form-control" name="sec_lead" value="{{$student_info->sec_lead}}" placeholder="Secondary"></td>
                                        <td><label class="label"> </label><input class="form form-control" name="sec_lead_year" value="{{$student_info->sec_lead_year}}" placeholder="School/Year"></td>
                                    </tr>
                                    <tr>
                                        <td><label class="label">Position/Leadership held in Schools Attended</label><input class="form form-control" name="ter_lead" value="{{$student_info->ter_lead}}" placeholder="Tertiary"></td>
                                        <td><label class="label"> </label><input class="form form-control" name="ter_lead_year" value="{{$student_info->ter_lead_year}}" placeholder="School/Year"></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <a data-toggle="collapse" data-parent="#accordion" href="#others">
                                    OTHER INFORMATION</a>
                            </h4>
                        </div>
                        <div id="others" class="panel-collapse collapse">
                            <div class="panel-body">
                                <table class="table table-condensed">
                                    <tr>
                                        <td colspan="2"><label class="label">Courses Applied</label><input class="form form-control" name="course1" value="{{$student_info->course1}}" readonly="" placeholder="First Choice"></td>
                                        <td colspan="2"><label class="label"> </label><input class="form form-control" name="course2" value="{{$student_info->course2}}" readonly="" placeholder="Second Choice"></td>
                                    </tr>
                                    <tr>
                                        <td colspan="4"><label class="label">What are your hobbies?</label><input class="form form-control" name="hobbies" value="{{$student_info->hobbies}}" placeholder="Hobbies"></td>
                                    </tr>
                                    <tr>
                                        <td colspan="4"><label class="label">What sports do you play?</label><input class="form form-control" name="sports" value="{{$student_info->sports}}" placeholder="Sports"></td>
                                    </tr>
                                    <tr>
                                        <td colspan="4"><label class="label">What special talents do you have?</label><input class="form form-control" name="talents" value="{{$student_info->talents}}" placeholder="Talents"></td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <label class="label">In case of emergency</label>
                                            <input class="form form-control" name="emergency_contact_person" value="{{$student_info->emergency_contact_person}}" placeholder="Contact Person">
                                        </td>
                                        <td>
                                            <label class="label"> </label>
                                            <input class="form form-control" name="emergency_relationship" value="{{$student_info->emergency_relationship}}" placeholder="Relationship">
                                        </td>
                                        <td>
                                            <label class="label"> </label>
                                            <input class="form form-control" name="emergency_address" value="{{$student_info->emergency_address}}" placeholder="Address">
                                        </td>
                                        <td>
                                            <label class="label"> </label>
                                            <input class="form form-control" name="emergency_contact_no" value="{{$student_info->emergency_contact_no}}" placeholder="Tel./Mobile No.">
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <a data-toggle="collapse" data-parent="#accordion" href="#otherrequirements">
                                    ADMISSION CREDENTIALS</a>
                            </h4>
                        </div>
                        <div id="otherrequirements" class="panel-collapse collapse">
                            <div class="panel-body">
                                <table class="table table-condensed">
                                    <tr>
                                        <td colspan="2">
                                            <label class="label">Form 138</label>
                                            <select class="form form-control" name="form_138">
                                                <option @if($student_info->form_138 == 0) selected="selected" @endif value="0">Not yet submitted</option>
                                                <option @if($student_info->form_138 == 1) selected="selected" @endif value="1">Submitted</option>
                                            </select>
                                        </td>
                                        <td colspan="2">
                                            <label class="label">Form 137</label>
                                            <select class="form form-control" name="form_137">
                                                <option @if($student_info->form_137 == 0) selected="selected" @endif value="0">Not yet submitted</option>
                                                <option @if($student_info->form_137 == 1) selected="selected" @endif value="1">Submitted</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            <label class="label">Birth Certificate</label>
                                            <select class="form form-control" name="psa_birth_cert">
                                                <option @if($student_info->psa_birth_cert == 0) selected="selected" @endif value="0">Not yet submitted</option>
                                                <option @if($student_info->psa_birth_cert == 1) selected="selected" @endif value="1">Submitted</option>
                                            </select>
                                        </td>
                                        <td colspan="2">
                                            <label class="label">Good Moral</label>
                                            <select class="form form-control" name="good_moral">
                                                <option @if($student_info->good_moral == 0) selected="selected" @endif value="0">Not yet submitted</option>
                                                <option @if($student_info->good_moral == 1) selected="selected" @endif value="1">Submitted</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            <label class="label">Transfer Credentials</label>
                                            <select class="form form-control" name="transfer_credential">
                                                <option @if($student_info->transfer_credential == 0) selected="selected" @endif value="0">Not yet submitted</option>
                                                <option @if($student_info->transfer_credential == 1) selected="selected" @endif value="1">Submitted</option>
                                            </select>
                                        </td>
                                        <td colspan="2">
                                            <label class="label">Married Certificate</label>
                                            <select class="form form-control" name="married_cert">
                                                <option @if($student_info->married_cert == 0) selected="selected" @endif value="0">Not yet submitted</option>
                                                <option @if($student_info->married_cert == 1) selected="selected" @endif value="1">Submitted</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            <label class="label">ID Pictures</label>
                                            <select class="form form-control" name="id_picture">
                                                <option @if($student_info->id_picture == 0) selected="selected" @endif value="0">Not yet submitted</option>
                                                <option @if($student_info->id_picture == 1) selected="selected" @endif value="1">Submitted</option>
                                            </select>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!--                
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <h4 class="panel-title">
                                                <a data-toggle="collapse" data-parent="#accordion" href="#home">
                                                    LOCATION/HOME</a>
                                            </h4>
                                        </div>
                                        <div id="home" class="panel-collapse collapse">
                                            <div class="panel-body">
                                                <table class="table">
                                                </table>
                                            </div>
                                        </div>
                                    </div>-->
            </div>
            <button class="btn btn-success" type="submit">Save</button> <a href="{{url('registrar', array('printstudentprofile', $idno))}}" target="_blank"  class="btn btn-primary">Print</a>
            </form>
        </div>
    </div>
</div>

<script>
    function getAge() {
        var bdate = document.getElementById("datepicker").value;
        var date1 = new Date(bdate);
        var date2 = new Date();
        var timeDiff = Math.abs(date2.getYear() - date1.getYear());
        var month = 0;
        if (date2.getMonth() < date1.getMonth()) {
            timeDiff = timeDiff - 1;
            month = 12 - date1.getMonth();
            month = month + date2.getMonth();
        } else {
            month = date2.getMonth() - date1.getMonth();
        }
        document.getElementById("age").value = timeDiff + "." + month;
    }
    window.onload = getAge();
</script>
@stop
