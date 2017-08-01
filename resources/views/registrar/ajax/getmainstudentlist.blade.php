<table class="table table-condensed">
    <thead>
    <th class="col-sm-2">ID number</th>
    <th class="col-sm-4">Student Name</th>
    <th class="col-sm-4">Course</th>
    <th class="col-sm-2">View Profile</th>
</thead>
<tbody>
    @foreach($lists as $list)
    <tr>
        <td>{{$list->idno}}</td>
        <td>{{$list->lastname}} {{$list->extensionname}}, {{$list->firstname}} {{$list->middlename}}</td>
        <td>{{$list->program_code}}</td>
        <td><a href='{{url('registrar', array('view_profile', $list->idno))}}'>View Profile</a></td>
    </tr>
    @endforeach
</tbody>
</table>