@extends('layouts.registrarapp')
@section('content')
<style>
    .label{color: gray;}
</style>
<div class="row">
    <div class="col-sm-12">
        <table class='table table-condensed'>
            <thead>
                <tr>
                    <th width='5%'>CN</th>
                    <th>ID Number</th>
                    <th>Student Name</th>
                    <th width='8%'>Prelim</th>
                    <th width='8%'>Midterm</th>
                    <th width='8%'>Final</th>
                    <th width='8%'>Final Grade</th>
                    <th width='8%'>Grade Point</th>
                    <th width='8%'>Remarks</th>
                </tr>
            </thead>
            <tbody>
                <?php $cn=0; ?>
                @foreach ($students as $student)
                <?php
                $cn = $cn + 1;
                $stud_details = \App\User::where('idno', $student->idno)->first();
                ?>
                <tr>
                    <td>{{$cn}}</td>
                    <td>{{$stud_details->idno}}</td>
                    <td>{{$stud_details->lastname}}, {{$stud_details->firstname}} {{$stud_details->extensionname}}</td>
                    <td><input class="form form-control" id="prelim" name="prelim" value="{{$student->prelim}}" onchange="changeprelim(this.value, '{{$student->id}}')"></td>
                    <td><input class="form form-control" id="midterm" name="midterm" value="{{$student->midterm}}" onchange="changemidterm(this.value, '{{$student->id}}')"></td>
                    <td><input class="form form-control" id="final" name="final" value="{{$student->final}}" onchange="changefinal(this.value, '{{$student->id}}')"></td>
                    <td><input class="form form-control" id="final_grade" name="final_grade" value="{{$student->final_grade}}"></td>
                    <td><input class="form form-control" id="grade_point" name="grade_point" value="{{$student->grade_point}}"></td>
                    <td><input class="form form-control" id="remarks" name="remarks" value="{{$student->remarks}}"></td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<script>
    function changeprelim(grade, id){
        $.ajax({
            type: "GET",
            url: "/ajax/manualchange_college/prelim/" + id + "/" + grade,
            success: function (data) {
            }

        });
    }
    function changemidterm(grade, id){
        $.ajax({
            type: "GET",
            url: "/ajax/manualchange_college/midterm/" + id + "/" + grade,
            success: function (data) {
            }

        });
    }
    function changefinal(grade, id){
        $.ajax({
            type: "GET",
            url: "/ajax/manualchange_college/final/" + id + "/" + grade,
            success: function (data) {
            }

        });
    }
</script>
@stop