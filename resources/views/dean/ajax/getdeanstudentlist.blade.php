<table class="table table-condensed table-striped">
    <tr><th>Student ID</th><th>Student Name</th><th>Course</th><th>Action</th></tr>
    @if(count($lists)>0)
        @foreach($lists as $list)
            <tr><td>{{$list->idno}}</td><td>{{$list->lastname}}, {{$list->firstname}}</td><td>{{$list->program_code}}</td><td><a href="{{url('dean',array('viewinfo',$list->idno))}}">View</a></td></tr>
        @endforeach    
    @else
        <tr><td colspan="4">Record Not Found!!!</td></tr>
    @endif
</table>    
