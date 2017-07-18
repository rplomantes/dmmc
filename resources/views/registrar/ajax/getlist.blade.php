Subjects:<br>
@if (count($lists)>0)
<table class="table table-condensed">
    <thead>
    <th class="col-sm-1">Subject Code</th>
    <th class="col-sm-5">Subject Description</th>
</thead>
<tbody id="body">
    @foreach ($lists as $list)
<input type="hidden" id="program_code"  value="{{$program_code}}">
<input type="hidden" id="course_code" value="{{$list->course_code}}">
<input type="hidden" id="course_name" value="{{$list->course_name}}">

<tr>    
    <td>{{$list->course_code}}</td>
    <td>
        <a href="{{url('#')}}" onclick="addSubjecttoOffering(curriculum_year.value, level.value, period.value, section.value,'{{$list->course_code}}', '{{$program_code}}')">{{$list->course_name}}</a>
    </td>
</tr>
@endforeach
</tbody>
</table>
<!--<div class="btn btn-info col-sm-12">Add all Subjects <span class=" fa fa-long-arrow-right"></span></div>-->
@else
No Subjects for this Period!!!
@endif

<script>
    function addSubjecttoOffering(curriculum_year, level, period, section, course_code, program_code) {
    array = {};
    array['course_code'] = course_code;
    array['program_code'] = program_code;
    $.ajax({
    type: "GET",
            url: "/registrar/ajax/getsubject/" + program_code + "/" + curriculum_year + "/" + period + "/" + level + "/" + section + "/" + course_code,
            success: function (data) {
            $('#course_offered').html(data);
            }

    });
    }
</script>