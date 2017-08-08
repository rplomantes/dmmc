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
            <div class="col-sm-12">
                <div class="well">
                    <?php
                    $user = \App\User::where('idno', $idno)->first();
                    $student_info = \App\StudentInfo::where('idno', $idno)->first();
                    $academic_type = \App\Status::distinct()->where('idno', $idno)->get(array('academic_type'))->first();
                    ?>
                    <div class="col-sm-12"><h3>Assessment</h3></div>
                    <div class="row">
                        <div class="col-sm-6">
                            <table class='table table-condensed'>
                                <tr>
                                    <td>ID No</td>
                                    <td><b>{{$idno}}</b></td>
                                </tr>
                                <tr>
                                    <td>Name: </td>
                                    <td>{{$user->firstname}} {{$user->middlename}} {{$user->lastname}} {{$user->extensionname}}</td>
                                </tr>
                                <tr>
                                    <td>Level & Section</td>
                                    <td>{{$status->level}} - {{$status->section}}</td>
                                </tr>
                                <tr>
                                    <td>Strand</td>
                                    <td>{{$status->track}}</td>
                                </tr>
                            </table>
                        </div>

                        <?php
                        $tuition = \App\CtrShsTuition::where('track', $status->track)->where('level', $status->level)->first();
                        ?>
                        <div class='col-sm-6'>
                            <table class="table table-condensed">
                                <tr>
                                    <td>Tuition Fee:</td> 
                                    <td>{{$tuition->amount}}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div class="row">
                        <div class='col-sm-6'>
                            subjects:
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/jquery-1.12.4.js') }}"></script>
    <script src="{{ asset('js/jquery-ui.js') }}"></script>
</body>
</html>
