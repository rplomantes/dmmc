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

            @if ($status->academic_type !=="Senior High School")

                @if (count($levels)>0)
                <br>
                <div class="row">
                    <div class="col-sm-7">
                        <h3>Curriculum Summary</h3>
                        @foreach($levels as $level)
                        @if ($level->level== '1st') FIRST YEAR @elseif ($level->level== '2nd') SECOND YEAR @elseif ($level->level== '3rd') THIRD YEAR @elseif ($level->level== '4th') FOURTH YEAR @elseif ($level->level== '5th') FIFTH YEAR @else @endif - 
                        @if ($level->period== '1st') 1st Semester @elseif ($level->period== '2nd') 2nd Semester @elseif ($level->period== 'Summer') Summer @else @endif
                        <?php

                        $courses = \App\Curriculum::where('curriculum_year', $student_info->curriculum_year)
                                ->where('level', $level->level)
                                ->where('program_code', $status->program_code)
                                ->where('period', $level->period)
                                ->get(['course_code', 'course_name']);

                        ?>
                        <table class='table table-condensed'>
                            <thead>
                            <th class="col-sm-1">Subject Code</th>
                            <th class="col-sm-4">Subject Name</th>
                            <th class="col-sm-1">Remarks</th>
                            </thead>
                            @foreach($courses as $course)
                        <?php

                        $grade = \App\GradeCollege::where('idno', $idno)->where('course_code', $course->course_code)->get();

                        ?>
                            <tr>
                                <td>{{$course->course_code}}</td>
                                <td>{{$course->course_name}}</td>
                                <td>@foreach ($grade as $grades){{$grades->remarks}}@endforeach</td>
                            </tr>
                            @endforeach
                        </table>
                        @endforeach
                    </div>

                    <div class="col-sm-5">
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
            @else
            
            Senior High School
            @endif
        </div>
    </div>
</div>
@stop
