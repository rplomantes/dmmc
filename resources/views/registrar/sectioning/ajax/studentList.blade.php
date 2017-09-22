<?php
$statuses = \App\Status::where('school_year', $school_year->school_year)->where('level', $level)->where('status', 4)->where('section', NULL)->get();
$cn = 0;
?>
<table class="table table-condensed">
    <thead>
        <tr>
            <th>CN</th><th>ID No</th><th>Name</th><th>Strand</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($statuses as $status)
        <?php
        $cn = $cn +1;
        $user = \App\User::where('idno', $status->idno)->first();
        ?>
        <tr>
            <td>{{$cn}}<td>{{$user->idno}}</td><td><a href="javascript: void(0);" onclick="addtosection('{{$user->idno}}', level.value, track.value)">{{$user->lastname}}, {{$user->firstname}} {{$user->middlename}} {{$user->extensionname}}</a></td><td>{{$status->track}}</td>
        </tr>
        @endforeach
    </tbody>
</table>