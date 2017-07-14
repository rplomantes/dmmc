@extends('layouts.guidanceapp')
@section('content')
<style>
    .label{color: gray;}
</style>
<div class="row">
    
    <div class="col-sm-12">@if (count($errors) > 0)
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
        <form class="form-horizontal" target="_blank" method="POST" action="{{url('/guidance', 'generate_report')}}">
            {{ csrf_field()}}
            <h3>List of Passed Applicants</h3>

            <div class="form form-group">
                <div class="col-sm-12">
                    <label class="label">Department</label>
                    <select class="form-control" name="acad_type" id="acad_type" onchange="changeprogram(this.value)">
                        <option value="">Select Department</option>
                        @foreach ($academic_types as $academic_type)
                        <option value="{{$academic_type->academic_type}}">{{$academic_type->academic_type}}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="form form-group">
                <div class="col-sm-12" id="acad_program">
                </div>
            </div>

            <div class="form form-group">
                <div class="col-sm-12">
                    <input type="submit" name="submit" value="Generate Report" class="form form-control btn btn-primary">    
                </div>    
            </div>
        </form>
    </div>
</div>
<script>
    function changeprogram(acad_type)
            $.ajax( {
            type: "GET",
                    url: "/ajax/getacademicprogram/" + acad_type,
                    success: function (data) {
                    $('#acad_progs').empty();
                            $('#acad_program').html(data);
                    }
            }
            );
</script>
@stop
