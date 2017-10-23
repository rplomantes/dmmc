@extends('layouts.registrarapp')
@section('content')
<div class="row">
    <div class='col-sm-12'>
        <div id="imaginary_container">
            @if(isset($course))
            <?php
            $course_info = \App\Curriculum::where('course_code', $course)->first();
            ?>
            <h3>{{$course_info->course_code}} - {{$course_info->course_name}}</h3>
            @endif
            @if(isset($prof))
            <?php
            $prof_info = \App\User::where('idno', $prof)->first();
            ?>
            <h4>Prof. {{$prof_info->firstname}} {{$prof_info->lastname}} {{$prof_info->extensionname}}</h4>
            @endif
            @if(isset($grades))

            <form class='form-horizontal' method="POST" action="{{url('/saveentry_shs')}}" >
    {{ csrf_field() }}
           <input type='hidden' name='course_code' value='{{$course}}'>
                <table class='table table-bordered table-condensed'>
                    <thead>
                    <th style='text-align: center;'>ID</th>
                    <th>Name</th>
                    <th>Prelim</th>
                    <th>Midterm</th>
                    <th>Final</th>
                    <th>Final Grade</th>
                    <th>Grade Point</th>
                    <th>Remarks</th>
                    </thead>
                    @foreach($grades as $key=>$info)
                    <?php
                    $infos = App\User::where('idno', $info['idno'])->first();
                    $status = App\Status::where('idno', $info['idno'])->first();

                    $exist = App\User::where('idno', $info['idno'])->exists();
                    ?>
                    @if($exist)
                    <tr>
                        <td class="col-sm-1" style='text-align: center;'>{{$info['idno']}}</td>
                        <td class="col-sm-4">{{$infos->lastname}}, {{$infos->firstname}} {{$infos->middlename}} {{$infos->extensionname}}</td>
                        <td class="col-sm-1"><input class='form-control' type='text' name='prelim[{{$info['idno']}}]' value='{{number_format($info['prelim'],2)}}'></td>
                        <td class="col-sm-1"><input class='form-control' type='text' name='midterm[{{$info['idno']}}]' value='{{number_format($info['midterm'],2)}}'></td>
                        <td class="col-sm-1"><input class='form-control' type='text' name='final[{{$info['idno']}}]' value='{{number_format($info['final'],2)}}'></td>
                        <td class="col-sm-1"><input class='form-control' type='text' name='final_grade[{{$info['idno']}}]' value='{{$info['final_grade']}}'></td>
                        <td class="col-sm-1"><input class='form-control' type='text' name='grade_point[{{$info['idno']}}]' value='{{number_format($info['grade_point'],2)}}'></td>
                        <td class="col-sm-2"><input class='form-control' type='text' name='remarks[{{$info['idno']}}]' value='{{$info['remarks']}}'></td>
                    </tr>
                    @else
                    <tr>
                        <td colspan="8" class="label-danger" style="color: whitesmoke">Record unavailable for {{$info['idno']}}</td>
                    </tr>
                    @endif
                    @endforeach
                </table>
                <input type='submit' value='Save Grades' class='form-control col-sm-12 btn btn-success'>
            </form>
            @endif
        </div>
    </div>
</div>
@stop

