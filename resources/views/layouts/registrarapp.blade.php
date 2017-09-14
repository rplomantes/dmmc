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


        </div>
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-3 col-md-3">
                    <div class="panel-group" id="accordion">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h4 class="panel-title">
                                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne"><span class="fa fa-user-circle fa-fw">
                                        </span> Registrar</a>
                                </h4>
                            </div>
                            <div id="collapseOne" class="panel-collapse collapse">
                                <div class="panel-body">
                                    <table class="table">
                                        <tr>
                                            <td>
                                                <a href="{{url('/')}}"><i class="fa fa-home fa-fw" aria-hidden="true"></i> Home</a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <a href="#"><i class="fa fa-bell fa-fw" aria-hidden="true"></i> Notifications</a>
                                                <span class="badge">42</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <a href="{{url('/registrar/profile')}}"><i class="fa fa-user fa-fw" aria-hidden="true"></i> User Profile</a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <a href="#"><i class="fa fa-lock fa-fw" aria-hidden="true"></i> Change Password</a>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h4 class="panel-title">
                                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo"><span class="fa fa-check-square fa-fw">
                                        </span> Assessment</a>
                                </h4>
                            </div>
                            <div id="collapseTwo" class="panel-collapse collapse">
                                <div class="panel-body">
                                    <table class="table">
                                        <tr>
                                            <td>
                                                <a href="{{url('registrar', array('assessment','college'))}}"><span class="fa fa-check-square fa-fw"></span> Assessment - College/TESDA</a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <a href="{{url('registrar', array('assessment','shs'))}}"><span class="fa fa-check-square fa-fw"></span> Assessment - SHS</a>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                        
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h4 class="panel-title">
                                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseThree"><span class="fa fa-university fa-fw">
                                        </span> Course Management - College</a>
                                </h4>
                            </div>
                            <div id="collapseThree" class="panel-collapse collapse">
                                <div class="panel-body">
                                    <table class="table">
                                        <tr>
                                            <td>
                                                <a href="{{url('registrar', array('view_curriculum','college'))}}"><i class="fa fa-book fa-fw" aria-hidden="true"></i> View Curriculum</a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <a href="{{url('registrar', array('course_offering','college'))}}"><i class="fa fa-exchange fa-fw" aria-hidden="true"></i> Subject Offering</a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <a href="{{url('registrar', array('course_scheduling','college'))}}"><i class="fa fa-exchange fa-fw" aria-hidden="true"></i> Subject Schedules</a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <a href="{{url('registrar', array('assign_instructor','college'))}}"><i class="fa fa-exchange fa-fw" aria-hidden="true"></i> Assign Instructor</a>
                                            </td>
                                        </tr>
<!--                                        <tr>
                                            <td>
                                                <a href="{{url('registrar', array('reports','college'))}}"><i class="fa fa-bar-chart-o fa-fw" aria-hidden="true"></i> Reports</a>
                                            </td>
                                        </tr>-->
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h4 class="panel-title">
                                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseFour"><span class="fa fa-university fa-fw">
                                        </span> Course Management - SHS</a>
                                </h4>
                            </div>
                            <div id="collapseFour" class="panel-collapse collapse">
                                <div class="panel-body">
                                    <table class="table">
                                        <tr>
                                            <td>
                                                <a href="{{url('registrar', array('view_curriculum','shs'))}}"><i class="fa fa-book fa-fw" aria-hidden="true"></i> View Curriculum</a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <a href="{{url('registrar', array('course_offering','shs'))}}"><i class="fa fa-exchange fa-fw" aria-hidden="true"></i> Subject Offering</a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <a href="{{url('registrar', array('course_scheduling','shs'))}}"><i class="fa fa-exchange fa-fw" aria-hidden="true"></i> Subject Schedules</a>
                                            </td>
                                        </tr>
<!--                                        <tr>
                                            <td>
                                                <a href="{{url('registrar', array('assign_instructor','shs'))}}"><i class="fa fa-exchange fa-fw" aria-hidden="true"></i> Assign Instructor</a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <a href="{{url('registrar', array('reports','shs'))}}"><i class="fa fa-bar-chart-o fa-fw" aria-hidden="true"></i> Reports</a>
                                            </td>
                                        </tr>-->
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h4 class="panel-title">
                                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseFive"><span class="fa fa-graduation-cap fa-fw">
                                        </span> Grades</a>
                                </h4>
                            </div>
                            <div id="collapseFive" class="panel-collapse collapse">
                                <div class="panel-body">
                                    <table class="table">
                                        <tr>
                                            <td>
                                                <a href="{{url('/registrar/import_grades/college')}}"><i class="fa fa-upload fa-fw" aria-hidden="true"></i> Import Grades - College/TESDA</a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <a href="{{url('/registrar/import_grades/shs')}}"><i class="fa fa-upload fa-fw" aria-hidden="true"></i> Import Grades - SHS</a>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                        
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h4 class="panel-title">
                                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseSix"><span class="fa fa-group fa-fw">
                                        </span> Sectioning</a>
                                </h4>
                            </div>
                            <div id="collapseSix" class="panel-collapse collapse">
                                <div class="panel-body">
                                    <table class="table">
                                        <tr>
                                            <td>
                                                <a href="{{url('/setup/shs')}}"><i class="fa fa-group fa-fw" aria-hidden="true"></i> Set up Sections</a>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                </div>
                <div class="col-sm-9 col-md-9">
                    <div class="well">
                        @yield('content')
                    </div>
                </div>
            </div>
        </div>
        <script src="{{ asset('js/app.js') }}"></script>
        <script src="{{ asset('js/jquery-1.12.4.js') }}"></script>
        <script src="{{ asset('js/jquery-ui.js') }}"></script>
    </body>

</html>