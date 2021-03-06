@extends('layouts.registrarapp')
@section('content')
<style>
    .label{color: gray;}
</style>
<?php
$school_year_shs = \App\CtrSchoolYear::where('academic_type', "Senior High School")->first();
$list_shs = \App\CtrAcademicProgram::distinct()->where('academic_type', "Senior High School")->get(['track']);
$totalSHS = 0;

$school_year_college = \App\CtrSchoolYear::where('academic_type', "College")->first();
$list_college = \App\CtrAcademicProgram::distinct()->where('academic_type', "College")->get(['academic_program']);
$totalCollege = 0;

$school_year_tesda = \App\CtrSchoolYear::where('academic_type', "TESDA")->first();
$list_tesda = \App\CtrAcademicProgram::distinct()->where('academic_type', "TESDA")->get(['academic_program']);
$totalTesda = 0;
?>
<div class="row">
    <div class='col-sm-12'>
        <div id="imaginary_container">
            
            <!--shs-->
            <table class="table table-condensed">
                <thead>
                    <tr>
                        <th width="30%"><h3>Senior High School</h3></th>
                        <th colspan="2">Grade 11</th>
                        <th colspan="2">Grade 12</th>
                        <th width="10%">Total</th>
                    </tr>
                    <tr  style="background-color: #ddd">
                        <th></th>
                        <th>M</th>
                        <th>F</th>
                        <th>M</th>
                        <th>F</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($list_shs as $listshs)
                    <?php
                    $gr11m = \App\Status::where('status', 4)->where('statuses.school_year', $school_year_shs->school_year)->where('statuses.level', 'Grade 11')->where('academic_type', "Senior High School")->join('student_infos', 'student_infos.idno', '=', 'statuses.idno')->where('student_infos.gender', 'Male')->where('statuses.track', $listshs->track)->get();
                    $gr11f = \App\Status::where('status', 4)->where('statuses.school_year', $school_year_shs->school_year)->where('statuses.level', 'Grade 11')->where('academic_type', "Senior High School")->join('student_infos', 'student_infos.idno', '=', 'statuses.idno')->where('student_infos.gender', 'Female')->where('statuses.track', $listshs->track)->get();
                    $gr12m = \App\Status::where('status', 4)->where('statuses.school_year', $school_year_shs->school_year)->where('statuses.level', 'Grade 12')->where('academic_type', "Senior High School")->join('student_infos', 'student_infos.idno', '=', 'statuses.idno')->where('student_infos.gender', 'Male')->where('statuses.track', $listshs->track)->get();
                    $gr12f = \App\Status::where('status', 4)->where('statuses.school_year', $school_year_shs->school_year)->where('statuses.level', 'Grade 12')->where('academic_type', "Senior High School")->join('student_infos', 'student_infos.idno', '=', 'statuses.idno')->where('student_infos.gender', 'Female')->where('statuses.track', $listshs->track)->get();
                    ?>
                    <tr>
                        <td>{{$listshs->track}}</td>
                        <td>@if(count($gr11m)>0) {{count($gr11m)}}@endif</td>
                        <td>@if(count($gr11f)>0) {{count($gr11f)}}@endif</td>
                        <td>@if(count($gr12m)>0) {{count($gr12m)}}@endif</td>
                        <td>@if(count($gr12f)>0) {{count($gr12f)}}@endif</td>
                        <td>{{count($gr11m)+count($gr11f)+count($gr12m)+count($gr12f)}}<?php $totalSHS = $totalSHS + count($gr11m)+count($gr11f)+count($gr12m)+count($gr12f); ?></td>
                    </tr>
                    @endforeach
                    <tr>
                        <th colspan="5">Total</th>
                        <th>{{$totalSHS}}</th>
                    </tr>
                </tbody>
            </table>
            
            <!--college-->
            <table class="table table-condensed">
                <thead>
                    <tr>
                        <th width="30%"><h3>College</h3></th>
                        <th colspan="2">1st Year</th>
                        <th colspan="2">2nd Year</th>
                        <th colspan="2">3rd Year</th>
                        <th colspan="2">4th Year</th>
                        <th colspan="2">5th Year</th>
                        <th width="10%">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($list_college as $listcollege)
                    <tr  style="background-color: #ddd">
                        <th>{{$listcollege->academic_program}}</th>
                        <th>M</th>
                        <th>F</th>
                        <th>M</th>
                        <th>F</th>
                        <th>M</th>
                        <th>F</th>
                        <th>M</th>
                        <th>F</th>
                        <th>M</th>
                        <th>F</th>
                        <th></th>
                    </tr>
                    <?php
                    $programs = \App\CtrAcademicProgram::distinct()->where('academic_program', $listcollege->academic_program)->get(['program_code']);
                    
                    $totalperProgram = 0;
                    ?>
                    @foreach($programs as $program)
                    
                    <?php
                    $firstm = \App\Status::where('status', 4)->where('statuses.school_year', $school_year_college->school_year)->where('statuses.period', $school_year_college->period)->where('statuses.level', '1st')->where('academic_type', "College")->join('student_infos', 'student_infos.idno', '=', 'statuses.idno')->where('student_infos.gender', 'Male')->where('statuses.program_code', $program->program_code)->get();
                    $firstf = \App\Status::where('status', 4)->where('statuses.school_year', $school_year_college->school_year)->where('statuses.period', $school_year_college->period)->where('statuses.level', '1st')->where('academic_type', "College")->join('student_infos', 'student_infos.idno', '=', 'statuses.idno')->where('student_infos.gender', 'Female')->where('statuses.program_code', $program->program_code)->get();
                    $secondm = \App\Status::where('status', 4)->where('statuses.school_year', $school_year_college->school_year)->where('statuses.period', $school_year_college->period)->where('statuses.level', '2nd')->where('academic_type', "College")->join('student_infos', 'student_infos.idno', '=', 'statuses.idno')->where('student_infos.gender', 'Male')->where('statuses.program_code', $program->program_code)->get();
                    $secondf = \App\Status::where('status', 4)->where('statuses.school_year', $school_year_college->school_year)->where('statuses.period', $school_year_college->period)->where('statuses.level', '2nd')->where('academic_type', "College")->join('student_infos', 'student_infos.idno', '=', 'statuses.idno')->where('student_infos.gender', 'Female')->where('statuses.program_code', $program->program_code)->get();
                    $thirdm = \App\Status::where('status', 4)->where('statuses.school_year', $school_year_college->school_year)->where('statuses.period', $school_year_college->period)->where('statuses.level', '3rd')->where('academic_type', "College")->join('student_infos', 'student_infos.idno', '=', 'statuses.idno')->where('student_infos.gender', 'Male')->where('statuses.program_code', $program->program_code)->get();
                    $thirdf = \App\Status::where('status', 4)->where('statuses.school_year', $school_year_college->school_year)->where('statuses.period', $school_year_college->period)->where('statuses.level', '3rd')->where('academic_type', "College")->join('student_infos', 'student_infos.idno', '=', 'statuses.idno')->where('student_infos.gender', 'Female')->where('statuses.program_code', $program->program_code)->get();
                    $fourthm = \App\Status::where('status', 4)->where('statuses.school_year', $school_year_college->school_year)->where('statuses.period', $school_year_college->period)->where('statuses.level', '4th')->where('academic_type', "College")->join('student_infos', 'student_infos.idno', '=', 'statuses.idno')->where('student_infos.gender', 'Male')->where('statuses.program_code', $program->program_code)->get();
                    $fourthf = \App\Status::where('status', 4)->where('statuses.school_year', $school_year_college->school_year)->where('statuses.period', $school_year_college->period)->where('statuses.level', '4th')->where('academic_type', "College")->join('student_infos', 'student_infos.idno', '=', 'statuses.idno')->where('student_infos.gender', 'Female')->where('statuses.program_code', $program->program_code)->get();
                    $fifthm = \App\Status::where('status', 4)->where('statuses.school_year', $school_year_college->school_year)->where('statuses.period', $school_year_college->period)->where('statuses.level', '5th')->where('academic_type', "College")->join('student_infos', 'student_infos.idno', '=', 'statuses.idno')->where('student_infos.gender', 'Male')->where('statuses.program_code', $program->program_code)->get();
                    $fifthf = \App\Status::where('status', 4)->where('statuses.school_year', $school_year_college->school_year)->where('statuses.period', $school_year_college->period)->where('statuses.level', '5th')->where('academic_type', "College")->join('student_infos', 'student_infos.idno', '=', 'statuses.idno')->where('student_infos.gender', 'Female')->where('statuses.program_code', $program->program_code)->get();
                    ?>
                    <tr>
                        <td>{{$program->program_code}}</td>
                        <td>@if(count($firstm)>0) {{count($firstm)}}@endif</td>
                        <td>@if(count($firstf)>0) {{count($firstf)}}@endif</td>
                        <td>@if(count($secondm)>0) {{count($secondm)}}@endif</td>
                        <td>@if(count($secondf)>0) {{count($secondf)}}@endif</td>
                        <td>@if(count($thirdm)>0) {{count($thirdm)}}@endif</td>
                        <td>@if(count($thirdf)>0) {{count($thirdf)}}@endif</td>
                        <td>@if(count($fourthm)>0) {{count($fourthm)}}@endif</td>
                        <td>@if(count($fourthf)>0) {{count($fourthf)}}@endif</td>
                        <td>@if(count($fifthm)>0) {{count($fifthm)}}@endif</td>
                        <td>@if(count($fifthf)>0) {{count($fifthf)}}@endif</td>
                        <td><?php $totalNow = count($firstm)+count($firstf)+count($secondm)+count($secondf)+count($thirdm)+count($thirdf)+count($fourthm)+count($fourthf)+count($fifthm)+count($fifthf); $totalperProgram = $totalperProgram+$totalNow;?>{{$totalNow}}</td>
                    </tr>
                    @endforeach
                    <tr>
                        <th colspan="11">Total</th>
                        <th>{{$totalperProgram}}</th>
                    </tr>
                    <?php $totalCollege = $totalperProgram + $totalCollege; ?>
                    @endforeach
                </tbody>
            </table>
            
            <!--tesda-->
            <table class="table table-condensed">
                <thead>
                    <tr>
                        <th width="30%"><h3>TESDA</h3></th>
                        <th colspan="2">1st Year</th>
                        <th colspan="2">2nd Year</th>
                        <th width="10%">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($list_tesda as $listtesda)
                    <tr  style="background-color: #ddd">
                        <th>{{$listtesda->academic_program}}</th>
                        <th>M</th>
                        <th>F</th>
                        <th>M</th>
                        <th>F</th>
                        <th></th>
                    </tr>
                    <?php
                    $programs = \App\CtrAcademicProgram::distinct()->where('academic_program', $listtesda->academic_program)->get(['program_code']);
                    
                    $totalperProgram = 0;
                    ?>
                    @foreach($programs as $program)
                    
                    <?php
                    $firstm = \App\Status::where('status', 4)->where('statuses.school_year', $school_year_tesda->school_year)->where('statuses.period', $school_year_tesda->period)->where('statuses.level', '1st')->where('academic_type', "TESDA")->join('student_infos', 'student_infos.idno', '=', 'statuses.idno')->where('student_infos.gender', 'Male')->where('statuses.program_code', $program->program_code)->get();
                    $firstf = \App\Status::where('status', 4)->where('statuses.school_year', $school_year_tesda->school_year)->where('statuses.period', $school_year_tesda->period)->where('statuses.level', '1st')->where('academic_type', "TESDA")->join('student_infos', 'student_infos.idno', '=', 'statuses.idno')->where('student_infos.gender', 'Female')->where('statuses.program_code', $program->program_code)->get();
                    $secondm = \App\Status::where('status', 4)->where('statuses.school_year', $school_year_tesda->school_year)->where('statuses.period', $school_year_tesda->period)->where('statuses.level', '2nd')->where('academic_type', "TESDA")->join('student_infos', 'student_infos.idno', '=', 'statuses.idno')->where('student_infos.gender', 'Male')->where('statuses.program_code', $program->program_code)->get();
                    $secondf = \App\Status::where('status', 4)->where('statuses.school_year', $school_year_tesda->school_year)->where('statuses.period', $school_year_tesda->period)->where('statuses.level', '2nd')->where('academic_type', "TESDA")->join('student_infos', 'student_infos.idno', '=', 'statuses.idno')->where('student_infos.gender', 'Female')->where('statuses.program_code', $program->program_code)->get();
                    ?>
                    <tr>
                        <td>{{$program->program_code}}</td>
                        <td>@if(count($firstm)>0) {{count($firstm)}}@endif</td>
                        <td>@if(count($firstf)>0) {{count($firstf)}}@endif</td>
                        <td>@if(count($secondm)>0) {{count($secondm)}}@endif</td>
                        <td>@if(count($secondf)>0) {{count($secondf)}}@endif</td>
                        <td><?php $totalNow = count($firstm)+count($firstf)+count($secondm)+count($secondf); $totalperProgram = $totalperProgram+$totalNow;?>{{$totalNow}}</td>
                    </tr>
                    @endforeach
                    <tr>
                        <th colspan="5">Total</th>
                        <th>{{$totalperProgram}}</th>
                    </tr>
                    <?php $totalTesda = $totalperProgram + $totalTesda; ?>
                    @endforeach
                </tbody>
            </table>
            
            <!--total -->
            <table class="table table-condensed">
                <tr>
                    <th>Total Enrollees</th>
                    <th width="10%">{{$totalSHS+$totalCollege+$totalTesda}}</th>
                </tr>
            </table>
            
        </div>
    </div>
</div>
@stop