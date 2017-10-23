@extends('layouts.registrarapp')
@section('content')
<style>
    .label{color: gray;}
</style>
<?php 
$yearperiod = \App\CtrSchoolYear::where('academic_type', 'College')->orWhere('academic_type', 'TESDA')->first();
$school_years = \App\GradeCollege::distinct()->get(['school_year']);
$periods = \App\GradeCollege::distinct()->get(['period']);
$instructors = \App\User::where('accesslevel', 10)->get();
?>
<div class="row">
    <div class='col-sm-12'>
        <div id="imaginary_container">
            <form action="{{ URL::to('/importExcelCollege') }}" class="form-horizontal" method="post" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="form-group">
                    <div class="col-sm-12"><h3>Import Grades - College/TESDA</h3></div>
                    <div class="col-sm-6">
                        <label> </label>
                        <input type="file" name="import_file" />
                    </div>
                    <div class="col-sm-12">
                        <br>
                        <button class="btn btn-primary col-sm-12">Import Grades</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@stop