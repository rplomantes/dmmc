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
                <th class="col-sm-3">Senior High School</th>
                <th class="col-sm-6">Track</th>
                <th class="col-sm-3">View</th>
                </thead>
                <tbody>
                    @foreach($curriculums as $curriculum)
                    <tr>
                        <td>{{$curriculum->program_code}}</td>
                        <td>{{$curriculum->track}}</td>
                        <td><a href="{{url('registrar',array('list_curricula','shs', $curriculum->track))}}">View Curricula</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@stop