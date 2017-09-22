@extends('layouts.registrarapp')
@section('content')
<?php
$program = \App\Curriculum::distinct()->where('program_code', $program_code)->get(['program_name'])->first();
$levels = \App\Curriculum::distinct()->where('program_code', $program_code)->where('curriculum_year', $curriculum_year)->orderBy('level','asc')->orderBy('period', 'asc')->get(['level', 'period']);

?>
<style>
    .label{color: gray;}
</style>

<div class="row">
    <div class='col-sm-12'>
        <div id="imaginary_container">
            <h3>{{$program->program_name}} - {{$program_code}} </h3>
            <h4>Curriculum Year: {{$curriculum_year}} </h4>
            <?php $totalUnits = 0; ?>
            @foreach ($levels as $level)
            <table class="table table-condensed">
                <thead>
                <th>@if ($level->period== '1st') 1st Semester @elseif ($level->period== '2nd') 2nd Semester @elseif ($level->period== 'Summer') Summer @else @endif</th>
                <th>@if ($level->level== '1st') FIRST YEAR @elseif ($level->level== '2nd') SECOND YEAR @elseif ($level->level== '3rd') THIRD YEAR @elseif ($level->level== '4th') FOURTH YEAR @elseif ($level->level== '5th') FIFTH YEAR @else @endif</th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                </thead>
                <tbody>
                    <tr>
                        <th class='col-sm-2'>Subject Code</th>
                        <th class='col-sm-7'>Subject Description</th>
                        <th class='col-sm-1'>LEC</th>
                        <th class='col-sm-1'>LAB</th>
                        <th class='col-sm-1'>UNITS</th>
                    </tr>
<?php
$curriculums = \App\Curriculum::where('program_code', $program_code)->where('curriculum_year', $curriculum_year)->where('level', $level->level)->where('period',$level->period)->get();
?>
                    <?php
                    $totalLec = 0;
                    $totalLab = 0;
                    ?>
                    @foreach ($curriculums as $curriculum)
                    <tr>
                        <td>{{$curriculum->course_code}}</td>
                        <td>{{$curriculum->course_name}}</td>
                        <td>@if ($curriculum->lec==0) @else {{$curriculum->lec}} @endif <?php $totalLec = $curriculum->lec + $totalLec; ?></td>
                        <td>@if ($curriculum->lab==0) @else {{$curriculum->lab}} @endif <?php $totalLab = $curriculum->lab + $totalLab; ?></td>
                        <td>{!!$curriculum->lec + $curriculum->lab!!}</td>
                    </tr>
                    @endforeach
                    <tr>
                        <td></td>
                        <th><div align='right'>Total</div> </th>
                        <th><?php echo $totalLec; ?></th>
                        <th><?php echo $totalLab; ?></th>
                        <th><?php $totalUnits = $totalUnits + $totalLec + $totalLab; ?> {!! $totalLec + $totalLab !!}</th>
                    </tr>
                </tbody>
            </table>
            @endforeach
            <table class="table table-condensed">
                <tr>
                        <th class='col-sm-2'></th>
                        <th class='col-sm-7'></th>
                        <th class='col-sm-1'></th>
                        <th class='col-sm-1'>Total Units:</th>
                        <th class='col-sm-1'>{!! $totalUnits !!}</th>
                </tr>
            </table>
        </div>
    </div>
</div>
@stop