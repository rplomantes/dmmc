@if (count($courses)>0)
<table class="table table-condensed">
    <thead>
    <th class="col-sm-2">Subject</th>
    <th class="col-sm-5">Year & Section</th>
    <th class="col-sm-5">Schedule</th>
</thead>
<tbody>
    @foreach($courses as $course)
    <tr>
        <td>{{$course->course_code}}</td>
        <td>{{$course->program_code}} {{$course->level}} yr - {{$course->section}}</td>
        <td>
            <?php
            $schedule2s = \App\Schedule::distinct()->where('course_offering_id', $course->course_offering_id)->where('room', $room)->get(['time_start', 'time_end', 'room']);
            ?>
            @foreach ($schedule2s as $schedule2)
            <?php
            $days = \App\Schedule::distinct()->where('course_offering_id', $course->course_offering_id)->where('time_start', $schedule2->time_start)->where('time_end', $schedule2->time_end)->where('room', $schedule2->room)->get(['day']);
            ?>
                @foreach ($days as $day){{$day->day}}@endforeach {{date('g:i A', strtotime($schedule2->time_start))}} - {{date('g:i A', strtotime($schedule2->time_end))}} <br>
            <!--{{$schedule2->day}} {{$schedule2->time_start}} - {{$schedule2->time_end}}<br>-->
            @endforeach
        </td>
    </tr>
    @endforeach
</tbody>
</table>
@else
<br><div class="alert alert-danger">No Room Shedule Yet!!!</div>
@endif