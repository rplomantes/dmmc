<?php
$totalCollection = 0;
$totalReversal = 0;
?>
<html>
    <head>
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
        <div class='header_image'><img src = "{{url("/images","dmmclogo2.jpeg")}}" width="8%" alt="DMMCIHS Logo" class="img-thumbnail"></div>
        <b>DMMC INSTITUTE OF HEALTH SCIENCES</b><br>
        <small>#143 Narra St., Mountainview Subd., Tanauan City, Batangas</small><br><br>
        <b>Collection Report</b><br><br>
    </div>
</head>
<body>
    <table width="40%">
        <tr>
            <td width='50%'>Transaction Date:</td>
            <td style="border-bottom: 1pt solid black;" >{{Date('M d, Y',strtotime($transaction_date))}}</td>
        </tr>
        <tr>
            <td>Cashier:</td>
            <td style="border-bottom: 1pt solid black;" >{{Auth::user()->lastname}}, {{Auth::user()->firstname}} {{Auth::user()->extensionname}}</td>
        </tr>
    </table><br>

    <table cellspacing="0" cellpadding="1" border="1" width="100%">

        <tr>
            <td><b>Receipt No</b></td>
            <td><b>Student ID</b></td>
            <td><b>Name</b></td>
            <td><b>Particular</b></td>
            <td><b>Amount</b></td>
            <td><b>Status</b></td>
        </tr>
        @if(count($payments)>0)
        @foreach($payments as $payment)
        <?php
        $status = "Ok";
        if ($payment->isreverse == "1") {
            $status = "Cancelled";
            $totalReversal = $totalReversal + $payment->cash_amount + $payment->check_amount - $payment->change_amount;
        } else {
            $totalCollection = $totalCollection + $payment->cash_amount + $payment->check_amount - $payment->change_amount;
        }
        ?>
        <tr>
            <td>{{$payment->receipt_no}}</td>
            <td>@if($payment->idno!="999999"){{$payment->idno}}@endif</td>
            <td>{{$payment->paid_by}}</td>
            <td>{{$payment->remarks}}</td>
            <td align="right">{{number_format($payment->cash_amount+$payment->check_amount-$payment->change_amount,2)}}</td>
            <td>{{$status}}</td>
        </tr>
        @endforeach
        @else
        <tr>
            <td colspan="6"><div align='center'><i>No Collection has been made.</i></div></td>
        </tr>
        @endif
        <tr>
            <td colspan="2"><b>Total</b></td>
            <td colspan="3" align="right"><b>{{number_format($totalCollection,2)}}</b></td>
            <td></td>
        </tr>
        <tr>
            <td><b>Total Collection</b></td>
            <td align="right"><b>{{number_format($totalCollection,2)}}</b></td>
            <td colspan="4" rowspan="2"></td>
        </tr>
        <tr>
            <td><b>Total Cancelled</b></td>
            <td align="right"><b>{{number_format($totalReversal,2)}}</b></td>

        </tr>
    </table>
</body>
</html>