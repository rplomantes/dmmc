<table class="table table-condensed">
    <thead>
    <th class="col-sm-2">ID number</th>
    <th class="col-sm-4">Name</th>
    <th class="col-sm-2">Intended Course</th>
    <th class="col-sm-2">Status</th>
    <th class="col-sm-2">Action</th>
</thead>
<tbody>
    @foreach($lists as $list)
    <tr>
        <td>{{$list->idno}}</td>
        <td>{{$list->lastname}} {{$list->extensionname}}, {{$list->firstname}} {{$list->middlename}}</td>
        <td>{{$list->course}}</td>
        <td>@if ($list->status==1) Passed @elseif ($list->status==0) Pre-registered @else Failed @endif</td>
        <td><a href='{{url('guidance',array('viewinfo',$list->idno))}}'>View Profile</a></td>
    </tr>
    @endforeach
</tbody>
</table>