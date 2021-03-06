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
            <?php
            $user = \App\User::where('idno', $idno)->first();
            $status = \App\Status::where('idno', $idno)->first();
            $studentinfo = \App\StudentInfo::where('idno', $idno)->first();
            $school_year = \App\CtrSchoolYear::where('academic_type', $status->academic_type)->first();
            $esc = \App\CtrEsc::get();
            $list_plans = \App\CtrDueDate::distinct()->where('academic_type', $status->academic_type)->get(['plan']);
            $discounts = \App\CtrDiscount::get();

            $y = \App\CtrGradeSchoolYear::where('academic_type', $status->academic_type)->first();
            $periods = \App\GradeShs::distinct()->where('idno', $idno)->where('school_year', $school_year->school_year)->orderBy('period')->get(['period']);
            ?>

            <input type="hidden" id="idno" value="{{$idno}}">
            <input type="hidden" id="school_year" value="{{$school_year->school_year}}">
            <input type="hidden" id="period" value="{{$school_year->period}}">
            <input type="hidden" id="program_code" value="{{$status->program_code}}">
            <input type="hidden" id="academic_type" value="{{$status->academic_type}}">

            <div class="col-sm-12">
                <div class="well">
                    <div class="row">
                        <div class="col-sm-12">
                            <h3>Assessment</h3>
                            <ul class="nav navbar-header"><li><strong>{{strtoupper($user->lastname)}} {{$user->extensionname}}, {{$user->firstname}} {{$user->middlename}}</strong></li>

                                <li>{{$status->track}} </li><li>{{$status->level}}</li>

                            </ul>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="col-sm-12">
                                <?php
                                $levels = \App\CtrAcademicProgram::distinct()->where('academic_type', "Senior High School")->get(['level']);
                                $tracks = \App\CtrAcademicProgram::distinct()->where('academic_type', "Senior High School")->get(['track']);
                                ?>
                                <div class="form form-horizontal">
                                    <div class="form form-group">
                                        <div class="col-sm-6">
                                            <label class="label">Level </label>
                                            <select id="levelf" class="form form-control">
                                                <option value="">Select Level</option>
                                                @foreach ($levels as $levelf)
                                                <option value="{{$levelf->level}}">{{$levelf->level}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-sm-6">
                                            <label class="label">Strand </label>
                                            <select id="trackf" class="form form-control" onchange="addsubjectRegistered(levelf.value, this.value)">
                                                <option value="">Select Strand</option>
                                                @foreach ($tracks as $trackf)
                                                <option value="{{$trackf->track}}">{{$trackf->track}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <h4>Subject Registered:</h4>
                                <div id="subjectregistered">
                                    
                                </div>
                            </div>

                            <div class="col-sm-12">
                                <h4>Payment Options:</h4>
                                <form class="form-horizontal">
                                    <div class="form form-group">
                                        <div class="col-sm-12">

                                            <label class="label">Voucher </label>
                                            <select id="esc" class="form form-control">
                                                <option value="">Please select Voucher type</option>
                                                @if(count($esc)>0)
                                                @foreach($esc as $escs)
                                                <option value="{{$escs->id}}">{{$escs->type}}</option>
                                                @endforeach
                                                @endif
                                            </select>
                                        </div>

                                        <div class="col-sm-12">
                                            <label class="label">Discount </label>
                                            <select id="discount" class="form form-control">
                                                <option value="">None</option>

                                                @if(count($discounts)>0)
                                                @foreach($discounts as $sd)
                                                <option value="{{$sd->discount_code}}">{{$sd->discount_description}}</option>
                                                @endforeach
                                                @endif
                                            </select>    
                                        </div>

                                    </div>    
                                    <div class="form form-group">
                                        <div class="col-sm-12">
                                            <div class="col-sm-12 btn btn-primary" onclick="computePayment()">Compute Payments</div>   
                                        </div>    
                                    </div>
                                </form>

                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="col-sm-12">
                                <h4>Payment Summary:</h4>
                                <div id="paymentsummary">

                                </div>
                            </div>
                        </div><hr>
                        <div class='row'>
                            <div class='col-sm-12' id='process_assessment'>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <script>
                function computePayment() {
                    array = {};
                    array['idno'] = $("#idno").val();
                    array['plan'] = $("#plan").val();
                    array['level'] = $("#levelf").val();
                    array['period'] = $("#period").val();
                    array['school_year'] = $("#school_year").val();
                    array['esc'] = $("#esc").val();
                    array['program_code'] = $("#program_code").val();
                    array['track'] = $("#trackf").val();
                    array['academic_type'] = $("#academic_type").val();
                    array['discount'] = $("#discount").val();
                    $.ajax({
                        type: "GET",
                        url: "/registrar/ajax/assessment/computePaymentshs",
                        data: array,
                        success: function (data) {
                            $('#paymentsummary').empty();
                            $('#paymentsummary').html(data);
                            // $('#process_assessment').html("<div class='col-sm-12 btn btn-success'>Process Assessment</div>").show();
                        }

                    });
                }
                function addsubjectRegistered(levelf, trackf) {
                    array = {};
                    array['idno'] = $("#idno").val();
                    array['period'] = $("#period").val();
                    array['school_year'] = $("#school_year").val();
                    $.ajax({
                        type: "GET",
                        url: "/registrar/ajax/addtogradeshs/" + levelf + '/' + trackf,
                        data:array,
                        success: function (data) {
                            $("#subjectregistered").html(data);
                        }
                    });
                }
                function removesubject(subjectid){
                    array = {};
                    array['idno'] = $("#idno").val();
                    array['period'] = $("#period").val();
                    array['school_year'] = $("#school_year").val();
                    array['period'] = $("#period").val();
                    $.ajax({
                        type: "GET",
                        url: "/registrar/ajax/removegradeshs/" + subjectid,
                        data:array,
                        success: function (data) {
                            $("#subjectregistered").html(data);
                        }
                    });
                }
            </script>
            <script src="{{ asset('js/app.js') }}"></script>
            <script src="{{ asset('js/jquery-1.12.4.js') }}"></script>
            <script src="{{ asset('js/jquery-ui.js') }}"></script>
    </body>
</html>
