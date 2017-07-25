@extends('layouts.registrarapp')
@section('content')
<style>
    .label{color: gray;}
</style>

<?php
$school_year = \App\CtrSchoolYear::where('academic_type', 'College')->first();
$loads = \App\CourseOffering::where('instructor_id', $user->id)->where('school_year', $school_year->school_year)->where('period', $school_year->period)->get();

$courses = \App\CourseOffering::distinct()->where('school_year', $school_year->school_year)->where('period', $school_year->period)->get(['program_code']);
?>

<div class="row">
    <div class='col-sm-12'>
        <h4>Load Subjects to:</h4>
        <h3><b>Prof. {{$user->firstname}} {{$user->middlename}} {{$user->lastname}} {{$user->extensionname}}</b></h3>
        <div id="imaginary_container">

            <input type="hidden" id="school_year" value="{{$school_year->school_year}}">
            <input type="hidden" id="period" value="{{$school_year->period}}">
            <input type="hidden" id="instructor_id" value="{{$user->id}}">

            <!-- topleft -->
            <div class="col-sm-12">
                <div class="col-sm-2">
                    <label class="label">Course</label>
                    <select id="course" class="form form-control">
                        <option value="">Course</option>
                        @foreach($courses as $course)
                        <option>{{$course->program_code}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-sm-2">
                    <label class="label">Level</label>
                    <select id="level" class="form form-control">
                        <option value="">Level</option>
                        <option value="1st">1st Year</option>
                        <option value="2nd">2nd Year</option>
                        <option value="3rd">3rd Year</option>
                        <option value="4th">4th Year</option>
                    </select>
                </div>
                <div class="col-sm-2">
                    <label class="label">Section</label>
                    <select id="section" class="form form-control" onchange="loadcourseoffering()">
                        <option value="">Section</option>
                        <option value="1">Section 1</option>
                        <option value="2">Section 2</option>
                        <option value="3">Section 3</option>
                        <option value="4">Section 4</option>
                    </select>
                </div>
            </div>
            
            <div class="col-sm-12"><br>
                <!--lower left-->
                <div class="col-sm-6" id="course_offering">
                </div>
                <!--right-->
                <div class="col-sm-6" id="existingloads">
                    Loads:
                    @if (count($loads)>0)
                    <table class="table table-condensed">
                        <thead>
                        <th class="col-sm-2">Subject Code</th>
                        <th class="col-sm-4">Section</th>
                        <th class="col-sm-3">Schedule</th>
                        <th class="col-sm-2">Room</th>
                        <th class="col-sm-1">Remove</th>
                        </thead>
                        <tbody>
                            @foreach($loads as $load)
                            <tr>
                                <td>
                                    <?php
                                    $schedules = \App\Schedule::where('course_offering_id', $load->id)->get();
                                    ?>
                                    {{$load->course_code}}

                                </td>
                                <td>
                                    {{$load->program_code}}<br>{{$load->level}} year - section {{$load->section}}
                                </td>
                                <td>
                                    <?php
                                    $schedule2s = \App\Schedule::where('course_offering_id', $load->id)->get();
                                    ?>
                                    @foreach ($schedule2s as $schedule2)
                                    {{$schedule2->day}} {{$schedule2->time}}<br>
                                    @endforeach
                                </td>
                                <td>
                                    <?php
                                    $schedule3s = \App\Schedule::where('course_offering_id', $load->id)->get();
                                    ?>
                                    @foreach ($schedule3s as $schedule3)
                                    {{$schedule3->room}}<br>
                                    @endforeach
                                </td>
                                <td>
                                    <a href="javascript:void(0)" onclick="removeload('{{$load->id}}')">Remove</a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @else
                    <br><div class="alert alert-danger">No Subject Loaded!!</div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
<script>

    function loadcourseoffering() {
    array = {};
    array['course'] = $("#course").val();
    array['level'] = $("#level").val();
    array['section'] = $("#section").val();
    array['school_year'] = $("#school_year").val();
    array['period'] = $("#period").val();
    $.ajax({
    type: "GET",
            url: "/registrar/ajax/get_courseoffering_college",
            data: array,
            success: function (data) {
            $('#course_offering').html(data);
            }

    });
    }

    function addloadcourse(id) {
    array['instructor_id'] = $("#instructor_id").val();
    $.ajax({
    type: "GET",
            url: "/registrar/ajax/add_coursetoinstructor_college/" + id,
            data: array,
            success: function (data) {
            $('#existingloads').html(data);
            loadcourseoffering()
            }

    });
    }

    function removeload(id) {
    array['instructor_id'] = $("#instructor_id").val();
    $.ajax({
    type: "GET",
            url: "/registrar/ajax/remove_coursetoinstructor_college/" + id,
            data: array,
            success: function (data) {
            $('#existingloads').html(data);
            loadcourseoffering()
            }

    });
    }
</script>
@stop