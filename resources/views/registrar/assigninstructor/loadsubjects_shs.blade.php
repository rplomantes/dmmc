<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>DMMCIHS School Management System</title>

        <!-- Styles -->
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <link href="{{ asset('css/customize.css') }}" rel="stylesheet">
        <link href="{{ asset('css/font-awesome.css') }}" rel="stylesheet">
        <link href="{{ asset('css/jquery-ui.css') }}" rel="stylesheet">
        <!--Jquery -->
        <script src="{{ asset('js/jquery.js') }}"></script>
<style>
    .label{color: gray;}
</style>
    </head>
    <body>
        <div id="app">
            <nav class="navbar navbar-default navbar-static-top">
                <div class="container">
                    <div class="navbar-header">

                        <!-- Collapsed Hamburger -->
                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                            <span class="sr-only">Toggle Navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>

                        <!-- Branding Image -->

                        <a class="navbar-brand" href="{{ url('/') }}">
                            <div style="color:#fff">DMMC INSTITUTE OF HEALTH SCIENCES</div>
                        </a>
                    </div>

                    <div class="collapse navbar-collapse" id="app-navbar-collapse">
                        <!-- Left Side Of Navbar -->
                        <ul class="nav navbar-nav">
                            &nbsp;
                        </ul>

                        <!-- Right Side Of Navbar -->
                        <ul class="nav navbar-nav navbar-right">
                            <!-- Authentication Links -->
                            @if (Auth::guest())

                            @else
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" style="color:#fff">
                                    <i class="fa fa-user fa-fw"></i>  {{ Auth::user()->lastname }}, {{ Auth::user()->firstname}} 
                                </a>

                                <!--<ul class="dropdown-menu" role="menu">-->
                            <li>
                                <a href="{{ route('logout') }}"
                                   onclick="event.preventDefault();
    document.getElementById('logout-form').submit();">
                                    <span style="color:#fff"><i class="fa fa-sign-out fa-fw"></i> Logout</span>
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    {{ csrf_field() }}
                                </form>
                            </li>
                            <!--</ul>-->
                            </li>
                            @endif
                        </ul>
                    </div>
                </div>
            </nav>
            
                <div class="col-sm-12">
                    <div class="well">


<?php
$school_year = \App\CtrSchoolYear::where('academic_type', 'Senior High School')->first();
$loads = \App\CourseOffering::where('instructor_id', $user->id)->where('school_year', $school_year->school_year)->where('period', $school_year->period)->get();

$courses = \App\CourseOffering::distinct()->where('school_year', $school_year->school_year)->where('period', $school_year->period)->where('program_code', 'Senior High School')->get(['track']);
?>

