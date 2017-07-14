@extends('layouts.guidanceapp')
@section('content')
<style>
    .label{color: gray;}
</style>
<div class="row">
    <div class="col-sm-9 col-sm-offset-1">
        <div id="imaginary_container"> 
            <div class="input-group stylish-input-group">
                <input type="text" id="search" class="form-control"  placeholder="Search" >
                <span class="input-group-addon">
                    <span class="fa fa-search"></span>
                </span>
            </div>
        </div>
    </div>
    <div class='col-sm-1'>
        <a href='{{url('guidance','addexamsched')}}'><div class='btn btn-success'>New</div></a>
    </div>
</div><br>

@if(count($scheds)>0)
<div class="row">
    <div class="col-sm-12">
        <div class='table-responsive'>
            <div id='displayexamschedule'>
                <table class="table table-condensed">
                    <thead>
                    <th class="col-sm-1">ID</th>
                    <th class="col-sm-4">Datetime</th>
                    <th class="col-sm-2">Place</th>
                    <th class="col-sm-2">Status</th>
                    <th class="col-sm-3">Action</th>
                    </thead>
                    <tbody>
                        @foreach($scheds as $sched)
                        <tr>
                            <td>{{$sched->id}}</td>
                            <td>{{ date ('M d, Y (D) - g:i A', strtotime($sched->datetime))}}</td>
                            <td>{{$sched->place}}</td>
                            <td>@if ($sched->is_remove==1) Not Active @else Active @endif</td>
                            <td><a href='/guidance/view_examsched/{{$sched->id}}'>Modify</a> | <a href='/guidance/delete_examsched/{{$sched->id}}'>Delete</a> | <a href="/guidance/viewbatch/{{$sched->id}}">View List</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@else
<div class="alert alert-danger">No exam schedule has been set to the system.  Please see administrator.</div>
@endif

<!--Ajax Module-->
<script type="text/javascript">
    $(document).ready(function () {
        $("#search").keypress(function (e) {
            var theEvent = e || window.event;
            var key = theEvent.keyCode || theEvent.which;
            var array = {};
            array['search'] = $("#search").val();
            if (key == 13) {
                $('#displayexamschedule').empty();
                $.ajax({
                    type: "GET",
                    url: "/ajax/getexamschedule",
                    data: array,
                    success: function (data) {  
                        $('#displayexamschedule').html(data)
                    }
                });
            }
        })
    })
</script> 
@stop
