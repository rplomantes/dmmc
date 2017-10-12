<table class="table table-condensed">
    <thead>
    <th>ID numbers</th>
    <th>Student Name</th>
    <th>Course</th>
    <th>Adding/Dropping</th>
</thead>
<tbody>
    @foreach($lists as $list)
    <?php
    $status = \App\Status::where('idno', $list->idno)->first();
    ?>
    <tr>
        <td>{{$list->idno}}</td>
        <td>{{$list->lastname}} {{$list->extensionname}}, {{$list->firstname}} {{$list->middlename}}</td>
        <td>{{$status->program_code}}</td>
        <td><a href='{{url('registrar', array('adding_dropping', $list->idno))}}'>Adding/Dropping</a></td>
    </tr>
    @endforeach
</tbody>
</table>