<?php
$statuses = \App\Status::where('school_year', $school_year->school_year)->where('level', $level)->where('status', 4)->get();
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
            <td>{{$cn}}<td>{{$user->idno}}</td><td>{{$user->lastname}}, {{$user->firstname}} {{$user->middlename}} {{$user->extensionname}}</td><td>{{$status->track}}</td>
        </tr>
        @endforeach
    </tbody>
</table>