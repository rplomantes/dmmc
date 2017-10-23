<?php
$cn = 0;
?>
<table class="table table-condensed">
    <thead>
        <tr>
            <th>CN</th><th>ID No</th><th>Name</th><th>Strand</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($lists as $list)
        <?php
        $cn = $cn +1;
        $user = \App\User::where('idno', $list->idno)->first();
        ?>
        <tr>
            <td>{{$cn}}<td>{{$user->idno}}</td><td><a href="javascript: void(0);" onclick="removetosection('{{$user->idno}}', level.value, track.value)">{{$user->lastname}}, {{$user->firstname}} {{$user->middlename}} {{$user->extensionname}}</a></td><td>{{$list->track}}</td>
        </tr>
        @endforeach
    </tbody>
</table>