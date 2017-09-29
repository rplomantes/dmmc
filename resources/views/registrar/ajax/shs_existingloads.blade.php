<?php
$user = \App\User::where('id', $instructor_id)->first();
$school_year = \App\CtrGradeSchoolYear::where('academic_type', 'Senior High School')->first();
$loads = \App\CourseDetailsShs::where('instructor_id', $user->id)->where('school_year', $school_year->school_year)->where('period', $school_year->period)->get();

$courses = \App\CourseDetailsShs::distinct()->where('school_year', $school_year->school_year)->where('period', $school_year->period)->get(['track']);
?>

Loads:
@if (count($loads)>0)
<table class="table table-condensed">
    <thead>
    <th class="col-sm-2">Subject Name</th>
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
            $schedules = \App\ScheduleShs::where('course_offering_id', $load->id)->get();
            ?>
            {{$load->course_name}}

        </td>
        <td>
            {{$load->level}} - {{$load->section}}
        </td>
        <td>
            <?php
            $schedule2s = \App\ScheduleShs::distinct()->where('course_offering_id', $load->id)->get(['time_start', 'time_end', 'room']);
            ?>
            @foreach ($schedule2s as $schedule2)
            <?php
            $days = \App\ScheduleShs::where('course_offering_id', $load->id)->where('time_start', $schedule2->time_start)->where('time_end', $schedule2->time_end)->where('room', $schedule2->room)->get(['day']);
            ?>
            @foreach ($days as $day){{$day->day}}@endforeach {{date('g:i A', strtotime($schedule2->time_start))}} - {{date('g:i A', strtotime($schedule2->time_end))}} <br>
            <!--{{$schedule2->day}} {{$schedule2->time_start}} - {{$schedule2->time_end}}<br>-->
            @endforeach
        </td>
        <td>
            <?php
            $schedule3s = \App\ScheduleShs::distinct()->where('course_offering_id', $load->id)->get(['time_start', 'time_end', 'room']);
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