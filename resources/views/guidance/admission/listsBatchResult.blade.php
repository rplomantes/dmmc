@extends('layouts.guidanceapp')
@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="table-responsive">
            <div id='displayexambatch'>
                <table class="table table-condensed">
                    <thead>
                    <th class="col-sm-2">ID</th>
                    <th class="col-sm-4">Name</th>
                    <th class="col-sm-3">Intended Course</th>
                    <th class="col-sm-3">Exam Result</th>
                    </thead>
                    <tbody>
                        @foreach($lists as $list)
                        <tr>
                            <td>{{$list->idno}}</td>
                            <td><a href="{{url('guidance',array('viewinfo',$list->idno))}}">{{$list->firstname}} {{$list->middlename}} {{$list->lastname}} {{$list->extensionname}}</a></td>
                            <td>{{$list->course}}</td>
                            <td>
                                <input type="radio" name="exam_result[{{$list->idno}}]" value="Passed" onclick="changevalue('{{$list->idno}}', 'Passed')" 
                                       @if($list->exam_result == "Passed")
                                       checked="checked"
                                       @endif> Passed
                                       <input type="radio" name="exam_result[{{$list->idno}}]" value="Failed" onclick="changevalue('{{$list->idno}}', 'Failed')"
                                       @if($list->exam_result == "Failed")
                                       checked="checked"
                                       @endif> Failed
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>    
    </div>    
</div>   
<script>
    function changevalue(idno, value){
    $.ajax({
    type: "GET",
            url: "/guidance/ajax/changevalue/" + idno + "/" + value,
            data: "",
            success: function (data) {
            }
    });
//        alert(idno + " " +value);
    }
</script>
@stop
