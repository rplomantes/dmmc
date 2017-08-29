@extends('layouts.registrarapp')
@section('content')
<style>
    .label{color: gray;}
</style>

<div class="row">
    <div class='col-sm-12'>
        <div id="imaginary_container">
            <h3>Subject Scheduling</h3>
            <div class="form form-group">

                <div class="col-sm-12">
                    <div class="col-sm-6">
                        <label class="label">Select Subject</label>
                        <select id="track" class="form form-control">
                            <option value="">Select Course</option>
                            @foreach ($tracks as $track)
                            <option value="{{$track->track}}">{{$track->track}}</option>
                            @endforeach
                        </select>
                    </div>

                    <input type="hidden" id="school_year" value="{{$school_year->school_year}}">
                    <input type="hidden" id="period" value="{{$school_year->period}}">

                    <div id="yearsection">
                        <div class="col-sm-3">
                            <label class="label">Level</label>
                            <select id="level" class="form form-control">
                                <option value=""></option>
                                <option value="Grade 11">Grade 11</option>
                                <option value="Grade 12">Grade 12</option>
                            </select>
                        </div>
                        <div class="col-sm-3">
                            <label class="label">Section</label>
                            <select id="section" class="form form-control" onchange="getyearsection(track.value)">
                                <option value=""></option>
                                <option value="1">Section 1</option>
                                <option value="2">Section 2</option>
                                <option value="3">Section 3</option>
                                <option value="4">Section 4</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-12" id="courses">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<script>
    function getyearsection(track) {
        array = {};
        array['school_year'] = $("#school_year").val();
        array['period'] = $("#period").val();
        array['section'] = $("#level").val();
        array['level'] = $("#section").val();
        $.ajax({
            type: "GET",
            url: "/registrar/ajax/getyearsection/shs/" + track,
            data: array,
            success: function (data) {
                $('#courses').html(data);
            }

        });
    }
</script>
@stop