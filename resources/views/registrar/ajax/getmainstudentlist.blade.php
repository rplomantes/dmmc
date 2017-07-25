<table class="table table-condensed">
    <thead>
    <th class="col-sm-2">ID number</th>
    <th class="col-sm-4">Student Name</th>
    <th class="col-sm-4">Course</th>
    <th class="col-sm-2">Assessment</th>
</thead>
<tbody>
    @foreach($lists as $list)
    <tr>
        <td>{{$list->idno}}</td>
        <td>{{$list->lastname}} {{$list->extensionname}}, {{$list->firstname}} {{$list->middlename}}</td>
        <td>{{$list->program_code}}</td>
        <td>Assess</td>
    </tr>
    @endforeach
</tbody>
</table>