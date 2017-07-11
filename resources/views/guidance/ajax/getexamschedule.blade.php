<table class="table table-condensed">
    <thead>
    <th class="col-sm-1">ID</th>
    <th class="col-sm-4">Datetime</th>
    <th class="col-sm-3">Place</th>
    <th class="col-sm-2">Status</th>
    <th class="col-sm-2">Action</th>
</thead>
<tbody>
    @foreach($scheds as $sched)
    <tr>
        <td>{{$sched->id}}</td>
        <td>{{ date ('M d, Y (D) - g:i A', strtotime($sched->datetime))}}</td>
        <td>{{$sched->place}}</td>
        <td>@if ($sched->is_remove==1) Not Active @else Active @endif</td>
        <td><a href='/guidance/view_examsched/{{$sched->id}}'>Modify</a> | <a href='/guidance/delete_examsched/{{$sched->id}}'>Delete</a></td>
    </tr>
    @endforeach
</tbody>
</table>