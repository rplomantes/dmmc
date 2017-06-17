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
                    <div id="collapseOne" class="panel-collapse collapse in">
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
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo"><span class="fa fa-child fa-fw">
                            </span> K-12 Department</a>
                        </h4>
                    </div>
                    <div id="collapseTwo" class="panel-collapse collapse">
                        <div class="panel-body">
                            <table class="table">
                                <tr>
                                    <td>
                                        <a href="#"><i class="fa fa-pencil fa-fw" aria-hidden="true"></i> Registration</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <a href="#"><i class="fa fa-flag fa-fw" aria-hidden="true"></i> Reports</a>
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
                            </span> College Department</a>
                        </h4>
                    </div>
                    <div id="collapseThree" class="panel-collapse collapse">
                        <div class="panel-body">
                            <table class="table">
                                <tr>
                                    <td>
                                        <a href="#"><i class="fa fa-book fa-fw" aria-hidden="true"></i> Curriculum</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <a href="#"><i class="fa fa-exchange fa-fw" aria-hidden="true"></i> Course Offering</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <a href="#"><i class="fa fa-pencil fa-fw" aria-hidden="true"></i> Registration</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <a href="#"><i class="fa fa-list fa-fw" aria-hidden="true"></i> List of Students</a>
                                    </td>
                                <tr>
                                    <td>
                                        <a href="#"><i class="fa fa-flag fa-fw" aria-hidden="true"></i> Reports</a>
                                    </td>
                                </tr>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapseFour"><span class="fa fa-star fa-fw">
                            </span> Special Courses</a>
                        </h4>
                    </div>
                    <div id="collapseFour" class="panel-collapse collapse">
                        <div class="panel-body">
                            <table class="table">
                                <tr>
                                    <td>
                                        <a href="#"><i class="fa fa-pencil fa-fw" aria-hidden="true"></i> Registration</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <a href="#"><i class="fa fa-exchange fa-fw" aria-hidden="true"></i> Course Offering</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <a href="#"><i class="fa fa-flag fa-fw" aria-hidden="true"></i> Reports</a>
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
</body>
</html>