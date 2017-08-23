<table class="table table-condensed">
    <thead>
    <th class="col-sm-2">ID number</th>
    <th class="col-sm-5">Student Name</th>
    <th class="col-sm-3">Course/Strand</th>
    <th class="col-sm-2">View Profile</th>
    </thead>
    @if(count($lists)>0)
        @foreach($lists as $list)
            <tr><td>{{$list->idno}}</td><td>{{$list->lastname}}, {{$list->firstname}}</td><td>{{$list->program_code}}</td><td><a href="{{url('dean',array('viewstudentprofile',$list->idno))}}">View Profile</a></td></tr>
        @endforeach    
    @else
        <tr><td colspan="4">Record Not Found!!!</td></tr>
    @endif
</table>    
