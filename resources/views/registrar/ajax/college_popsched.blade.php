<table class="table table-condensed">
    <thead>
    <th class="col-sm-4">Room</th>
    <th class="col-sm-2">Day</th>
    <th class="col-sm-3">Start</th>
    <th class="col-sm-3">End</th>
    <th class="col-sm-1">Delete</th>
</thead>
<tbody>
    @foreach ($schedules as $schedule)
    <tr>
        <td><input onchange="changeroom('{{$schedule->id}}', this.value)" type="text" class="form form-control" value="{{$schedule->room}}"></td>
        <!--<td><input onchange="changeday('{{$schedule->id}}', this.value)" id="day" type="text" class="form form-control" value="{{$schedule->day}}"></td>-->
        <td>
            <select onchange="changeday('{{$schedule->id}}', this.value)"class="form form-control">
                <option value="">Select Day</option>
                <option value="M" @if ($schedule->day==='M') selected="selected" @endif>Mon</option>
                <option value="T" @if ($schedule->day==='T') selected="selected" @endif>Tue</option>
                <option value="W" @if ($schedule->day==='W') selected="selected" @endif>Wed</option>
                <option value="Th" @if ($schedule->day==='Th') selected="selected" @endif>Thur</option>
                <option value="F" @if ($schedule->day==='F') selected="selected" @endif>Fri</option>
                <option value="Sa" @if ($schedule->day==='Sa') selected="selected" @endif>Sat</option>
                <option value="Su" @if ($schedule->day==='Su') selected="selected" @endif>Sun</option>
            </select>
        </td>
        <td><input onchange="changetime_start('{{$schedule->id}}', this.value)" type="text" class="form form-control" value="{{$schedule->time_start}}"></td>
        <td><input onchange="changetime_end('{{$schedule->id}}', this.value)" type="text" class="form form-control" value="{{$schedule->time_end}}"></td>
        <td><div class="col-sm-12 btn btn-danger" onclick="deletesched('{{$schedule->id}}')">Delete</div></td>
    </tr>
    @endforeach
</tbody>
</table>