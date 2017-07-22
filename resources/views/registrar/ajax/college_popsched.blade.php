<table class="table table-condensed">
    <thead>
    <th class="col-sm-3">Room</th>
    <th class="col-sm-3">Day</th>
    <th class="col-sm-3">Time</th>
    <th class="col-sm-3">Delete</th>
</thead>
<tbody>
    @foreach ($schedules as $schedule)
    <tr>
        <td><input onchange="changeroom('{{$schedule->id}}', this.value)" id="room" type="text" class="form form-control" value="{{$schedule->room}}"></td>
        <td><input onchange="changeday('{{$schedule->id}}', this.value)" id="day" type="text" class="form form-control" value="{{$schedule->day}}"></td>
        <td><input onchange="changetime('{{$schedule->id}}', this.value)" id="time" type="text" class="form form-control" value="{{$schedule->time}}"></td>
        <td><div class="col-sm-12 btn btn-danger" onclick="deletesched('{{$schedule->id}}')">Delete</div></td>
    </tr>
    @endforeach
</tbody>
</table>