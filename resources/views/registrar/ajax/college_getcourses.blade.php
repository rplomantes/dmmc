@if (count($courses)>0)
<table class="table table-condensed">
    <thead>
    <th class="col-sm-2">Subject Code</th>
    <th class="col-sm-4">Subject Name</th>
    <th class="col-sm-4">Schedule</th>
    <th class="col-sm-2">Room</th>
</thead>
<tbody>
    @foreach($courses as $course)
    <tr>
        <td>{{$course->course_code}}</td>
        <td>
            <?php
            $schedules = \App\Schedule::where('course_offering_id', $course->id)->get();
            ?>
            <a href="{{url('/registrar', array('course_scheduling_list','college',$course->id))}}">{{$course->course_name}}</a>

        </td>
        <td>
            <?php
            $schedule2s = \App\Schedule::distinct()->where('course_offering_id', $course->id)->get(['time_start', 'time_end', 'room']);
            ?>
            @foreach ($schedule2s as $schedule2)
            <?php
            $days = \App\Schedule::where('course_offering_id', $course->id)->where('time_start', $schedule2->time_start)->where('time_end', $schedule2->time_end)->where('room', $schedule2->room)->get(['day']);
            ?>
<!--                @foreach ($days as $day){{$day->day}}@endforeach {{$schedule2->time}} <br>-->
            @foreach ($days as $day){{$day->day}}@endforeach {{date('g:i A', strtotime($schedule2->time_start))}} - {{date('g:i A', strtotime($schedule2->time_end))}}<br>
            @endforeach
        </td>
        <td>
            <?php
            $schedule3s = \App\Schedule::distinct()->where('course_offering_id', $course->id)->get(['time_start', 'time_end' , 'room']);
            ?>
            @foreach ($schedule3s as $schedule3)
            {{$schedule3->room}}<br>
            @endforeach
        </td>
    </tr>
    @endforeach
</tbody>
</table>
@else
<br><div class="alert alert-danger">No Subject Offered for this section!!!</div>
@endif