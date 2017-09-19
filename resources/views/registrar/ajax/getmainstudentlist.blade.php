<table class="table table-condensed">
    <thead>
    <th class="col-sm-2">ID numbers</th>
    <th class="col-sm-6">Student Name</th>
    <th class="col-sm-2">View Profile</th>
    <th class="col-sm-2">Assess</th>
</thead>
<tbody>
    @foreach($lists as $list)
    <tr>
        <td>{{$list->idno}}</td>
        <td>{{$list->lastname}} {{$list->extensionname}}, {{$list->firstname}} {{$list->middlename}}</td>
        <td><a href='{{url('registrar', array('viewstudentprofile', $list->idno))}}'>View Profile</a></td><td><a href='{{url('registrar', array('viewinfo', $list->idno))}}'>Assess</a></td>
    </tr>
    @endforeach
</tbody>
</table>