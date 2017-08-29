
Subject Offered:
@if (count($sections)>0)
@foreach ($sections as $section)
<span class = "label label-danger" style="color:#ffffff;padding:5px;">Section: {{$section->section}}</span>
<span class = "label label-danger" style="color:#ffffff;padding:5px;">S.Y.: {{$school_year->school_year}}</span>
<span class = "label label-danger" style="color:#ffffff;padding:5px;">{{$level}} Year - @if ($school_year->period== '1st') 1st Semester @elseif ($school_year->period== '2nd') 2nd Semester @elseif ($school_year->period== 'Summer') Summer @else @endif</span>
<table class="table table-condensed">
    <thead>
    <th class="col-sm-6">Subject</th>
    <th class="col-sm-1">Remove</th>
</thead>
<tbody>
    <?php
    $lists = DB::select("select * from course_offerings where program_code='$program_code' and section=$section->section and period = '$school_year->period' and level='$level' and school_year = '$school_year->school_year'");
    ?>
    @foreach ($lists as $list)
<input type="hidden" id="id" value="{{$list->id}}">
<tr>
    <td>{{$list->course_code}} - {{$list->course_name}}</td>
    <td><a href="javascript:void(0)" onclick="removesubject('{{$list->id}}')">Remove</a></td>
</tr>
@endforeach
</tbody>
</table>
@endforeach
@else
<br>No Subject Offered for this Period!!!
@endif