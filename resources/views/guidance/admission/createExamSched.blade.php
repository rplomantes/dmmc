@extends('layouts.guidanceapp')
@section('content')
<style>
    .label{color: gray;}
</style>
<div class="row">
    <div class="col-sm-12">
        <div id="imaginary_container">
            <form class="form-horizontal" role="form" method="POST" action="{{ url('/#') }}">
                <div class="col-sm-12">
                    <label class="label"> Time</label>
                    <input type="text" class="form form-control">
                </div>
            </form>
    </div>
</div>
@stop
