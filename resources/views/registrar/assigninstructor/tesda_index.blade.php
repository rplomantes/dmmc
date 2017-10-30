@extends('layouts.registrarapp')
@section('content')
<style>
    .label{color: gray;}
</style>

<div class="row">
    <div class='col-sm-12'>
        <div id="imaginary_container">
            <h3>Instructors</h3>
            @if (count($instructors)>0)
            <table class="table table-condensed">
                <thead>
                <th>ID</th>
                <th>Name</th>
                <th>View</th>
                </thead>
                <tbody>
                    @foreach($instructors as $instructor)
                    <tr>
                        <td>{{$instructor->idno}}</td>
                        <td>{{$instructor->firstname}} {{$instructor->middlename}} {{$instructor->lastname}} {{$instructor->extensionname}}</td>
                        <td><a href="{{url('registrar', array('assign_instructor', 'view_profile_tesda', $instructor->id))}}">View Profile</td>
                    </tr>
                    @endforeach
                </tbody>
            @else
                <div class="alert alert-danger">No Instructor added yet to the system. Please see administrator!</div>
            @endif
            </table>
        </div>
    </div>
</div>
@stop