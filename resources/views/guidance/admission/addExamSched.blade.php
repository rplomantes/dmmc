@extends('layouts.guidanceapp')
@section('content')
<style>
    .label{color: gray;}
</style>

<div class="row">
    <div class='col-sm-12'>
        <div id="imaginary_container">
            @if (count($errors) > 0)
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif
            <form class="form-horizontal" role="form" method="POST" action="{{ url('/guidance','addsched') }}">
                {{ csrf_field() }}
                <div class="form form-group">
                    <div class='col-sm-6'>
                        <label class='label'>Date & Time</label>
                        <input name="datetime" type='text' id='datepicker' class='form form-control' placeholder='yyyy-mm-dd hh:mm:ss'>
                    </div>
                    <div class='col-sm-6'>
                        <label class='label'>Place</label>
                        <input name="place" type='text'class='form form-control'>
                    </div>
                </div>

                <div class="form form-group">
                    <div class='col-sm-6'>
                        <label class='label'>Is Active</label>
                        <select name="is_remove" class='form form-control'>
                            <option value='0'>Yes</option>
                            <option value='1'>No</option>
                        </select>
                    </div>
                </div>

                <div class='form form-group'>
                    <div class='col-sm-12'>
                        <input type='submit' class='col-sm-12 btn btn-primary' value='Add Exam Schedule'>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@stop