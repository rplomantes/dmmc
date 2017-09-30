@extends('layouts.registrarapp')
@section('content')
<?php
$user = \App\User::where('idno', $idno)->first();
$status = \App\Status::where('idno', $idno)->first();
$student_info = \App\StudentInfo::where('idno', $idno)->first();
$school_year = \App\CtrSchoolYear::where('academic_type', $status->academic_type)->first();
?>
<div class="row">
    <div class='col-sm-12'>
        <div id="imaginary_container">
            <div class="form form-group col-sm-12">
                <h3>Student Information</h3>
                <table class='table table-condensed'>
                    <tr>
                        <td>ID No</td>
                        <td><b>{{$idno}}</b></td>
                    </tr>
                    <tr>
                        <td>Name</td>
                        <td>{{$user->firstname}} {{$user->middlename}} {{$user->lastname}} {{$user->extensionname}}</td>
                    </tr>
                    <tr>
                        <td>Address</td>
                        <td>{{$student_info->address}}</td>
                    </tr>
                    <tr>
                        <td>Birth Date</td>
                        <td>{{$student_info->birthdate}}</td>
                    </tr>
                    <tr>
                        <td>Gender</td>
                        <td>{{$student_info->gender}}</td>
                    </tr>
                    <tr>
                        <td>Civil Status</td>
                        <td>{{$student_info->civil_status}}</td>
                    </tr>
                    <tr>
                        <td>Contact Number</td>
                        <td>{{$student_info->contact_no}}</td>
                    </tr>
                    <tr>
                        <td>Email Address</td>
                        <td>{{$user->email}}</td>
                    </tr>
                    <tr>
                        @if ($status->academic_type!=="Senior High School")
                        <td>Course</td>
                        <td>{{$status->program_name}}</td>
                        @else
                        <td>Strand</td>
                        <td>{{$status->track}}</td>
                        @endif
                    </tr>
                </table>
                
                <table class="table table-condensed">
                    @if ($status->status <= 4)
                    <tr>
                        <td class="col-sm-6"><a href="{{url('registrar',array('reassess',$idno))}}"><div class='btn btn-danger col-sm-12'>Re-assess Student</div></a></td>
                        <td class="col-sm-6"><a href="{{url('registrar',array('print_registration_form',$idno))}}" target="_blank"><div class='btn btn-success col-sm-12'>Print Registration Form</div></a></td>
                    </tr>
                    @else
                    <tr>
                        <td class="col-sm-12"><a href="{{url('registrar',array('print_registration_form',$idno))}}" target="_blank"><div class='btn btn-success col-sm-12'>Print Registration Form</div></a></td>
                    </tr>
                    @endif
                </table>
             
            </div>
        </div>
    </div>
</div>
@stop

