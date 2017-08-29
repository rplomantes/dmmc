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
            .totalfee{font-size:20pt;color:red;font-weight: bold}
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
                    <div class="row">
                        <div class='col-sm-12'>
                            <div id="imaginary_container">
                                <h3>Registration Summary</h3>
                                <div class="form form-group">
                                    {{$idno}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </body>
</html>
