
        <style>
            .header_image 
            {
                position: absolute;
                bottom: 890px;
                right: 0;
                left: -350;
                z-index: -1;
            }
        </style>
<div align="center">
    <div class='header_image'><img src = "{{public_path("images/dmmclogo2.jpeg")}}" width="8%" alt="DMMCIHS Logo" class="img-thumbnail"></div>
    <b>DMMC INSTITUTE OF HEALTH SCIENCES</b><br>
    <small>#143 Narra St., Mountainview Subd., Tanauan City, Batangas</small><br><br><br>
    <b>DMMC IHS ADMISSION TEST PERMIT</b><br><br><br>
</div>

<table class="table" width="100%">
    <tr>
        <td>Reference No:</td>
        <td style="border-bottom: 1pt solid black;"><b>{{strtoupper($list->idno)}}</b></td>
    </tr>
    <tr>
        <td>Name:</td>
        <td style="border-bottom: 1pt solid black;">{{strtoupper($list->firstname)}} {{strtoupper($list->middlename)}} {{strtoupper($list->lastname)}} {{strtoupper($list->extensionname)}}</td>
    </tr>
    <tr>
        <td>Intended Course:</td>
        <td style="border-bottom: 1pt solid black;">{{$list->course}}</td>
    </tr>
    <tr>
        <td colspan='2'><b><br>Schedule of Examination:</b></td>
    </tr>
    <tr>
        <td>Date:</td>
        <td style="border-bottom: 1pt solid black;">{{ date ('M d, Y (D) - g:i A', strtotime($exam->datetime))}}</td>
    </tr>
    <tr>
        <td>Place:</td>
        <td style="border-bottom: 1pt solid black;">{{$exam->place}}</td>
    </tr>
    <br></table>
<br>
<table width="100%">
    <tr>
        <td>
            <b>Admission Test Requirements</b>
            <ol>
                <li>(1) 1 1/2 X 1 1/2 ID Picture</li>
                <li>Authenticated photocopy of HS Card</li>
                <li>Photocopy of Grades or Transcript of Records (for transferee)</li>
            </ol>
        </td>
        <td valign="bottom">
            <b>RISHA L. MERCADO, MA, RGC, LPT</b><br>Head, OSWD/Guidance Counselor
        </td>
    </tr>
</table>