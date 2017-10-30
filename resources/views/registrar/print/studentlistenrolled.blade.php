<?php
$number = 0;
?>
<div align="center">
    <b>DMMC INSTITUTE OF HEALTH SCIENCES</b><br>
    <small>#143 Narra St., Mountainview Subd., Tanauan City, Batangas</small><br><br><br>
    <b>STUDENT LIST</b><br><br><br>
</div>

<table class="table" width="75%">
    <tr>
        <td width="10%">Subject</td>
        <td width="5%">:</td>
        <td style="border-bottom: 1pt solid black;" width="85%">{{$offering_id->course_code}} - {{$offering_id->course_name}}</td>
    </tr>
    <tr>
        <td>Section</td>
        <td>:</td>
        <td style="border-bottom: 1pt solid black;">
            @if($offering_id->program_code!="Senior High School")
            {{$offering_id->program_code}} - {{$offering_id->level}} year - section {{$offering_id->section}}
            @else
            {{$offering_id->track}} - {{$offering_id->level}} - section {{$offering_id->section}}
            @endif
        </td>
    </tr>
    <tr>
        <td>Instructor</td>
        <td>:</td>
        <td style="border-bottom: 1pt solid black;">{{$instructor}}</td>
    </tr>
</table><br>
<table class="table" width="100%">
    <tr>
        <th style="border-bottom: 1pt solid black;" width="5%">No.</th>
        <th style="border-bottom: 1pt solid black;" width="20%">ID Number</th>
        <th style="border-bottom: 1pt solid black;" width="85%">Student Name</th>
    </tr>
    @foreach ($studentlists as $studentlist)
    <tr>
        <td><div align="right"><?php $number = $number + 1;?>{{$number}}.</div></td>
        <td>{{$studentlist->idno}}</td>
        <td>{{$studentlist->lastname}}, {{$studentlist->firstname}} {{$studentlist->middlename}}</td>
    </tr>
    @endforeach
</table>