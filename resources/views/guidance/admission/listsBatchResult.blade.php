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
                        <?php
                        $status = \App\Status::where('idno', $list->idno)->first();
                        ?>
                        <tr>
                            <td>{{$list->idno}}</td>
                            <td><a href="{{url('guidance',array('viewinfo',$list->idno))}}">{{$list->firstname}} {{$list->middlename}} {{$list->lastname}} {{$list->extensionname}}</a></td>
                            <td>{{$list->course}}</td>
                            <td>
                                <select @if($status->status>=2)disabled="disabled" @else @endif class="form form-control" name="exam_result[{{$list->idno}}]" onchange="changevalue('{{$list->idno}}', this.value)">
                                    <option value="">Not Yet Graded</option>
                                    <option value="Passed"
                                            @if($list->exam_result == "Passed")
                                       selected="selected"
                                       @endif>Passed</option>
                                    <option value="Failed"
                                            @if($list->exam_result == "Failed")
                                       selected="selected"
                                       @endif>Failed</option>
                                </select>
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
