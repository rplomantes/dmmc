<style>    
    .thd, .tdd {
        border-collapse: collapse;
        border: 1px solid black;
    }

    .tables, .tds, .ths {
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
<div class = "watermark">
    <img src = "{{url("/images","dmmclogo.jpeg")}}" width="80%" alt="DMMCIHS Logo" class="img-thumbnail">
</div>
<div align="center">
    <b>DMMC INSTITUTE OF HEALTH SCIENCES</b><br>
    <small>#143 Narra St., Mountainview Subd., Tanauan City, Batangas</small><br><br>
    <small>Registration No.: {{$status->registration_no}}</small><br>
    <b>REGISTRATION FORM</b><br>
    <small>{{$school_year->school_year}} - <?php
        $yearend = $school_year->school_year + 1;
        echo $yearend;
        ?> {{$school_year->period}} Semester</small><br>
</div>
<br>
<table class='table' width="100%">
    <tr>
        <td width='15%'>Student No:</td>
        <td width="55%" style="border-bottom: 1pt solid black;"><b>{{strtoupper($user->idno)}}</b></td>
        <td><div align='right'>Date:</div></td>
        <td colspan="100%" style="border-bottom: 1pt solid black;">{{$status->date_assessed}}</td>
    </tr>
    <tr>
        <td>Name:</td>
        <td colspan="100%" style="border-bottom: 1pt solid black;">{{strtoupper($user->firstname)}} {{strtoupper($user->middlename)}} {{strtoupper($user->lastname)}} {{strtoupper($user->extensionname)}}</td>
    </tr>
    @if($status->academic_type!='Senior High School')
    <tr>
        <td>Course/Level:</td>
        <td colspan="100%" style="border-bottom: 1pt solid black;">{{$status->program_code}} - {{$status->level}} Year</td>
    </tr>
    @else
    <tr>
        <td>Strand:</td>
        <td width='55%' style="border-bottom: 1pt solid black;">{{$status->track}} - {{$status->level}}</td>
        <td><div align='right'>Section:</div></td>
        <td colspan="100%" style="border-bottom: 1pt solid black;">{{$status->section}}</td>
    </tr>
    @endif
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
    <tr  style='font-size:12px'>
        <td class='tds' style='font-size:12px' ><small>@if($status->academic_type!='Senior High School'){{$grade->course_code}}@endif {{$grade->course_name}}</small></td>
        
        @if ($status->academic_type!='Senior High School')
        <td class='tds' style='font-size:12px'>
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
        <td class='tds' style='font-size:12px'>
            <?php
            $offering_id = \App\CourseOffering::find($grade->course_offering_id);
            $instructor = \App\User::where('id', $offering_id->instructor_id)->first();
            ?>
            @if (count($instructor)>0)
            {{$instructor->firstname}} {{$instructor->lastname}}
            @endif
        </td>
        @else
        <td class='tds' style='font-size:12px'>
            
        </td>
        <td class='tds' style='font-size:12px'>
            
        </td>

        @endif
        
        <td class='tds' align='center'>@if($status->academic_type!='Senior High School')<?php $total = $total + $grade->lec; ?>{{$grade->lec}} @else <?php $total = $total + $grade->hours; ?>{{$grade->hours}} @endif</td>
    </tr>
    @endforeach
    <tr>
        <th class='tds' colspan="3">Total Units/Hrs</th>
        <th class='ths'align='center'>{{$total}}</th>
    </tr>
</table>
<br><b>ASSESSMENT</b>
    <?php
    $tfee = 0;
    $ofee = 0;
    $dfee = 0;
    $esc = 0;
    $tfs = \App\ledger::where('idno', $status->idno)->where('school_year', $y->school_year)->where('period', $y->period)->where('category_switch', 3)->get();
    foreach($tfs as $tf){
        $tfee = $tfee + $tf->amount;
    }
    $ofs = \App\ledger::where('idno', $status->idno)->where('school_year', $y->school_year)->where('period', $y->period)->where('category_switch', 1)->get();
    foreach($ofs as $of){
        $ofee = $ofee + $of->amount;
    }
    $discounts = \App\ledger::where('idno', $status->idno)->where('school_year', $y->school_year)->where('period', $y->period)->get();
    foreach($discounts as $discount){
        $dfee = $dfee + ($discount->discount);
        $esc = $esc + $discount->esc;
    }

    ?>
<table width = "60%">
    <tr>
        <td>Tuition Fee</td>
        <td>:</td>
        <td style="border-bottom: 1pt solid black;">Php {{number_format($tfee,2)}}</td>
    </tr>
    <tr>
        <td>Other Fee</td>
        <td>:</td>
        <td style="border-bottom: 1pt solid black;">Php {{number_format($ofee,2)}}</td>
    </tr>
    <tr>
        <td>Discounts</td>
        <td>:</td>
        <td style="border-bottom: 1pt solid black;">(Php {{number_format($dfee,2)}})</td>
    </tr>
    @if($status->academic_type=="Senior High School")
    <tr>
        <td>Voucher</td>
        <td>:</td>
        <td style="border-bottom: 1pt solid black;">(Php {{number_format($esc,2)}})</td>
    </tr>
    @endif
    <tr>
        <td>Total Tuition Fee</td>
        <td>:</td>
        <td style="border-bottom: 1pt solid black;">Php {{number_format((($tfee+$ofee)-$dfee)-$esc,2)}}</td>
    </tr>
    @if (count($ledger_due_dates)>0)
    <tr>
        <td><strong>Downpayment</strong></td>
        <td><strong>:</strong></td>
        <td style="border-bottom: 1pt solid black;"><strong>Php {{number_format($downpayment->amount,2)}}</strong></td>
    </tr>
    @endif
</table>

    @if (count($ledger_due_dates)>0)
<table class='tables' width='100%'>
    <tr>
        <th class='ths'>Due Date</th>
        <th class='ths'>Amount</th>
        <td width="50%" rowspan="{{count($ledger_due_dates)+1}}">
            <i><small><center>*For installment basis, please pay the appropriate amounts on or before the stated due dates to avoid late payment charges. Thank you!</center></small></i>
        </td>
    </tr>
    @foreach ($ledger_due_dates as $ledger_due_date)
    <tr>
        <td class='tds'>{{ date ('D, M d, Y', strtotime($ledger_due_date->due_date))}}</td>
        <td class='tds'>Php {{number_format($ledger_due_date->amount,2)}}</td>
    </tr>
    @endforeach
</table>
@else
<table class="tables" width="100%">
    <tr>
        <th class="ths">Date</th>
        <th class="ths">Description</th>
        <th class="ths">Amount</th>
    </tr>
    <tr>
        <td class='tds'>{{ date ('D, M d, Y', strtotime($downpayment->due_date))}}</td>
        <td class="tds">Full Payment</td>
        <td class='tds'>Php {{number_format($downpayment->amount,2)}}</td>
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
    ____________________________<br><strong>Anna Liza M. Sabalvaro</strong><br><small>School Registrar</small>
</center>
</td>
</tr>
</table>
<small><i>NOTE: This form is not valid until payment has been made in the cashier.
        <br>Validity period: 10 days from the date of assessment.</i></small>

<div class="page_break">
    <div style="text-align: justify">
        <div align="center"><strong>STUDENT'S PLEDGE AND DECLARATION</strong></div>
        <ol>
            <li>In consideration of my admission to the DMMC Institute of Health Sciences, I hereby promise and pledge to abide by and comply with all the rules and regulations laid down by competent authority in the School in which I am enrolled.</li>
            <li>I am fully aware of the School policy to expel, exclude or suspend indefinitely, after summary investigation, any student found to have committed major offenses as specified in the DMMC Institute of Health Sciences Student Handbook as well as those issued from time to time by the competent authority in this School.</li>
            <li>I am fully aware that the assessment of fees stated in this registration form are still subject to audit and will be adjusted accordingly.</li>
            <li>I am fully aware that in order to avail cash basis of my tuition fees, total amount for the year must be already paid in advance. (Due date stipulatedin the front page)</li>
            <li>I am fully aware that my enrollment is on a semestral basis only. And when this enrollment application is withdrawn before the start of classess, a 5% of the total amount due for the school terms is to be charged. Moreover, for a student who withdrawns or transfers after enrollment period the following refund and charges shall apply:</li>
        </ol>

        <div align='center'><i>For Higher Education Programs</i></div>
        <ol type='A'>
            <li>10% of the total amount due for the school term shall not be refundable if the student officially drops within the first week of classes whether or not he has actually attended classes.</li>
            <li>20% of the total amount due for the school term shall not be refundable if the student officially drops within the second week of classes whether or not he has actually attended classes.</li>
        </ol>
        <div align='center'>****************************************************</div>
    </div>
</div>
