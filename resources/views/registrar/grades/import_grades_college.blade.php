@extends('layouts.registrarapp')
@section('content')
<style>
    .label{color: gray;}
</style>

<div class="row">
    <div class='col-sm-12'>
        <div id="imaginary_container">

                <form action="{{ URL::to('/importExcel') }}" class="form-horizontal" method="post" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <input type="file" name="import_file" /><br>

                    <button class="btn btn-primary">Import File</button>

                </form>
        </div>
    </div>
</div>
@stop