@extends('layouts.registrarapp')
@section('content')
<?php
$programs = \App\CtrAcademicProgram::where('program_code', $program_code)->first();
$curriculums = \App\Curriculum::distinct()->where('program_code', $program_code)->get(['curriculum_year']);
?>
<style>
    .label{color: gray;}
</style>

<div class="row">
    <div class='col-sm-12'>
        <div id="imaginary_container">
            <h3> {{$programs->program_name}} </h3>
            @if (count($curriculums)>0)
            <table class="table table-condensed">
                <thead>
                <th class="col-sm-6">Curriculum Year</th>
                <th class="col-sm-6">Action</th>
                </thead>
                <tbody>
                    @foreach($curriculums as $curriculum)
                    <tr>
                        <td>{{$curriculum->curriculum_year}}</td>
                        <td><a href="{{url('registrar',array('curriculum',$curriculum->curriculum_year,$programs->program_code))}}">View</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @else
            No Curriculum has been set to the system. Please see the administrator.
            @endif
        </div>
    </div>
</div>
@stop