<?php
$receipts = DB::Select("Select * from payments where receipt_no like '%$search%' or paid_by like '%$search%'");
?>

@if(count($receipts)>0)
<table class="table table-responsive">
    <tr><td>Transaction Date</td><td>Receipt No</td><td>Student ID</td><td>Paid By</td><td>Description</td><td>Amount</td><td>Remarks</td><td>View</td></tr>
    @foreach($receipts as $receipt)
    <tr><td>{{$receipt->transaction_date}}</td><td>{{$receipt->receipt_no}}</td>
        <td>@if($receipt->idno != "999999"){{$receipt->idno}}@endif</td><td>{{$receipt->paid_by}}</td>
        <td>{{$receipt->remarks}}</td><td align="right">{{number_format($receipt->cash_amount+$receipt->check_amount-$receipt->change_amount,2)}}</td>
        <td>@if($receipt->isreverse==0) OK @else Cancelled @endif</td><td> <a href="{{url('viewreceipt',$receipt->reference_id)}}">View</a></td></tr>
    @endforeach
</table>
@else
<h1>Record Not Found</h1>
@endif