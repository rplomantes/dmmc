@extends('layouts.cashierapp')
@section('content')
<div class="container-fluid">
<div class="col-md-12">
    <h3>Collection Report</h3>
    <?php $totalCollection=0;
        $totalReversal=0;?>
    @if(count($payments)>0)
    <table class="table table-responsive" border="1">
        <tr><td>Receipt No</td><td>Student ID</td><td>Name</td><td>Particular</td><td>Amount</td><td>Status</td><td>View</td></tr>
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
        <tr><td>{{$payment->receipt_no}}</td><td>{{$payment->idno}}</td><td>{{$payment->paid_by}}</td><td>{{$payment->remarks}}</td><td align="right">{{number_format($payment->cash_amount+$payment->check_amount-$payment->change_amount,2)}}</td><td>{{$status}}</td><td><a href="{{url('viewreceipt',$payment->reference_id)}}">View</a></td></tr>
        @endforeach
        <tr><td colspan="4">Total</td><td align="right"><b>{{number_format($totalCollection,2)}}</b></td><td></td><td></td></tr>
        <tr><td>Total Collection</td><td align="right">{{number_format($totalCollection,2)}}</td><td colspan="5" rowspan="2"></td></tr>
        <tr><td>Total Cancelled</td><td align="right">{{number_format($totalReversal,2)}}</td></tr>
        </table>
        <a href="{{url('printcollection',$trandate)}}" class="btn btn-primary form-control">Print Colletion Report</a>
        @else
    <h3>No Collection on This Date.</h3>
    @endif
</div> 
</div>    
@stop

