@if (count($courses)>0)
<table class="table">
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
            $schedule2s = \App\Schedule::where('course_offering_id', $course->id)->get();
            ?>
            @foreach ($schedule2s as $schedule2)
            {{$schedule2->day}} {{$schedule2->time}}<br>
            @endforeach
        </td>
        <td>
            <?php
            $schedule3s = \App\Schedule::where('course_offering_id', $course->id)->get();
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