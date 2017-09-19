<style>    
    .thd, .tdd {
        border-collapse: collapse;
        border: 1px solid black;
    }

    table, td, th {
        border-collapse: collapse;
        border: 1px solid black;

    }
    .page_break { 
        page-break-before: always;
    }
    .watermark 
    {
        opacity: 0.2;
        color: BLACK;
        position: absolute;
        bottom: 239px;
        right: 112px;
        z-index: -1;
    }
</style>
<div align="center">
    <b>DMMC INSTITUTE OF HEALTH SCIENCES</b><br>
    <small>#143 Narra St., Mountainview Subd., Tanauan City, Batangas</small><br><br><br>
    <b>STUDENT LIST</b><br>
</div>
<br><br>
<?php
$cn = 0;
?>
<table width="100%">
    <thead>
        <tr>
        <th width="5%">No </th><th width="15%">ID Number</th><th width="40%">Name</th><th width="30%">Course/Strand</th><th width="20%">Date Enrolled</th>
        </tr>
    </thead>
    <tbody>
@if (count($lists)>0)
@foreach ($lists as $list)
<?php
$user = \App\User::where('idno', $list->idno)->first();
?>
    <tr>
        <td><?php $cn = $cn+1; ?>{{$cn}}</td>
        <td>{{$list->idno}}</td>
        <td>{{$user->lastname}}, {{$user->firstname}} {{$user->middlename}}</td>
        <td>@if ($list->academic_type=="Senior High School") {{$list->track}} @else{{$list->program_code}}@endif</td>
        <td>{{$list->date_enrolled}}</td>
    </tr>
@endforeach
@else
<tr><td colspan="5"><i>No Students Enrolled!</i></td></tr>
@endif
    </tbody>
</table>