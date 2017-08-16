<div align="center">
    <b>DMMC INSTITUTE OF HEALTH SCIENCES</b><br>
    <small>#143 Narra St., Mountainview Subd., Tanauan City, Batangas</small><br><br><br>
    <b>List of Passed Applicants</b><br>
    <b></b>
    <br>
</div>
<style>
table { border-collapse: collapse; }
tr:nth-child(3) { border: solid thin; }
</style>
<table class="table" width="100%" >
    <tr width="100%">
        <th width="5%" style="border-bottom: 1pt solid black;">No.</th>
        <th width="13%" style="border-bottom: 1pt solid black;">Reference No.</th>
        <th width="20%" style="border-bottom: 1pt solid black;">Name</th>
        <th width="10%" style="border-bottom: 1pt solid black;">Course</th>
        <th width="30%" style="border-bottom: 1pt solid black;">Schedule</th>
    </tr>
    @if(count($lists)>=1)
<?php $count = 1; ?>
    @foreach ($lists as $list)
    <tr>
        <td><?php echo $count++;?></td>
        <td>{{$list->idno}}</td>
        <td>{{$list->firstname}} {{$list->middlename}} {{$list->lastname}} {{$list->extensionname}}</td>
        <td>{{$list->course_intended}}</td>
        <td>{{ date ('M d, Y (D) - g:i A', strtotime($list->datetime))}} - {{$list->place}}</td>
    </tr>

    @endforeach
    @else 
    <tr>
        <td colspan="5" align="center">No applicants had passed the exam.</td>
    </tr>
    @endif
</table>