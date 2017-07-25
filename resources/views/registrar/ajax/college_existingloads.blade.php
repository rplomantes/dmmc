<?php
$user = \App\User::where('id', $instructor_id)->first();
$school_year = \App\CtrSchoolYear::where('academic_type', 'College')->first();
$loads = \App\CourseOffering::where('instructor_id', $user->id)->where('school_year', $school_year->school_year)->where('period', $school_year->period)->get();

$courses = \App\CourseOffering::distinct()->where('school_year', $school_year->school_year)->where('period', $school_year->period)->get(['program_code']);
?>

Loads:
@if (count($loads)>0)
<table class="table table-condensed">
    <thead>
    <th class="col-sm-2">Subject Code</th>
    <th class="col-sm-4">Section</th>
    <th class="col-sm-3">Schedule</th>
    <th class="col-sm-2">Room</th>
    <th class="col-sm-1">Remove</th>
</thead>
<tbody>
    @foreach($loads as $load)
    <tr>
        <td>
            <?php
            $schedules = \App\Schedule::where('course_offering_id', $load->id)->get();
            ?>
            {{$load->course_code}}

        </td>
        <td>
            {{$load->program_code}}<br>{{$load->level}} year - section {{$load->section}}
        </td>
        <td>
            <?php
            $schedule2s = \App\Schedule::where('course_offering_id', $load->id)->get();
            ?>
            @foreach ($schedule2s as $schedule2)
            {{$schedule2->day}} {{$schedule2->time}}<br>
            @endforeach
        </td>
        <td>
            <?php
            $schedule3s = \App\Schedule::where('course_offering_id', $load->id)->get();
            ?>
            @foreach ($schedule3s as $schedule3)
            {{$schedule3->room}}<br>
            @endforeach
        </td>
        <td>
            <a href="javascript:void(0)" onclick="removeload('{{$load->id}}')">Remove</a>
        </td>
    </tr>
    @endforeach
</tbody>
</table>
@else
<br><div class="alert alert-danger">No Subject Loaded!!</div>
@endif