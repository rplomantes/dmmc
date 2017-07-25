@extends('layouts.registrarapp')
@section('content')
<?php
$track = \App\Curriculum::distinct()->where('program_code', $track)->get(['program_name'])->first();
$levels = \App\Curriculum::distinct()->where('program_code', $track)->where('curriculum_year', $curriculum_year)->get(['level', 'period']);

?>
<style>
    .label{color: gray;}
</style>

<div class="row">
    <div class='col-sm-12'>
        <div id="imaginary_container">
            <h3>{{$track->program_name}} - {{$track}} </h3>
            <h4>Curriculum Year: {{$curriculum_year}} </h4>
            @foreach ($levels as $level)
            <table class="table table-condensed">
                <thead>
                <th>@if ($level->period== '1st') 1st Semester @elseif ($level->period== '2nd') 2nd Semester @elseif ($level->period== 'Summer') Summer @else @endif</th>
                <th>@if ($level->level== 'Grade 11') GRADE 11 @elseif ($level->level== 'Grade 12') GRADE 12 @else @endif</th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                </thead>
                <tbody>
                    <tr>
                        <th class='col-sm-3'>Subject Code</th>
                        <th class='col-sm-7'>Subject Description</th>
                        <th class='col-sm-2'>HOURS</th>
                    </tr>
<?php
$curriculums = \App\Curriculum::where('program_code', $track)->where('curriculum_year', $curriculum_year)->where('level', $level->level)->where('period',$level->period)->get();
?>
                    <?php
                    $totalHours = 0;
                    ?>
                    @foreach ($curriculums as $curriculum)
                    <tr>
                        <td>{{$curriculum->course_code}}</td>
                        <td>{{$curriculum->course_name}}</td>
                        <td>{{$curriculum->lec}} <?php $totalHours = $curriculum->hours + $totalHours; ?></td>
                    </tr>
                    @endforeach
                    <tr>
                        <td></td>
                        <th><div align='right'>Total</div> </th>
                        <th><?php echo $totalHours; ?></th>
                    </tr>
                </tbody>
            </table>
            @endforeach
        </div>
    </div>
</div>
@stop