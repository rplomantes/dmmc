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
    </div>
<div class="col-sm-12">
    <div class="well">

<div class="row">
    <div class='col-sm-8'>
    <h3>Student List</h3>
        <div class="form-horizontal">
            <div class="form form-group">
                <div class="col-sm-4">
                    <label class="label">Select Course </label>
                    <select id="program_code" class="form form-control">
                        <option value="">Select Course</option>
                        @foreach ($program_codes as $program_code)
                        <option value="{{$program_code->program_code}}">{{$program_code->program_name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-sm-4">
                    <label class="label">Select Level </label>
                    <select id="level" class="form form-control" onchange="getsubjectlist()">
                        <option value="">Select Level</option>
                        @foreach ($levels as $level)
                        <option value="{{$level->level}}">{{$level->level}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-sm-4">
                    <label class="label">Search </label>
                    <input type="text" class="form form-control" id="search"> 
                </div>
            </div>
        </div>
    </div>
    <div class='col-sm-offset-6'> 
    </div>
</div>
<div class='row'>
    <div class='col-sm-12'>
            <div id="subjectlist">
            </div>
    </div>
</div>
    </div>
</div>
<script>                
    $("#search").keypress(function(e){
            if (e.keyCode == 13){
            array = {}
            array['academic_program'] = "{{$academic_program}}";
            array['search'] = $("#search").val();
            $.ajax({
            type:"GET",
                    url:"/registrar/ajax/studentlist/getsubjectlistpersearchtesda",
                    data:array,
                    success:function(data){
                        $('#subjectlist').empty();
                        $('#subjectlist').html(data);
                    }

            });
        }
    });
            
    function getsubjectlist(){
        array = {};
        array['academic_program'] = "{{$academic_program}}";
        array['level'] = $("#level").val();
        array['program_code'] = $("#program_code").val();
        $.ajax({
            type: "GET",
            url: "/registrar/ajax/studentlist/getsubjectlisttesda",
            data: array,
            success: function (data) {
                $('#subjectlist').empty();
                $('#subjectlist').html(data);
            }

        });
    }
</script>
<script src="{{ asset('js/app.js') }}"></script>
</body>
</html>