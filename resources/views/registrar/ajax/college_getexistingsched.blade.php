@if (count($schedules)>0)
<table class="table">
    <thead>
    <th class="col-sm-2">Subject</th>
    <th class="col-sm-4">Year & Section</th>
    <th class="col-sm-3">Day</th>
    <th class="col-sm-3">Time</th>
</thead>
<tbody>
    @foreach($schedules as $schedule)
    <tr>
        <td>{{$schedule->course_code}}</td>
        <td>{{$schedule->program_code}} {{$schedule->level}} yr - {{$schedule->section}}</td>
        <td>{{$schedule->day}}</td>
        <td>{{$schedule->time}}</td>
    </tr>
    @endforeach
</tbody>
</table>
@else
<br><div class="alert alert-danger">No Room Shedule Yet!!!</div>
@endif