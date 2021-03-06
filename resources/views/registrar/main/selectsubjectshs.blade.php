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

<?php
$idno=$request->idno;
$program_name=  \App\CtrAcademicProgram::where('track',$request->track)->first()->program_name;
$user = \App\User::where('idno',$idno)->first();
$info = \App\StudentInfo::where('idno',$idno)->first();
$status = \App\Status::where('idno',$idno)->first();
$school_year= \App\CtrSchoolYear::where('academic_type',$status->academic_type)->first();
$sections =  \App\CourseOffering::distinct()->where('track',$request->track)->where('level',$request->level)
            ->get(['section']);
?>
<h3>Select Subject to Register</h3>
<table class="table table-condensed">
    <tr><td>Reference No</td><td><span class = "label label-danger">{{$idno}}</span></td></tr>
    <tr><td>Student Name</td><td><strong>{{$user->lastname}}, {{$user->firstname}} {{$user->middlename}} {{$user->extensionname}}</strong></td></tr>
    <tr><td>Contact Number</td><td>{{$info->contact_no}}</td></tr>
    <tr><td>Email Address</td><td>{{$user->email}}</td></tr>            
    <tr><td colspan="2"><strong>Registered To:</strong></tr></tr>
    <tr><td>Level</td><td><strong style="color:red">{{$request->level}}</strong></td></tr>
    <tr><td>Track</td><td><strong style="color:red">{{$request->track}}</strong></td></tr>
    <tr><td colspan="2"></td></tr>                        
    <tr><td width="50%">
    <div class="form form-group"> 
      <h5>Subject Offerings:</h5>  
        <div class="col-sm-6">
            <label>Select Section</label>
                <input type="hidden" id="school_year" value="{{$school_year->school_year}}">
                <input type="hidden" id="period" value="{{$school_year->period}}">
                <input type="hidden" id="program_code" value="{{$request->program_code}}">
                <input type="hidden" id="level" value="{{$request->level}}">
                <input type="hidden" id="track" value="{{$request->track}}">
                <select class="form form-control" id="section">
                  <option>Select Section</option>  
                 @foreach($sections as $section)
                    <option value="{{$section->section}}">{{$section->section}}</option>
                 @endforeach
                </select>    
        </div>    
        <div class="col-sm-6">
            <label>Search Subject</label>
            <input type="text" class="form form-control" id="search"> 
        </div>
        </div> 
        
            <div id="offerings" >    
            </div>   
        
    
        </td><td>
            <div class="col-sm-12">
                <h5>Subject to Enroll:</h5>
                <div id="student_course">
                <?php
                    $grade_shs=  \App\GradeShs::where('idno',$idno)->where('school_year',$school_year->school_year)->where('period',$school_year->period)->get();
                    $hours=0;
                ?>
                @if(count($grade_shs)>0)
                <table class="table table-condensed"><tr><td>Subject</td><td>Period</td><td>Hours</td><td>Schedule/Room</td><td>Instructor</td><td>Remove</td></tr>
                    @foreach($grade_shs as $grade_hs)
                    <?php
                    $hours = $hours+$grade_hs->hours;
                    ?>
                        <tr><td>{{$grade_hs->course_name}}</td><td>{{$grade_hs->period}}</td>
                            <td>{{$grade_hs->hours}}</td><td></td><td></td><td><a href="javascript: void(0);" onclick="removesubject('{{$grade_hs->id}}')">Remove</a></td></tr>
                    @endforeach
                    <tr><td colspan="2">Total Hours</td><td colspan="4">{{$hours}}</td></tr>
                </table>
                @else
                    No Subject Selected Yet!!
                @endif
                </div>
            </div>
        </td>
    </tr>
</table>
<div class="form form-group">
    <div class="col-sm-12">
    <form class="form form-horizontal" action="{{url('registrar',array('main','registersubjects'))}}" method="POST">    
    {{ csrf_field() }}
    <input type="hidden" name="idno" value="{{$idno}}">
    <input type="submit" class="btn btn-danger form-control" id="registersubject" value="REGISTER SUBJECTS" />
    </form>
    </div>    
</div>    
</div>
<script src="{{ asset('js/app.js') }}"></script>
<script>
$("#search").keypress(function(e){
   if(e.keyCode==13){
       array={}
       array['idno']="{{$idno}}";
       array['school_year']=$("#school_year").val();
       array['period']=$("#period").val();
       array['track']=$("#track").val();
       array['level']=$("#level").val();
       array['search']=$("#search").val();
       $.ajax({
        type:"GET",
        url:"/dean/ajax/getofferingpersearchshs",
        data:array,
        success:function(data){
            $("#offerings").html(data);
        }
            
    });
   } 
});    
$("#section").change(function(){
    array={};
    array['idno']="{{$idno}}";
    array['school_year']=$("#school_year").val();
    array['period']=$("#period").val();
    array['track']=$("#track").val();
    array['level']=$("#level").val();
    array['section']=$("#section").val();
    
    $.ajax({
        type:"GET",
        url:"/dean/ajax/getofferingpersectionshs",
        data:array,
        success:function(data){
            $("#offerings").html(data);
        }
            
    });
});

function addtogradeshs(idno, offeringid){
    array={};
    array['idno']=idno;
    array['offeringid']=offeringid;
    
    $.ajax({
        type:"GET",
        url:"/dean/ajax/addtogradeshs",
        data:array,
        success:function(data){
            $("#student_course").html(data);
        }
    })
}

function removesubject(id){
    array={};
    array['id']=id;
    array['idno']="{{$idno}}";
    array['school_year']=$("#school_year").val();
    array['period']=$("#period").val();
    if(confirm("Are You Sure To Remove?")){
    $.ajax({
        type:"GET",
        url:"/dean/ajax/removesubjectshs",
        data:array,
        success:function(data){
            $("#student_course").html(data);
        }
    })
    }
}

function addallsubjects(){
    array={};
    array['idno']="{{$idno}}";
    array['school_year']=$("#school_year").val();
    array['period']=$("#period").val();
    array['track']=$("#track").val();
    array['level']=$("#level").val();
    array['section']=$("#section").val();
   // if( confirm("Are You Sure To Add All Subjects?"){
    $.ajax({
        type:"GET",
        url:"/dean/ajax/addallsubjectsshs",
        data:array,
        success:function(data){
            $("#student_course").html(data);
        }
    })
    //}
    
}
</script>
</body>
</html>

