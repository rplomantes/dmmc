@extends('layouts.registrarapp')
@section('content')
<style>
    .label{color: gray;}
</style>

<div class="row">
    <div class='col-sm-12'>
        <div id="imaginary_container">
            <h3>Subject Offering</h3>
            <table class="table table-condensed">
                <thead>
                <th class="col-sm-3">Department</th>
                <th class="col-sm-6">Strand</th>
                <th class="col-sm-3">View</th>
                </thead>
                <tbody>
                    @foreach($tracks as $track)
                    <tr>
                        <td>{{$track->program_code}}</td>
                        <td>{{$track->track}}</td>
                        <td><a href="{{url('registrar',array('view_course_offering','shs', $track->track))}}">View Subject Offering</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@stop