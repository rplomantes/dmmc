@if (count($courses)>0)
Subjects:
<table class="table table-condensed">
    <thead>
    <th class="col-sm-2">Subject Code</th>
    <th class="col-sm-3">Schedule</th>
    <th class="col-sm-2">Room</th>
    <th class="col-sm-2">Instructor</th>
    <th class="col-sm-1">Add</th>
</thead>
<tbody>
    @foreach($courses as $course)
    <tr>
        <td>
            <?php
            $schedules = \App\Schedule::where('course_offering_id', $course->id)->get();
            ?>
            {{$course->course_code}}

        </td>
        <td>
            <?php
            $schedule2s = \App\Schedule::where('course_offering_id', $course->id)->get();
            ?>
            @foreach ($schedule2s as $schedule2)
            {{$schedule2->day}} {{$schedule2->time}}<br>
            @endforeach
        </td>
        <td>
            <?php
            $schedule3s = \App\Schedule::where('course_offering_id', $course->id)->get();
            ?>
            @foreach ($schedule3s as $schedule3)
            {{$schedule3->room}}<br>
            @endforeach
        </td>
        <?php 
        $instructor_names = \App\User::where('id',$course->instructor_id)->get();
        ?>
        
        <td>@foreach ($instructor_names as $instructor_name){{$instructor_name->firstname}} {{$instructor_name->lastname}}@endforeach</td>
        
        <td><a href="javascript:void(0);" id="course_code" onclick="addloadcourse('{{$course->id}}')">Add</a></td>
    </tr>
    @endforeach
</tbody>
</table>
@else
<br><div class="alert alert-danger">No Subject Offering for the Section!!!</div>
@endif