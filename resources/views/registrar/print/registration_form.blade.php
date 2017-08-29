<style>    
    .thd, .tdd {
        border-collapse: collapse;
        border: 1px solid black;
    }
    
    .tables, .tds, .ths {
        border-collapse: collapse;
        border: 1px solid black;
    }
</style>
<div align="center">
    <b>DMMC INSTITUTE OF HEALTH SCIENCES</b><br>
    <small>#143 Narra St., Mountainview Subd., Tanauan City, Batangas</small><br><br>
    <small>Registration No.: {{$status->registration_no}}</small><br>
    <b>REGISTRATION FORM</b><br>
    <small>{{$school_year->school_year}} - <?php $yearend = $school_year->school_year + 1;
echo $yearend; ?> {{$school_year->period}} Semester</small><br>
</div>
<br>
<table class='table' width="100%">
    <tr>
        <td>Student No:</td>
        <td style="border-bottom: 1pt solid black;"><b>{{strtoupper($user->idno)}}</b></td>
    </tr>
    <tr>
        <td>Name:</td>
        <td style="border-bottom: 1pt solid black;">{{strtoupper($user->firstname)}} {{strtoupper($user->middlename)}} {{strtoupper($user->lastname)}} {{strtoupper($user->extensionname)}}</td>
    </tr>
    <tr>
        <td>Course/Level:</td>
        <td style="border-bottom: 1pt solid black;">{{$status->program_code}} - {{$status->level}} Year</td>
    </tr>
</table>
<br><b>REGISTRATION</b><br>
<table class="tables"width="100%">
    <tr>
        <th class='ths' width="40%">Subject</th>
        <th class='ths' width="30%">Schedule/Room</th>
        <th class='ths' width="20%">Instructor</th>
        <th class='ths' width="10%">Units/Hrs</th>
    </tr>
    <?php
    $total = 0;
    ?>
    @foreach ($grades as $grade)
    <tr>
        <td class='tds'><small>{{$grade->course_code}} {{$grade->course_name}}</small></td>
        <td class='tds'>
            <?php
            $schedule2s = \App\Schedule::distinct()->where('course_offering_id', $grade->course_offering_id)->get(['time_start', 'time_end', 'room']);
            ?>
            @foreach ($schedule2s as $schedule2)
            <?php
            $days = \App\Schedule::distinct()->where('course_offering_id', $grade->course_offering_id)->where('time_start', $schedule2->time_start)->where('time_end', $schedule2->time_end)->where('room', $schedule2->room)->get(['day']);
            ?>
                @foreach ($days as $day){{$day->day}}@endforeach {{date('g:i A', strtotime($schedule2->time_start))}} - {{date('g:i A', strtotime($schedule2->time_end))}} [{{$schedule2->room}}]<br>
            <!--{{$schedule2->day}} {{$schedule2->time_start}} - {{$schedule2->time_end}}<br>-->
            @endforeach
        </td>
        <td class='tds'>
            <?php
            $offering_id = \App\CourseOffering::find($grade->course_offering_id);
            $instructor = \App\User::where('id', $offering_id->instructor_id)->first();
            ?>
            @if (count($instructor)>0)
            {{$instructor->firstname}} {{$instructor->lastname}}
            @endif
        </td>
        <td class='tds' align='center'><?php $total = $total + $grade->lec; ?>{{$grade->lec}}</td>
    </tr>
    @endforeach
    <tr>
        <th class='tds' colspan="3">Total Units/Hrs</th>
        <th class='ths'align='center'>{{$total}}</th>
    </tr>
</table>

<br><b>ASSESSMENT</b>
@if (count($ledger_due_dates)>0)
<br><strong>Downpayment: Php {{number_format($downpayment->amount,2)}}</strong>

<table class='tables' width='100%'>
    <tr>
        <th class='ths'>Amount</th>
        <th class='ths'>Due Date</th>
        <td width="50%" rowspan="{{count($ledger_due_dates)+1}}">
            <i style="color:red;"><small><center>*For installment basis, please pay the appropriate amounts on or before the stated due dates to avoid late payment charges. Thank you!</center></small></i>
        </td>
    </tr>
    @foreach ($ledger_due_dates as $ledger_due_date)
    <tr>
        <td class='tds'>Php {{number_format($ledger_due_date->amount,2)}}</td>
        <td class='tds'>{{ date ('D, M d, Y', strtotime($ledger_due_date->due_date))}}</td>
    </tr>
    @endforeach
</table>
@else
<table class="tables" width="100%">
    <tr>
        <th class="ths">Description</th>
        <th class="ths">Amount</th>
        <th class="ths">Date</th>
    </tr>
    <tr>
        <td class="tds">Full Payment</td>
        <td class='tds'>Php {{number_format($downpayment->amount,2)}}</td>
        <td class='tds'>{{ date ('D, M d, Y', strtotime($downpayment->due_date))}}</td>
    </tr>
</table>
@endif
<br>
<table width="100%">
    <tr>
        <td rowspan="2" class="tdd" width="50%">
            <center>I have read and fully understood the STUDENT PLEDGE AND DECLARATION set forth on the other side of this registration form.</center><br>
            <center>____________________________<br><strong>{{$user->lastname}}, {{$user->firstname}} {{$user->middlename}} {{$user->extensionname}}</strong></center>
        </td>
        <td class="tdd" width="50%">
        <center>Processed by:<br><br>____________________________<br><strong>{{Auth::user()->firstname}} {{Auth::user()->lastname}}</strong></center></td>
    </tr>
    <tr>
        <td class="tdd">
            <center>Approved by:<br><br>
                ____________________________<br><strong>Ms. Liza Zabalvaro</strong><br><small>School Registrar</small>
            </center>
        </td>
    </tr>
</table>
