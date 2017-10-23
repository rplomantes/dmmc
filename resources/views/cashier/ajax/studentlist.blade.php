<?php
$students =  DB::Select("Select * from users where (lastname like '$search%' OR firstname like '$search%' OR idno = '$search') and accesslevel='0'order by lastname, firstname");
if(count($students)>0){
?>
<table class = "table table-responsive"><tr><td>Student ID</td><td>Student Name</td><td>View</td></tr>
    @foreach($students as $student)
        <tr><td>{{$student->idno}}</td><td>{{$student->lastname}}, {{$student->firstname}}</td><td> <a href="{{url('viewledger',$student->idno)}}">View</td></tr>
    @endforeach
</table>
<?php
}
?>