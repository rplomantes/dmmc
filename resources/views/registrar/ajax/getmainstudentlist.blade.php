<table class="table table-condensed">
    <thead>
    <th class="col-sm-2">ID number</th>
    <th class="col-sm-4">Name</th>
</thead>
<tbody>
    @foreach($lists as $list)
    <tr>
        <td>{{$list->idno}}</td>
        <td>{{$list->lastname}} {{$list->extensionname}}, {{$list->firstname}} {{$list->middlename}}</td>
    </tr>
    @endforeach
</tbody>
</table>