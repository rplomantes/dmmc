@extends('layouts.registrarapp')
@section('content')
<style>
    .label{color: gray;}
</style>
<?php
$programs = \App\CtrAcademicProgram::distinct()->where('academic_type', 'College')->orWhere('academic_type', 'TESDA')->get(['program_code', 'program_name']);
$tracks = \App\CtrAcademicProgram::distinct()->where('academic_type', 'Senior High School')->get(['track']);
$levels = \App\CtrAcademicProgram::distinct()->get(['level']);
?>
<div class="row">
    <div class='col-sm-12'>
        <div id="imaginary_container">
            <h3>Enrollment Report</h3>
            <form class="form-horizontal" method="post" target="_blank" action="{{url('/registrar/reports', 'generate_enrollmentreport')}}" >
                {{ csrf_field() }}
                <div class="form form-group">
                    <div class="col-sm-6">
                        <label class="label">Date</label>
                        <div class="input-group stylish-input-group">
                            <input type="date" name="date" id="datepicker" class="form form-control" placeholder="yyyy-dd-mm" value="{{old('birthdate')}}">
                            <span class="input-group-addon">
                                <span class="fa fa-calendar"></span> 
                            </span>
                        </div>
                    </div>
                </div>
                <div class="form form-group">
                    <div class="col-sm-6">
                        <label class="label">Course/Strand</label>
                        <select name="program_code" class="form form-control">
                            <option value=''>Select Course/Strand</option>
                            @foreach ($programs as $program)
                            <option value="{{$program->program_code}}">{{$program->program_name}}</option>
                            @endforeach
                            @foreach ($tracks as $track)
                            <option value="{{$track->track}}">{{$track->track}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form form-group">
                    <div class="col-sm-6">
                        <label class="label">Level</label>
                        <select name='level' class="form form-control">
                            <option value=''>Level</option>
                            @foreach ($levels as $level)
                            <option value="{{$level->level}}">{{$level->level}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form form-group">
                    <div class="col-sm-6">
                        <label class="label">Category</label>
                        <select name='category' class="form form-control">
                            <option value=''>Old/New Student</option>
                            <option value='0'>Old Student</option>
                            <option value='1'>New Student</option>
                        </select>
                    </div>
                </div>
                <div class="form form-group">
                    <div class="col-sm-6">
                        <input class="form form-control btn btn-success" type="submit" value="Generate Report">
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@stop