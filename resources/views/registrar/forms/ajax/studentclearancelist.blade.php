<table class="table table-condensed">
    <thead>
    <th class="col-sm-2">ID numbers</th>
    <th class="col-sm-8">Student Name</th>
    <th class="col-sm-2">Print</th>
</thead>
<tbody>
    @foreach($lists as $list)
    <tr>
        <td>{{$list->idno}}</td>
        <td>{{$list->lastname}} {{$list->extensionname}}, {{$list->firstname}} {{$list->middlename}}</td>
        <td><a target="_blank" href="{{url('registrar', array('forms', $list->idno, "REGForm01-2011_"."".$list->idno))}}"><button class="btn btn-success">PRINT</button></a></td>
    </tr>
    @endforeach
</tbody>
</table>