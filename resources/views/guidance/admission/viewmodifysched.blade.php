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
            <form class="form-horizontal" role="form" method="POST" action="{{ url('/guidance','updatesched') }}">
                {{ csrf_field() }}
                <input type='hidden' name='id' value='{{$schedules->id}}'>
                <div class="form form-group">
                    <div class='col-sm-6'>
                        <label class='label'>Date & Time</label>
                        <div class="input-group stylish-input-group">
                        <input name="datetime" type='text' id='datetimepicker' class='form form-control' placeholder='yyyy-mm-dd hh:mm:ss' value="{{$schedules->datetime}}">
                        <span class="input-group-addon">
                                <span class="fa fa-calendar"></span> 
                            </span>
                        </div>
                    </div>
                    <div class='col-sm-6'>
                        <label class='label'>Place</label>
                        <input name="place" type='text'class='form form-control' value="{{$schedules->place}}">
                    </div>
                </div>

                <div class="form form-group">
                    <div class='col-sm-6'>
                        <label class='label'>Is Active</label>
                        <select name="is_remove" class='form form-control'>
                            <option value='0' @if ($schedules->is_remove == 0) selected='selected' @endif>Yes</option>
                            <option value='1' @if ($schedules->is_remove == 1) selected='selected' @endif>No</option>
                        </select>
                    </div>
                </div>

                <div class='form form-group'>
                    <div class='col-sm-12'>
                        <input type='submit' class='col-sm-12 btn btn-primary' value='Update Exam Schedule'>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@stop