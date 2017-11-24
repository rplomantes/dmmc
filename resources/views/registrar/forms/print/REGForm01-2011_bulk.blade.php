<!--<style>
    .header_image 
    {
        position: absolute;
        bottom: 890px;
        right: 0;
        left: -350;
        z-index: -1;
    }
</style>

<div align="center"><div class='header_image'><img src = "{{public_path("images/dmmclogo2.jpeg")}}" width="8%" alt="DMMCIHS Logo" class="img-thumbnail"></div></div>
<div align="center">
    <b>DMMC INSTITUTE OF HEALTH SCIENCES</b><br>
    <small>#143 Narra St., Mountainview Subd., Tanauan City, Batangas</small><br>
    <b>Office of the Registrar</b><br><br>
    <b>STUDENT CLEARANCE FORM</b><br>
</div>-->
<style>
    
    .page_break { 
        page-break-before: always;
    }
    
    table, th, td {
        border: 1px solid black;
        border-collapse: collapse;
        font: 9pt;
    }
    .logo{
        border-right: 1px solid transparent;
        border-left: 1px solid transparent;
        border-top: 1px solid transparent;
    }
    .brand{
        border-top: 1px solid transparent;
    }
    
    #br2{
        line-height: 3.5px;
    }
</style>
<?php 
$is_hr = 1;
?>
@foreach ($statuses as $status)
<?php
$user = \App\User::where('idno', $status->idno)->first();
$studentinfo = \App\StudentInfo::where('idno', $status->idno)->first();
?>
<table border="1" width="100%" cellspacing='0' cellpadding='0'>
    <tr>
        <td class='logo' width="10%" rowspan="4">
            <img src = "{{public_path("images/dmmclogo2.jpeg")}}" width="5000%" alt="DMMCIHS Logo" class="img-thumbnail">
        </td>
        <td class='brand' width="30%" rowspan="4" style="text-align: center; font-size: 11pt;">DMMC INSTITUTE<br>OF HEALTH SCIENCES<b><br><small>Office of the Registrar<br></small></b><small>REGForm01-2011</small></td>
        <td colspan="4"><b><div align="center">STUDENT CLEARANCE FORM</div></b></td>
    </tr>
    <tr>
        <td colspan="4" style="background-color: #ccc; text-align: center"><small>ACADEMIC INFORMATION</small></td>
    </tr>
    <tr>
        <td width="20%">ID Number:</td>
        <td colspan="3">{{$user->idno}}</td>
    </tr>
    <tr>
        <td>Course/Track:</td>
        <td colspan="3">@if($status->academic_type=="Senior High School"){{$status->track}} @else {{$status->program_name}} @endif</td>
    </tr>
    <tr>
        <td style="background-color: #ccc;">Date Received:</td>
        <td></td>
        <td style="background-color: #ccc; text-align: center" colspan="2"><small>GRADUATION</small></td>
        <td style="background-color: #ccc; text-align: center" colspan="2"><small>REASON FOR CLEARANCE</small></td>
    </tr>
    <tr>
        <td style="background-color: #ccc; text-align: center" colspan="2"><small>PERSONAL INFORMATION</small></td>
        <td rowspan="6" colspan="2" width="20%">
            <input type=checkbox> Yes, I graduated on<br>Date:_________________<br><br><input type=checkbox> No, I last attended DMMC IHS on <br>Term _________ S.Y. _______-_______
        </td>
        <td rowspan="6" colspan="2">
            ____ End of Term: 1st/2nd/Summer
            <br>____ Graduation
            <br>____ File for Transfer Credentials
            <br>____ Filing of LOA
            <br>____ Dropping
            <br>____ Others:_____________________
        </td>
    </tr>
    <tr>
        <td>Lastname:</td>
        <td>{{$user->lastname}}</td>
    </tr>
    <tr>
        <td>Firstname:</td>
        <td>{{$user->firstname}}</td>
    </tr>
    <tr>
        <td>Middlename:</td>
        <td>{{$user->middlename}}</td>
    </tr>
    <tr>
        <td colspan="2">Maidenname(if married):</td>
    </tr>
    <tr>
        <td>Gender:</td>
        <td>{{$studentinfo->gender}}</td>
    </tr>
    <tr>
        <td>Birthdate:</td>
        <td>{{$studentinfo->birthdate}}</td>
        <td style="background-color: #ccc; text-align: center" colspan="4"><small>SIGNATURE</small></td>
    </tr>
    <tr>
        <td>Citizenship:</td>
        <td>{{$studentinfo->Citizenship}}</td>
        <td colspan="4"></td>
    </tr>
    <tr>
        <td style="background-color: #ccc; text-align: center" colspan="6"><small>CONTACT INFORMATION</small></td>
    </tr>
    <tr>
        <td>Address:</td>
        <td>{{$studentinfo->street}}</td>
        <td>Contact No. (Home):</td>
        <td colspan="3">{{$studentinfo->contact_no}}</td>
    </tr>
    <tr>
        <td colspan="2">{{$studentinfo->barangay}} {{$studentinfo->municipality}}</td>
        <td>Cellphone No:</td>
        <td colspan="3"></td>
    </tr>
    <tr>
        <td colspan="2">{{$studentinfo->province}} {{$studentinfo->zip}}</td>
        <td>Email Address:</td>
        <td colspan="3">{{$user->email}}</td>
    </tr>
    <tr>
        <td style="background-color: #ccc; text-align: center" colspan="6"><small>CLEARANCE</small></td>
    </tr>
    <tr>
        <td colspan="6" style="font:8pt;">Please sign if the concerned student is free from responsibility or obligation with your department. Otherwise, specify the reason why we should hold his/her request.</td>
    </tr>
    <tr>
        <td><div align="center">Department</div></td>
        <td><div align="center">Accountability</div></td>
        <td colspan="2"><div align="center">Name</div></td>
        <td><div align="center">Signature</div></td>
        <td><div align="center">Date Signed</div></td>
    </tr>
    <tr>
        <td><div align="center" style="font: 9pt">@if($status->academic_type == "Senior High School") Dept. Head @else Dean @endif</div></td>
        <td></td>
        <td colspan="2"><div align="center"></div></td>
        <td></td>
        <td></td>
    </tr>
    <tr>
        <td><div align="center" style="font: 9pt">Laboratories</div></td>
        <td></td>
        <td colspan="2"></td>
        <td></td>
        <td></td>
    </tr>
    <tr>
        <td><div align="center" style="font: 9pt">Property Custodian</div></td>
        <td></td>
        <td colspan="2"></td>
        <td></td>
        <td></td>
    </tr>
    <tr>
        <td><div align="center" style="font: 9pt">Library</div></td>
        <td></td>
        <td colspan="2"></td>
        <td></td>
        <td></td>
    </tr>
    <tr>
        <td><div align="center" style="font: 9pt">Guidance Office</div></td>
        <td></td>
        <td colspan="2"></td>
        <td></td>
        <td></td>
    </tr>
    <tr>
        <td><div align="center" style="font: 9pt">Clinic</div></td>
        <td></td>
        <td colspan="2"></td>
        <td></td>
        <td></td>
    </tr>
    <tr>
        <td><div align="center" style="font: 9pt">Student Affairs</div></td>
        <td></td>
        <td colspan="2"></td>
        <td></td>
        <td></td>
    </tr>
    <tr>
        <td><div align="center" style="font: 9pt">Student Council</div></td>
        <td></td>
        <td colspan="2"></td>
        <td></td>
        <td></td>
    </tr>
    <tr>
        <td><div align="center" style="font: 9pt">Research Dept.</div></td>
        <td><i style="font: 6pt">(For student enrolled in Research Only)</i></td>
        <td colspan="2"></td>
        <td></td>
        <td></td>
    </tr>
    <tr>
        <td><div align="center" style="font: 9pt">Accounting</div></td>
        <td></td>
        <td colspan="2"></td>
        <td></td>
        <td></td>
    </tr>
    <tr>
        <td><div align="center" style="font: 9pt">Registrar Office</div></td>
        <td></td>
        <td colspan="2"></td>
        <td></td>
        <td></td>
    </tr>
</table>
<div align='center' style='font:8pt'>
    Remarks:________________________________________________________________________________________________________________________________<br><i><b>Note: Please submit fully accomplished clearance to the Registrar's Office.</b></i>
</div>
@if ($is_hr == 1)
<br><hr><br>
<?php $is_hr = 0; ?>
@else
<?php $is_hr = 1; ?>
<div class="page_break"></div>
@endif

@endforeach