<style>
    td{
        border-collapse: collapse;
        border: 1px solid black;
    }
    .table, .td, .th {
        border-collapse: collapse;
        border: 1px solid black;
    }
    .tablec, .tdc{
        font-size: 13px;
        text-align: center;
        border-collapse: collapse;
        border: 1px solid black;
    }
    .tables, .tds{
        font-size: 13px;
        border-collapse: collapse;
        border: 1px solid black;
    }
    .pc{
        text-align: center;
        font-size: 8px;
        padding:-2mm;
        font-style: italic
    }
    .ps{
        font-size: 8px;
        padding:-2mm;
        font-style: italic
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
<style>
            .header_image 
            {
                position: absolute;
                bottom: 1090px;
                right: 0;
                left: -350;
                z-index: -1;
            }
</style>
<div align="center"><div class='header_image'><img src = "{{public_path("images/dmmclogo2.jpeg")}}" width="8%" alt="DMMCIHS Logo" class="img-thumbnail"></div></div>
<div align="center">
    <b>DMMC INSTITUTE OF HEALTH SCIENCES</b><br>
    <small>#143 Narra St., Mountainview Subd., Tanauan City, Batangas</small><br><br>
    <b>STUDENT INFORMATION SHEET</b>
</div>
<br>
<?php
$user = \App\User::where('idno', $idno)->first();
$student_info = \App\StudentInfo::where('idno', $idno)->first();
$status = \App\Status::where('idno', $idno)->first();
$getfather = \App\Family::where('idno', $idno)->where('family_role', "Father")->first();
$getmother = \App\Family::where('idno', $idno)->where('family_role', "Mother")->first();

$cyear = date('Y');//current year
$cmonth = date('m');//current date

$byear = date('Y', strtotime($student_info->birthdate));
$bmonth = date('m', strtotime($student_info->birthdate));

$yearDiff = $cyear-$byear;
if ($cmonth<$bmonth){
    $yearDiff = $yearDiff-1;
    $month = 12-$bmonth;
    $month = $month+$cmonth;
} else {
    $month= $cmonth-$bmonth;
}
$age = $yearDiff. '.' .$month;
?>
<table class="table" width="100%">
    <tr>
        <td class="td"><strong>PERSONAL INFORMATION</strong></td>
        <td class="td" width='35%'>Department: <small style="color: red; font-weight: bold">{{$status->academic_type}}</small></td>
    </tr>
</table>
<table class='tablec' width='100%'>
    <tr>
        <td class='tdc' width='25%'>@if($user->lastname==null)<br>@else{{$user->lastname}}@endif<p class="pc">LAST NAME</p></td>
        <td class='tdc' width='25%'>@if($user->firstname==null)<br>@else{{$user->firstname}}@endif<p class="pc">FIRST NAME</p></td>
        <td class='tdc' width='25%'>@if($user->middlename==null)<br>@else{{$user->middlename}}@endif<p class="pc">LAST NAME</p></td>
        <td class='tdc' width='25%'>@if($user->extenstionname==null)<br>@else{{$user->extensionname}}@endif<p class="pc">EXTENSION NAME</p></td>
    </tr>
    <tr>
        <?php $address = $student_info->street. " " .$student_info->barangay. " " .$student_info->municipality. " " .$student_info->province. " " .$student_info->zip; ?>
        <td style="border-collapse: collapse; border: 1px solid black; text-align: left;" colspan="2">&nbsp; @if ($address==null)<br> @else{{$address}}@endif<p class="ps">&nbsp;&nbsp;&nbsp;&nbsp; ADDRESS</p></td>
        <td class='tdc' width='25%'>@if ($student_info->contact_no==null)<br>@else{{$student_info->contact_no}}@endif<p class="pc">CONTACT NUMBER</p></td>
        <td class='tdc' width='25%'>@if ($student_info->lrn==null)<br>@else{{$student_info->lrn}}@endif<p class="pc">LRN</p></td>
    </tr>
    <tr>
        <td class='tdc' width='25%'>@if ($student_info->birthdate==null)<br>@else{{$student_info->birthdate}}@endif<p class="pc">BIRTHDATE</p></td>
        <td class='tdc' width='25%'>@if ($age==null)<br>@else{{$age}}@endif<p class="pc">AGE</p></td>
        <td class='tdc' width='25%'>@if ($student_info->place_of_birth==null)<br>@else{{$student_info->place_of_birth}}@endif<p class="pc">PLACE OF BIRTH</p></td>
        <td class='tdc' width='25%'>@if ($student_info->citizenship==null)<br>@else{{$student_info->citizenship}}@endif<p class="pc">CITIZENSHIP</p></td>
    </tr>
    <tr>
        <td class='tdc' width='25%'>@if ($student_info->civil_status==null)<br>@else{{$student_info->civil_status}}@endif<p class="pc">CIVIL STATUS</p></td>
        <td class='tdc' width='25%'>@if ($student_info->religion==null)<br>@else{{$student_info->religion}}@endif<p class="pc">RELIGION</p></td>
        <td class='tdc' width='25%'>@if ($student_info->gender==null)<br>@else{{$student_info->gender}}@endif<p class="pc">GENDER</p></td>
        <td class='tdc' width='25%'>@if ($user->email==null)<br>@else{{$user->email}}@endif<p class="pc">EMAIL</p></td>
    </tr>
</table>

<table class="table" width="100%">
    <tr>
        <td class="td"><strong>FAMILY BACKGROUND</strong></td>
    </tr>
</table>
<table class='tables' width='100%'>
    <tr>
        <td class='tdc' width='50%'>@if(count($getfather)<0)  @else @if ($getfather->name==null)<br>@else{{$getfather->name}}@endif @endif<p class="pc">FATHER</p></td>
        <td class='tdc' width='50%'>@if(count($getmother)<0)  @else @if ($getmother->name==null)<br>@else{{$getmother->name}}@endif @endif<p class="pc">MOTHER</p></td>
    </tr>
    <tr>
        <td class='tdc' width='50%'>@if(count($getfather)<0)  @else @if ($getfather->birthdate==null)<br>@else{{$getfather->birthdate}}@endif @endif<p class="pc">BIRTHDATE</p></td>
        <td class='tdc' width='50%'>@if(count($getmother)<0)  @else @if ($getmother->birthdate==null)<br>@else{{$getmother->birthdate}}@endif @endif<p class="pc">BIRTHDATE</p></td>
    </tr>
    <tr>
        <td class='tdc' width='50%'>@if(count($getfather)<0)  @else @if ($getfather->occupation==null)<br>@else{{$getfather->occupation}}@endif @endif<p class="pc">OCCUPATION/EMPLOYER</p></td>
        <td class='tdc' width='50%'>@if(count($getmother)<0)  @else @if ($getmother->occupation==null)<br>@else{{$getmother->occupation}}@endif @endif<p class="pc">OCCUPATION/EMPLOYER</p></td>
    </tr>
    <tr>
        <td class='tdc' width='50%'>@if(count($getfather)<0)  @else @if ($getfather->income==null)<br>@else{{$getfather->income}}@endif @endif<p class="pc">MONTHLY INCOME</p></td>
        <td class='tdc' width='50%'>@if(count($getmother)<0)  @else @if ($getmother->income==null)<br>@else{{$getmother->income}}@endif @endif<p class="pc">MONTHLY INCOME</p></td>
    </tr>
</table>

<table class="table" width="100%">
    <tr>
        <td class="td"><strong>EDUCATIONAL BACKGROUND</strong></td>
    </tr>
</table>
<table class='tables' width='100%'>
    <tr>
        <td class='tdc' width='25%'>@if ($student_info->pri_school==null)<br>@else{{$student_info->pri_school}}@endif<p class="pc">PRIMARY</p></td>
        <td class='tdc' width='25%'>@if ($student_info->pri_address==null)<br>@else{{$student_info->pri_address}}@endif<p class="pc">SCHOOL ADDRESS</p></td>
        <td class='tdc' width='12.5%'>@if ($student_info->pri_from==null)<br>@else{{$student_info->pri_from}}@endif<p class="pc">FROM</p></td>
        <td class='tdc' width='12.5%'>@if ($student_info->pri_to==null)<br>@else{{$student_info->pri_to}}@endif<p class="pc">TO</p></td>
        <td class='tdc' width='25%'>@if ($student_info->pri_degree==null)<br>@else{{$student_info->pri_degree}}@endif<p class="pc">DEGREE/MAJOR</p></td>
    </tr>
    <tr>
        <td class='tdc' width='25%'>@if ($student_info->sec_school==null)<br>@else{{$student_info->sec_school}}@endif<p class="pc">SECONDARY</p></td>
        <td class='tdc' width='25%'>@if ($student_info->sec_address==null)<br>@else{{$student_info->sec_address}}@endif<p class="pc">SCHOOL ADDRESS</p></td>
        <td class='tdc' width='12.5%'>@if ($student_info->sec_from==null)<br>@else{{$student_info->sec_from}}@endif<p class="pc">FROM</p></td>
        <td class='tdc' width='12.5%'>@if ($student_info->sec_to==null)<br>@else{{$student_info->sec_to}}@endif<p class="pc">TO</p></td>
        <td class='tdc' width='25%'>@if ($student_info->sec_degree==null)<br>@else{{$student_info->sec_degree}}@endif<p class="pc">DEGREE/MAJOR</p></td>
    </tr>
    <tr>
        <td class='tdc' width='25%'>@if ($student_info->ter_school==null)<br>@else{{$student_info->ter_school}}@endif<p class="pc">TERTIARY</p></td>
        <td class='tdc' width='25%'>@if ($student_info->ter_address==null)<br>@else{{$student_info->ter_address}}@endif<p class="pc">SCHOOL ADDRESS</p></td>
        <td class='tdc' width='12.5%'>@if ($student_info->ter_from==null)<br>@else{{$student_info->ter_from}}@endif<p class="pc">FROM</p></td>
        <td class='tdc' width='12.5%'>@if ($student_info->ter_to==null)<br>@else{{$student_info->ter_to}}@endif<p class="pc">TO</p></td>
        <td class='tdc' width='25%'>@if ($student_info->ter_degree==null)<br>@else{{$student_info->ter_degree}}@endif<p class="pc">DEGREE/MAJOR</p></td>
    </tr>
    <tr>
        <td class='tdc' width='25%'>@if ($student_info->voc_school==null)<br>@else{{$student_info->voc_school}}@endif<p class="pc">VOCATIONAL</p></td>
        <td class='tdc' width='25%'>@if ($student_info->voc_address==null)<br>@else{{$student_info->voc_address}}@endif<p class="pc">SCHOOL ADDRESS</p></td>
        <td class='tdc' width='12.5%'>@if ($student_info->voc_from==null)<br>@else{{$student_info->voc_from}}@endif<p class="pc">FROM</p></td>
        <td class='tdc' width='12.5%'>@if ($student_info->voc_to==null)<br>@else{{$student_info->voc_to}}@endif<p class="pc">TO</p></td>
        <td class='tdc' width='25%'>@if ($student_info->voc_degree==null)<br>@else{{$student_info->voc_degree}}@endif<p class="pc">DEGREE/MAJOR</p></td>
    </tr>
    <tr>
        <td class='tdc' width='25%'>@if ($student_info->oth_school==null)<br>@else{{$student_info->oth_school}}@endif<p class="pc">OTHERS</p></td>
        <td class='tdc' width='25%'>@if ($student_info->oth_address==null)<br>@else{{$student_info->oth_address}}@endif<p class="pc">SCHOOL ADDRESS</p></td>
        <td class='tdc' width='12.5%'>@if ($student_info->oth_from==null)<br>@else{{$student_info->oth_from}}@endif<p class="pc">FROM</p></td>
        <td class='tdc' width='12.5%'>@if ($student_info->oth_to==null)<br>@else{{$student_info->oth_to}}@endif<p class="pc">TO</p></td>
        <td class='tdc' width='25%'>@if ($student_info->oth_degree==null)<br>@else{{$student_info->oth_degree}}@endif<p class="pc">DEGREE/MAJOR</p></td>
    </tr>
</table>
<small>ACADEMIC HONORS/AWARDS RECEIVED, IF ANY (Valedictorian, Salutatorian, Honorable Mention, Trophies etc...)</small>
<table class="tables" width="100%">
    <tr>
        <td class='tdc' width='50%'>@if ($student_info->pri_awards==null)<br>@else{{$student_info->pri_awards}}@endif<p class="pc">PRIMARY</p></td>
        <td class='tdc' width='50%'>@if ($student_info->pri_awards_year==null)<br>@else{{$student_info->pri_awards_year}}@endif<p class="pc">SCHOOL/YEAR</p></td>
    </tr>
    <tr>
        <td class='tdc' width='50%'>@if ($student_info->sec_awards==null)<br>@else{{$student_info->sec_awards}}@endif<p class="pc">SECONDARY</p></td>
        <td class='tdc' width='50%'>@if ($student_info->sec_awards_year==null)<br>@else{{$student_info->sec_awards_year}}@endif<p class="pc">SCHOOL/YEAR</p></td>
    </tr>
    <tr>
        <td class='tdc' width='50%'>@if ($student_info->ter_awards==null)<br>@else{{$student_info->ter_awards}}@endif<p class="pc">TERTIARY</p></td>
        <td class='tdc' width='50%'>@if ($student_info->ter_awards_year==null)<br>@else{{$student_info->ter_awards_year}}@endif<p class="pc">SCHOOL/YEAR</p></td>
    </tr>
</table>
<small>POSITION/LEADERSHIP HELD IN SCHOOLS ATTENDED</small>
<table class="tables" width="100%">
    <tr>
        <td class='tdc' width='50%'>@if ($student_info->pri_lead==null)<br>@else{{$student_info->pri_lead}}@endif<p class="pc">PRIMARY</p></td>
        <td class='tdc' width='50%'>@if ($student_info->pri_lead_year==null)<br>@else{{$student_info->pri_lead_year}}@endif<p class="pc">SCHOOL/YEAR</p></td>
    </tr>
    <tr>
        <td class='tdc' width='50%'>@if ($student_info->sec_lead==null)<br>@else{{$student_info->sec_lead}}@endif<p class="pc">SECONDARY</p></td>
        <td class='tdc' width='50%'>@if ($student_info->sec_lead_year==null)<br>@else{{$student_info->sec_lead_year}}@endif<p class="pc">SCHOOL/YEAR</p></td>
    </tr>
    <tr>
        <td class='tdc' width='50%'>@if ($student_info->ter_lead==null)<br>@else{{$student_info->ter_lead}}@endif<p class="pc">TERTIARY</p></td>
        <td class='tdc' width='50%'>@if ($student_info->ter_lead_year==null)<br>@else{{$student_info->ter_lead_year}}@endif<p class="pc">SCHOOL/YEAR</p></td>
    </tr>
</table>

<table class="table" width="100%">
    <tr>
        <td class="td"><strong>OTHER INFORMATION</strong></td>
    </tr>
</table>
<table class="tables" width="100%">
    <tr>
        <td class='tdc' width='33.33%'>@if ($student_info->hobbies==null)<br>@else{{$student_info->hobbies}}@endif<p class="pc">HOBBIES</p></td>
        <td class='tdc' width='33.33%'>@if ($student_info->sports==null)<br>@else{{$student_info->sports}}@endif<p class="pc">SPORTS</p></td>
        <td class='tdc' width='33.33%'>@if ($student_info->talents==null)<br>@else{{$student_info->talents}}@endif<p class="pc">TALENTS</p></td>
    </tr>
</table>
<small>Courses Applied</small>
<table class="tables" width="100%">
    <tr>
        <td class='tdc' width='50%'>@if ($student_info->course1==null)<br>@else{{$student_info->course1}}@endif<p class="pc">FIRST CHOICE</p></td>
        <td class='tdc' width='50%'>@if ($student_info->course2==null)<br>@else{{$student_info->course2}}@endif<p class="pc">SECOND CHOICE</p></td>
    </tr>
</table>
<small>In Case of Emergency</small>
<table class="tables" width="100%">
    <tr>
        <td class='tdc' width='50%'>@if ($student_info->emergency_contact_person==null)<br>@else{{$student_info->emergency_contact_person}}@endif<p class="pc">CONTACT PERSON</p></td>
        <td class='tdc' width='50%'>@if ($student_info->emergency_relationship==null)<br>@else{{$student_info->emergency_relationship}}@endif<p class="pc">RELATIONSHIP</p></td>
    </tr>
    <tr>
        <td class='tdc' width='50%'>@if ($student_info->emergency_address==null)<br>@else{{$student_info->emergency_address}}@endif<p class="pc">ADDRESS</p></td>
        <td class='tdc' width='50%'>@if ($student_info->emergency_contact_no==null)<br>@else{{$student_info->emergency_contact_no}}@endif<p class="pc">TEL./MOBILE NO.</p></td>
    </tr>
</table>