<div class="row">
    <div class='col-sm-12'>
        <h4>Load Subjects to:</h4>
        <h3><b>Prof. {{$user->firstname}} {{$user->middlename}} {{$user->lastname}} {{$user->extensionname}}</b></h3>
        <div id="imaginary_container">

            <input type="hidden" id="school_year" value="{{$school_year->school_year}}">
            <input type="hidden" id="period" value="{{$school_year->period}}">
            <input type="hidden" id="instructor_id" value="{{$user->id}}">

            <!-- topleft -->
            <div class="col-sm-12">
                <div class="col-sm-2">
                    <label class="label">Course</label>
                    <select id="track" class="form form-control">
                        <option value="">Strand</option>
                        @foreach($courses as $course)
                        <option>{{$course->track}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-sm-2">
                    <label class="label">Level</label>
                    <select id="level" class="form form-control">
                        <option value="">Level</option>
                        <option value="Grade 11">Grade 11</option>
                        <option value="Grade 12">Grade 12</option>
                    </select>
                </div>
                <div class="col-sm-2">
                    <label class="label">Section</label>
                    <select id="section" class="form form-control" onchange="loadcourseoffering()">
                        <option value="">Section</option>
                        <option value="1">Section 1</option>
                        <option value="2">Section 2</option>
                        <option value="3">Section 3</option>
                        <option value="4">Section 4</option>
                    </select>
                </div>
            </div>

            <div class="col-sm-12"><br>
                <!--lower left-->
                <div class="col-sm-6" id="course_offering">
                </div>
                <!--right-->
                <div class="col-sm-6" id="existingloads">
                    Loads:
                    @if (count($loads)>0)
                    <table class="table table-condensed">
                        <thead>
                        <th class="col-sm-2">Subject Name</th>
                        <th class="col-sm-3">Section</th>
                        <th class="col-sm-3">Schedule</th>
                        <th class="col-sm-3">Room</th>
                        <th class="col-sm-1">Remove</th>
                        </thead>
                        <tbody>
                            @foreach($loads as $load)
                            <tr>
                                <td>
                                    <?php
                                    $schedules = \App\Schedule::where('course_offering_id', $load->id)->get();
                                    ?>
                                    {{$load->course_name}}

                                </td>
                                <td>
                                    {{$load->program_code}}<br>{{$load->level}} year - section {{$load->section}}
                                </td>
                                <td>
                                    <?php
                                    $schedule2s = \App\Schedule::distinct()->where('course_offering_id', $load->id)->get(['time_start', 'time_end', 'room']);
                                    ?>
                                    @foreach ($schedule2s as $schedule2)
                                    <?php
                                    $days = \App\Schedule::where('course_offering_id', $load->id)->where('time_start', $schedule2->time_start)->where('time_end', $schedule2->time_end)->where('room', $schedule2->room)->get(['day']);
                                    ?>
                                    @foreach ($days as $day){{$day->day}}@endforeach {{date('g:i A', strtotime($schedule2->time_start))}} - {{date('g:i A', strtotime($schedule2->time_end))}} <br>
                                    <!--{{$schedule2->day}} {{$schedule2->time_start}} - {{$schedule2->time_end}}<br>-->
                                    @endforeach
                                </td>
                                <td>
                                    <?php
                                    $schedule3s = \App\Schedule::distinct()->where('course_offering_id', $load->id)->get(['time_start', 'time_end', 'room']);
                                    ?>
                                    @foreach ($schedule3s as $schedule3)
                                    {{$schedule3->room}}<br>
                                    @endforeach
                                </td>
                                <td>
                                    <a href="javascript:void(0)" onclick="removeload('{{$load->id}}')">Remove</a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @else
                    <br><div class="alert alert-danger">No Subject Loaded!!</div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
<script>

    function loadcourseoffering() {
    array = {};
    array['track'] = $("#track").val();
    array['level'] = $("#level").val();
    array['section'] = $("#section").val();
    array['school_year'] = $("#school_year").val();
    array['period'] = $("#period").val();
    $.ajax({
    type: "GET",
            url: "/registrar/ajax/get_courseoffering_shs",
            data: array,
            success: function (data) {
            $('#course_offering').html(data);
            }

    });
    }

    function addloadcourse(id) {
    array = {};
    array['instructor_id'] = $("#instructor_id").val();
    $.ajax({
    type: "GET",
            url: "/registrar/ajax/add_coursetoinstructor_shs/" + id,
            data: array,
            success: function (data) {
            $('#existingloads').html(data);
            loadcourseoffering()
            }

    });
    }

    function removeload(id) {
    array = {};
    array['instructor_id'] = $("#instructor_id").val();
    $.ajax({
    type: "GET",
            url: "/registrar/ajax/remove_coursetoinstructor_college/" + id,
            data: array,
            success: function (data) {
            $('#existingloads').html(data);
            loadcourseoffering()
            }

    });
    }
</script>
</div>
                </div>
            </div>
        </div>
        <script src="{{ asset('js/app.js') }}"></script>
        <script src="{{ asset('js/jquery-1.12.4.js') }}"></script>
        <script src="{{ asset('js/jquery-ui.js') }}"></script>
    </body>
</html>