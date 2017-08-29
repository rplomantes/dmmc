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
            $special_discounts = \App\CtrSpecialDiscount::where('program_code', $status->program_code)->where('level', $status->level)->get();
            $list_plans = \App\CtrDueDate::distinct()->where('academic_type', $status->academic_type)->get(['plan']);
            $discounts=  \App\CtrDiscount::get();
            
            if($status->academic_type == "College") {
                $grades = \App\GradeCollege::where('idno', $idno)->where('school_year', $school_year->school_year)->where('period', $school_year->period)->get();
            } elseif($status->academic_type == "Senior High School") {
                $grades = \App\GradeShs::where('idno', $idno)->where('school_year', $school_year->school_year)->where('period', $school_year->period)->get();
            }
            ?>

            <input type="hidden" id="idno" value="{{$idno}}">
            <input type="hidden" id="level" value="{{$status->level}}">
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
                            
                                @if($status->academic_type == "College")
                                <li>{{$status->program_name}} </li><li>{{$status->level}} Year</li>
                                @elseif($status->academic_type == "Senior High School") 
                                {{$status->type}}
                                @endif
                            </ul>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="col-sm-12">
                                <h4>Subject Registered:</h4>

                                @if($status->academic_type == "College")
                               
                                
                                
                                <table class="table table-condensed">
                                    <thead>
                                    <th>Subject Code</th>
                                    <th>Subject Name</th>
                                    <th>Lec</th>
                                    <th>Lab</th>
                                    <th>Units</th>
                                    </thead>
                                    <?php
                                    $totalLec = 0;
                                    $totalLab = 0;
                                    $totalUnits = 0;
                                    ?>
                                    @foreach ($grades as $grade)
                                    <tr>
                                        <td>{{$grade->course_code}}</td>
                                        <td>{{$grade->course_name}}</td>
                                        <td>@if ($grade->lec==0) @else {{$grade->lec}} @endif <?php $totalLec = $grade->lec + $totalLec; ?></td>
                                        <td>@if ($grade->lab==0) @else {{$grade->lab}} @endif <?php $totalLab = $grade->lab + $totalLab; ?></td>
                                        <td>{!!$grade->lec + $grade->lab!!}</td>
                                    </tr>
                                    @endforeach
                                    <tr>
                                        <td></td>
                                        <th><div align='right'>Total</div> </th> 
                                        <th><?php echo $totalLec; ?></th>
                                        <th><?php if ($totalLab != 0) {
                                        echo $totalLab;
                                    } ?>
                                        </th>
                                        <th><?php $totalUnits = $totalUnits + $totalLec + $totalLab; ?> {!! $totalLec + $totalLab !!}</th>
                                    </tr>
                                </table>


                                @else
                                <table class="table table-condensed">SHS</table>
                                @endif


                            </div>
                            <div class="col-sm-12">
                                <h4>Payment Options:</h4>
                                @if ($status->academic_type == "College")
                                <form class="form-horizontal">
                                    <div class="form form-group">
                                        <div class="col-sm-12">

                                            <label class="label">Select Type of Account </label>
                                            <select id="type_of_account" class="form form-control">
                                                <option value="">Select Type of Account</option>
                                                <option value="regular">Regular</option>
                                                 @if(count($special_discounts)>0)
                                                    @foreach($special_discounts as $sd)
                                                    <option value="{{$sd->special_discount_code}}">{{$sd->special_discount_code}}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                        
<!--                                        <div class="col-sm-6">
                                            <label class="label">Select Plan </label>
                                            <select id="plan" class="form form-control">
                                                <option value="">Full Payment</option>
                                                @if(count($list_plans)>0)
                                                    @foreach($list_plans as $plan)
                                                      <option value="{{$plan->paln}}">{{$plan->plan}}</option>
                                                    @endforeach
                                                @endif
                                            </select>    
                                        </div>-->
                                        
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


                                @else
                                <table class="table table-condensed">SHS</table>
                                @endif


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
                array['level'] = $("#level").val();
                array['period'] = $("#period").val();
                array['school_year'] = $("#school_year").val();
                array['type_of_account'] = $("#type_of_account").val();
                array['program_code'] = $("#program_code").val();
                array['academic_type'] = $("#academic_type").val();
                array['discount']=$("#ddiscount").val();
                $.ajax({
                    type: "GET",
                    url: "/registrar/ajax/assessment/computePayment",
                    data: array,
                    success: function (data) {
                        $('#paymentsummary').empty();
                        $('#paymentsummary').html(data);
                       // $('#process_assessment').html("<div class='col-sm-12 btn btn-success'>Process Assessment</div>").show();
                    }

                });
            }
        </script>
        <script src="{{ asset('js/app.js') }}"></script>
        <script src="{{ asset('js/jquery-1.12.4.js') }}"></script>
        <script src="{{ asset('js/jquery-ui.js') }}"></script>
    </body>
</html>
