Subjects:<br>
@if (count($lists)>0)
<table class="table table-condensed">
    <thead>
    <th class="col-sm-2">Subject Code</th>
    <th class="col-sm-4">Subject Description</th>
</thead>
<tbody id="body">
    @foreach ($lists as $list)
<input type="hidden" id="course_code" value="{{$list->course_code}}">
<input type="hidden" id="course_name" value="{{$list->course_name}}">

<tr>    
    <td>{{$list->course_code}}</td>
    <td>
        <a href="javascript:void(0)" onclick="addSubjecttoOffering(curriculum_year.value, level.value, period.value, section.value,'{{$list->course_code}}', '{{$program_code}}')">{{$list->course_name}}</a>
    </td>
</tr>
@endforeach
</tbody>
</table>
<div class="btn btn-info col-sm-12" onclick="addAllSubjects()">Add all Subjects <span class=" fa fa-long-arrow-right"></span></div>
@else
No Subjects for this Period!!!
@endif