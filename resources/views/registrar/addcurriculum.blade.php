@extends('layouts.registrarapp')
@section('content')

<script>
    function displayID() {
        document.getElementById('curriculum_id').value = program_code.value + curriculum_year.value + "-" + course_code.value;
    }
</script>

<ul class="nav nav-tabs">
    <li><a href="{{url('/registrar/curriculum/college')}}">View</a></li>
    <li class="active"><a href="{{url('/registrar/curriculum/college/add')}}">Add</a></li>
</ul>
<br>

<div class="row">
    <div class="col-sm-10 col-sm-offset-1">
        <div id="imaginary_container">
            <form method="post" action="{{ url('/registrar/curriculum/addcurriculum') }}">
                {{ csrf_field() }}
                <div class="col-sm-3">
                    Curriculum ID:<br>
                    <input type="text" name="curriculum_id" id="curriculum_id" size="9" class="form-control" readonly="">
                </div>
                <div class="col-sm-3">
                    Curriculum Year:<br>
                    <input type="text" name="curriculum_year" id="curriculum_year" size="4" class="form-control" onchange="displayID(this.value)">
                </div>
                <div class="col-sm-3">
                    Program Code:<br>
                    <input type="text" name="program_code" id="program_code" size="7" class="form-control" onchange="displayID(this.value)">
                </div>
                <div class="col-sm-3">
                    Program Name:<br>
                    <input type="text" name="program_name" class="form-control">
                </div>
                <div class="col-sm-3">
                    Course Code:<br>
                    <input type="text" name="course_code" id="course_code" size="6" class="form-control" onchange="displayID(this.value)">
                </div>
                <div class="col-sm-3">
                    Course Name:<br>
                    <input type="text" name="course_name" size="13" class="form-control">
                </div>
                <div class="col-sm-3">
                    Units:<br>
                    <select name="units" class="form-control">
                        <option value=""></option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                        <option value="6">6</option>
                    </select>
                </div>
                <div class="col-sm-3">
                    Hours:<br>
                    <input type="number" name="hours" size="2" min="0" class="form-control">
                </div>
                <div class="col-sm-3">
                    Level:<br>
                    <select name="level" class="form-control">
                        <option value=""></option>
                        <option value="1">1st Year</option>
                        <option value="2">2nd Year</option>
                        <option value="3">3rd Year</option>
                        <option value="4">4th Year</option>
                        <option value="5">5th Year</option>
                    </select>
                </div>
                <div class="col-sm-3">
                    Period:<br>
                    <select name="period" class="form-control">
                        <option value=""></option>
                        <option value="1">1st Semester</option>
                        <option value="2">2nd Semester</option>
                        <option value="0">Summer</option>
                    </select>
                </div>
                <div class="col-sm-4">
                    Course Type:<br>
                    <select name="course_type" class="form-control">
                        <option value=""></option>
                        <option value="major">Major Course</option>
                        <option value="major">Minor Course</option>
                        <option value="general">General Course</option>
                        <option value="pre-requesite">Pre-requesites</option>
                    </select>
                </div>
                <div class="col-sm-12"><br>
                    <input type="submit" value="Add" class="btn btn-default col-sm-12">
                </div>
            </form>
        </div>
    </div>
</div>
@stop
