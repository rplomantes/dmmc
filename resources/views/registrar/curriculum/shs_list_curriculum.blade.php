@extends('layouts.registrarapp')
@section('content')
<?php
$tracks = \App\CtrAcademicProgram::where('track', $track)->first();
$curriculums = \App\Curriculum::distinct()->where('program_code', $track)->get(['curriculum_year']);
?>
<style>
    .label{color: gray;}
</style>

<div class="row">
    <div class='col-sm-12'>
        <div id="imaginary_container">
            <h3> {{$tracks->academic_program}} - {{$tracks->track}}</h3>
            @if (count($curriculums)>0)
            <table class="table table-condensed">
                <thead>
                <th class="col-sm-6">Curriculum Year</th>
                <th class="col-sm-6">View</th>
                </thead>
                <tbody>
                    @foreach($curriculums as $curriculum)
                    <tr>
                        <td>{{$curriculum->curriculum_year}}</td>
                        <td><a href="{{url('registrar',array('curriculum','shs',$curriculum->curriculum_year,$tracks->track))}}">View</td>
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