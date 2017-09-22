@extends('layouts.registrarapp')
@section('content')
<?php
$tracks = \App\Curriculum::distinct()->where('track', $track)->get(['program_code'])->first();
$levels = \App\Curriculum::distinct()->where('track', $track)->where('curriculum_year', $curriculum_year)->orderBy('level','asc')->orderBy('period', 'asc')->get(['level', 'period']);

?>
<style>
    .label{color: gray;}
</style>

<div class="row">
    <div class='col-sm-12'>
        <div id="imaginary_container">
            <h3>{{$tracks->program_code}} - {{$track}} </h3>
            <h4>Curriculum Year: {{$curriculum_year}} </h4>
            @foreach ($levels as $level)
            <table class="table table-condensed">
                <thead>
                <th>@if ($level->period== '1st') 1st Semester @elseif ($level->period== '2nd') 2nd Semester @elseif ($level->period== 'Summer') Summer @else @endif</th>
                <th>@if ($level->level== 'Grade 11') GRADE 11 @elseif ($level->level== 'Grade 12') GRADE 12 @else @endif</th>
                <th></th>
                </thead>
                <tbody>
                    <tr>
                        <th class='col-sm-8'>Subject Name</th>
                        <th class='col-sm-2'>Total Number of Hours</th>
                        <th class='col-sm-2'>No. of Hours/Week</th>
                    </tr>
<?php
$curriculums = \App\Curriculum::where('track', $track)->where('curriculum_year', $curriculum_year)->where('level', $level->level)->where('period',$level->period)->get();
?>
                    <?php
                    $totalHours = 0;
                    $totalWeeks = 0;
                    ?>
                    @foreach ($curriculums as $curriculum)
                    <tr>
                        <td>{{$curriculum->course_name}}</td>
                        <td>{{$curriculum->hours}} <?php $totalHours = $curriculum->hours + $totalHours; ?></td>
                        <td><?php $Weeks=$curriculum->hours/20; $totalWeeks = $Weeks + $totalWeeks; ?>{{$Weeks}}</td>
                    </tr>
                    @endforeach
                    <tr>
                        <th><div align='right'>Total</div> </th>
                        <th><?php echo $totalHours; ?></th>
                        <td><?php echo $totalWeeks; ?></td>
                    </tr>
                    <tr>
                        <th><div align='right'>No. of Hours/Day</div></th>
                        <th><?php echo $totalHours/100; ?></th>
                        <td></td>
                    </tr>
                </tbody>
            </table>
            @endforeach
        </div>
    </div>
</div>
@stop