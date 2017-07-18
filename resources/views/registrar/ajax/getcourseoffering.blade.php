
Subject Offered:
@if (count($sections)>0)
@foreach ($sections as $section)
<b>Section: {{$section->section}}</b>
<table class="table table-condensed">
    <thead>
    <th class="col-sm-5">Subject</th>
    <th class="col-sm-2">Schedule</th>
    <th class="col-sm-2">Room</th>
    <th class="col-sm-2">Instructor</th>
    <th class="col-sm-1">Remove</th>
</thead>
<tbody>
<?php 
$lists = DB::select("select * from course_offerings where program_code='$program_code' and section=$section->section and period = '$period' and level='$level' "); 
?>
    @foreach ($lists as $list)
    <tr>
        <td>{{$list->course_code}} - {{$list->course_name}}</th>
        <td></td>
        <td></td>
        <td></td>
        <td>Remove</td>
    </tr>
    @endforeach
</tbody>
</table>
@endforeach
@else
<br>No Subject Offered for this Period!!!
@endif