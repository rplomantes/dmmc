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

@foreach($periods as $period)
<?php $grades = \App\GradeShs::where('idno', $idno)->where('school_year', $school_year->school_year)->where('period', $period->period)->orderBy('period')->get(); ?>
<strong>{{$period->period}} Semester</strong>
<table class="table table-condensed">
    <thead>
    <th width="70%">Subject Name</th>
    <th width="20%">Remove</th>
    <th width="10%">Hours</th>
</thead>
<?php
$totalHours = 0;
$totalUnits = 0;
?>
@foreach ($grades as $grade)
<tr>
    <td>{{$grade->course_name}}</td>
    <td><a href="javascript: void(0)" onclick="removesubject('{{$grade->id}}')">Remove</a></td>
    <td>@if ($grade->hours==0) @else {{$grade->hours}} @endif <?php $totalHours = $grade->hours + $totalHours; ?></td>
</tr>
@endforeach
<tr>
    <th colspan="2"><div align='right'>Total</div> </th> 
    <th>{{$totalHours}}</th>
</tr>
</table>
@endforeach