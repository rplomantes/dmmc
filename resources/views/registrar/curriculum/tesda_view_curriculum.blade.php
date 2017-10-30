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
                    @foreach($curriculums as $curriculum)
                    <tr>
                        <td>{{$curriculum->program_code}}</td>
                        <td>{{$curriculum->program_name}}</td>
                        <td><a href="{{url('registrar',array('list_curricula','tesda', $curriculum->program_code))}}">View Curricula</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@stop