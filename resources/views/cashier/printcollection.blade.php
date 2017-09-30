<?php
$totalCollection=0;
$totalReversal=0;
?>
<html>
    <head>
        
    </head>
    <body>
        <table cellspacing="0" cellpadding="1" border="1" width="100%">
        <tr><td colspan="6">DMMC INSTITUTE OF HEALTH AND SCIENCE<br>
        Transaction Date : {{Date('M d, Y',strtotime($transaction_date))}} <br>
        Cashier : {{Auth::user()->lastname}}, {{Auth::user()->firstname}}    </td></tr>
        <tr><td>Receipt No</td><td>Student ID</td><td>Name</td><td>Particular</td><td>Amount</td><td>Status</td></tr>
        @foreach($payments as $payment)
        <?php
        $status = "Ok";
        if($payment->isreverse=="1"){
        $status = "Cancelled";
        $totalReversal = $totalReversal + $payment->cash_amount+$payment->check_amount-$payment->change_amount;
        }else{
         $totalCollection = $totalCollection + $payment->cash_amount+$payment->check_amount-$payment->change_amount;    
        }
        ?>
        <tr><td>{{$payment->receipt_no}}</td><td>@if($payment->idno!="999999"){{$payment->idno}}@endif</td><td>{{$payment->paid_by}}</td><td>{{$payment->remarks}}</td><td align="right">{{number_format($payment->cash_amount+$payment->check_amount-$payment->change_amount,2)}}</td><td>{{$status}}</td></tr>
        @endforeach
        <tr><td colspan="3">Total</td><td align="right"><b>{{number_format($totalCollection,2)}}</b></td><td></td><td></td></tr>
        <tr><td>Total Collection</td><td align="right">{{number_format($totalCollection,2)}}</td><td colspan="5" rowspan="2"></td></tr>
        <tr><td>Total Cancelled</td><td align="right">{{number_format($totalReversal,2)}}</td></tr>
        </table>
       
    </body>
</html>