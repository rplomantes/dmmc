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
    <th class="col-sm-3">Section</th>
    <th class="col-sm-3">Schedule</th>
    <th class="col-sm-3">Room</th>
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
            $schedule2s = \App\Schedule::distinct()->where('course_offering_id', $load->id)->get(['time_start', 'time_end', 'room']);
            ?>
            @foreach ($schedule2s as $schedule2)
            <?php
            $days = \App\Schedule::where('course_offering_id', $load->id)->where('time_start', $schedule2->time_start)->where('time_end', $schedule2->time_end)->where('room', $schedule2->room)->get(['day']);
            ?>
            @foreach ($days as $day){{$day->day}}@endforeach {{date('g:i A', strtotime($schedule2->time_start))}} - {{date('g:i A', strtotime($schedule2->time_end))}} <br>
            <!--{{$schedule2->day}} {{$schedule2->time_start}} - {{$schedule2->time_end}}<br>-->
            @endforeach
        </td>
        <td>
            <?php
            $schedule3s = \App\Schedule::distinct()->where('course_offering_id', $load->id)->get(['time_start', 'time_end', 'room']);
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