<table class="table table-condensed">
    <thead>
    <th class="col-sm-2">ID number</th>
    <th class="col-sm-4">Name</th>
    <th class="col-sm-3">Intended Course</th>
    <th class="col-sm-1">Status</th>
    <th class="col-sm-2">Action</th>
</thead>
@foreach($lists as $list)
<tbody>

    <tr>
        <td>{{$list->idno}}</td>
        <td>{{$list->lastname}} {{$list->extensionname}}, {{$list->firstname}} {{$list->middlename}}</td>
        <td>{{$list->course}} @if(($list->major) !== null) Major in {{$list->major}} @else @endif</td>
        <td>{{$list->status}}</td>
        <td><a href="/guidance/viewinfo/{{$list->idno}}">View Profile</a></td>
    </tr>

</tbody>
@endforeach
</table>
