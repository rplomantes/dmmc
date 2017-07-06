@extends('layouts.guidanceapp')
@section('content')

<div class="row">
    <div class="col-sm-10 col-sm-offset-1">
        <div id="imaginary_container"> 
            <div class="input-group stylish-input-group">
                <input type="text" id="search" class="form-control"  placeholder="Search" >
                <span class="input-group-addon">
                    <span class="fa fa-search"></span>      
                </span>
            </div>
        </div>
    </div>
</div><br>
<div class="row">
    <div class="col-sm-12">
        <div class="table-responsive">
            <div id='displaystudent'>
            <table class="table table-condensed">
                <thead>
                <th class="col-sm-2">ID number</th>
                <th class="col-sm-4">Name</th>
                <th class="col-sm-3">Intended Course</th>
                <th class="col-sm-1">Status</th>
                <th class="col-sm-2">Action</th>
                </thead>
                @foreach($lists as $list)
                <tbody>
                
                    <tr>
                        <td>{{$list->idno}}</td>
                        <td>{{$list->lastname}} {{$list->extensionname}}, {{$list->firstname}} {{$list->middlename}}</td>
                        <td>{{$list->course}} @if(($list->major) !== null) Major in {{$list->major}} @else @endif</td>
                        <td>{{$list->status}}</td>
                        <td><a href="/guidance/viewinfo/{{$list->idno}}">View Profile</a></td>
                    </tr>
               
                </tbody>
                @endforeach
            </table>
                 </div>
        </div>    
    </div>    
</div>
<!--Ajax Module-->
<script type="text/javascript">
    $(document).ready(function () {
        $("#search").keypress(function (e) {
            var theEvent = e || window.event;
            var key = theEvent.keyCode || theEvent.which;
            var array = {};
            array['search'] = $("#search").val();
            if (key == 13) {
                $('#displaystudent').empty();
                $.ajax({
                    type: "GET",
                    url: "/ajax/getmainstudentlist",
                    data: array,
                    success: function (data) {  
                        $('#displaystudent').html(data)
                    }
                });
            }
        })
    })
</script>    
@stop
