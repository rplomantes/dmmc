<table class="table table-condensed">
    <thead>
    <th class="col-sm-2">ID number</th>
    <th class="col-sm-8">Student Name</th>
    <th class="col-sm-2">Assess</th>
</thead>
<tbody>
    @if(count($lists)>0)
        @foreach($lists as $list)
        <tr>
            <td>{{$list->idno}}</td>
            <td>{{$list->lastname}} {{$list->extensionname}}, {{$list->firstname}} {{$list->middlename}}</td>
            <td><a href='{{url('registrar', array('viewinfo', $list->idno))}}'>Assess</a></td>
        </tr>
        @endforeach    
    @else
    <tr><td colspan="4">Record Not Found!!!</td></tr>
    @endif
</table>  