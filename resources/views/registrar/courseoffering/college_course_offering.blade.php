@extends('layouts.registrarapp')
@section('content')
<style>
    .label{color: gray;}
</style>

<div class="row">
    <div class='col-sm-12'>
        <div id="imaginary_container">
            <table class="table table-condensed">
                <thead>
                <th class="col-sm-3">Program Code</th>
                <th class="col-sm-6">Program Name</th>
                <th class="col-sm-3">View</th>
                </thead>
                <tbody>
                    @foreach($programs as $program)
                    <tr>
                        <td>{{$program->program_code}}</td>
                        <td>{{$program->program_name}}</td>
                        <td><a href="{{url('registrar',array('view_course_offering','college', $program->program_code))}}">View Subject Offering</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@stop