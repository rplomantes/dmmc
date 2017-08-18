@extends('layouts.registrarapp')
@section('content')

<div class="row">
    <div class="col-sm-12">
        <div id="imaginary_container"> 
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
                <tr>
                    <td>Section</td>
                    <td>{{$user->section}}</td>
                </tr>

            </table>
            <a href=""><div class='btn btn-success col-sm-12'>Modify Student Profile</div></a>

            @if (count($grades)>0)
            <br>
            <div class="row">
                <div class="col-sm-6">
                    <h3>Grade Summary</h3>
                    <table class='table table-condensed'>
                        <thead>
                        <th>Subject Code</th>
                        <th>Subject Name</th>
                        <th>Final Grade</th>
                        <th>Grade Point</th>
                        </thead>
                        @foreach($grades as $grade)
                        <tr>
                            <td>{{$grade->course_code}}</td>
                            <td>{{$grade->course_name}}</td>
                            <td>{{$grade->final_grade}}</td>
                            <td>{{$grade->grade_point}}</td>
                        </tr>
                        @endforeach
                    </table>
                </div>
                <div class="col-sm-6">
                    <h3>Attendance</h3>
                    <table class='table table-condensed' border="1">
                        <thead>
                        <th></th>
                        <th>Prelim</th>
                        <th>Midterm</th>
                        <th>Finals</th>
                        <th>Total</th>
                        </thead>
                        <tr>
                            <td>Times Present</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>Times Absent</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>Times Tardy</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <th>Total</th>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                    </table>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@stop
