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

        <!--Jquery -->
        <script src="{{ asset('js/jquery.js') }}"></script>

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
                    $curriculum_years = \App\Curriculum::distinct()->where('program_code', $program_code)->where('is_current', 1)->get(['curriculum_year']);
                    $program_name = \App\CtrAcademicProgram::where('program_code', $program_code)->first(['program_name']);
                    ?>

                    <style>
                        .label{color: gray;}
                    </style>

                    <div class="row">
                        <div class='col-sm-12'>
                            <div id="imaginary_container">
                                <form class="form-horizontal" role="form">
                                    {{ csrf_field() }}
                                    <div class="form form-group">
                                        <div class="col-sm-12">
                                            <h4>Course Offering</h4>
                                            <h4>{{$program_name->program_name}}</h4>
                                        </div>
                                    </div>
                                    <div class='form-group'>
                                        <div class='col-sm-3'>
                                            <label class='label'>Curriculum Year</label>
                                            <select class='form form-control' id="curriculum_year" name='curriculum_year'>
                                                <option value=''>Select Curriculum Year</option>
                                                @foreach($curriculum_years as $curriculum_year)
                                                <option value='{{$curriculum_year->curriculum_year}}'>{{$curriculum_year->curriculum_year}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class='col-sm-3'>
                                            <label class='label'>Level</label>
                                            <select class='form form-control' id="level" name='level'>
                                                <option value=''>Select Level</option>
                                                <option value='1st'>1st</option>
                                                <option value='2nd'>2nd</option>
                                                <option value='3rd'>3rd</option>
                                                <option value='4th'>4th</option>
                                            </select>
                                        </div>
                                        <div class='col-sm-3'>
                                            <label class='label'>Period</label>
                                            <select class='form form-control' id="period" name='period'>
                                                <option value=''>Select Period</option>
                                                <option value='1st'>1st Semester</option>
                                                <option value='2nd'>2nd Semester</option>
                                                <option value='Summer'>Summer</option>
                                            </select>
                                        </div>
                                        <div class='col-sm-3'>
                                            <label class='label'>Section</label>
                                            <select class='form form-control' id="section" name='section' onchange="getList(level.value, period.value, curriculum_year.value, '{{$program_code}}', section.value)">
                                                <option value="">Select Section</option>
                                                <option value='1'>Section 1</option>
                                                <option value='2'>Section 2</option>
                                                <option value='3'>Section 3</option>
                                                <option value='4'>Section 4</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class='form-group'>
                                        <div class='col-sm-4' id='course'>
                                        </div>
                                        <div class='col-sm-8' id='course_offered'>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <script>
                        function getList(level, period, curriculum_year, program_code, section){
                        $.ajax({
                        type: "GET",
                                url: "/registrar/ajax/getlist/" + program_code + "/" + curriculum_year + "/" + period + "/" + level,
                                success: function (data) {
                                $('#course').html(data);
                                }

                        });
                        getCourseOffered(level, period, curriculum_year, program_code, section);
                        }

                        function getCourseOffered(level, period, curriculum_year, program_code, section){
                        $.ajax({
                        type: "GET",
                                url: "/registrar/ajax/getcourseoffered/" + program_code + "/" + curriculum_year + "/" + period + "/" + level + "/" + section,
                                success: function (data) {
                                $('#course_offered').html(data);
                                }

                        });
                        }
                    </script>
                </div>
            </div>
        </div>
    </body>
</html>