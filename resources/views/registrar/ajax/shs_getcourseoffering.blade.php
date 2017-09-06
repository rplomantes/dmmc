
Subject Offered:
@if (count($sections)>0)
@foreach ($sections as $section)
<span class = "label label-danger" style="color:#ffffff;padding:5px;">Section: {{$section->section}}</span>
<span class = "label label-danger" style="color:#ffffff;padding:5px;">S.Y.: {{$school_year->school_year}}</span>
<span class = "label label-danger" style="color:#ffffff;padding:5px;">{{$level}}</span>
<table class="table table-condensed">
    <thead>
    <th class="col-sm-5">Subject</th>
    <th class="col-sm-1">Period</th>
    <th class="col-sm-1">Remove</th>
</thead>
<tbody>
    <?php
    $lists = DB::select("select * from course_offerings where track='$track' and section=$section->section and level='$level' and school_year = '$school_year->school_year' order by `period`");
    ?>
    @foreach ($lists as $list)
<input type="hidden" id="id" value="{{$list->id}}">
<tr>
    <td>{{$list->course_name}}</td>
    <td>{{$list->period}}</td>
    <td><a href="javascript:void(0)" onclick="removesubject('{{$list->id}}')">Remove</a></td>
</tr>
@endforeach
</tbody>
</table>
@endforeach
@else
<br>No Subject Offered for this Period!!!
@endif