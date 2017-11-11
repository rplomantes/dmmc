@extends('layouts.cashierapp')
@section('content')
<div class="container-fluid">
<div class="col-md-12">
    <h3>List of Checks</h3>
    <?php $totalCollection=0;
        $totalReversal=0;?>
    @if(count($payments)>0)
    <table class="table table-responsive table-bordered">
        <tr><td>Receipt No</td><td>Student ID</td><td>Name</td><td>Bank</td><td>Check</td><td>Amount</td><td>Status</td><td>View</td></tr>
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
        <tr><td>{{$payment->receipt_no}}</td><td>@if($payment->idno!="999999"){{$payment->idno}}@endif</td><td>{{$payment->paid_by}}</td><td>{{$payment->bank_name}}</td><td>{{$payment->check_number}}</td><td align="right">{{number_format($payment->cash_amount+$payment->check_amount-$payment->change_amount,2)}}</td><td>{{$status}}</td><td><a href="{{url('viewreceipt',$payment->reference_id)}}">View</a></td></tr>
        @endforeach
        <tr><td colspan="5">Total</td><td align="right"><b>{{number_format($totalCollection,2)}}</b></td><td></td><td></td></tr>
        <tr><td>Total Collection</td><td align="right">{{number_format($totalCollection,2)}}</td><td colspan="6" rowspan="2"></td></tr>
        <tr><td>Total Canceled</td><td align="right">{{number_format($totalReversal,2)}}</td></tr>
        </table>
        <a href="{{url('printcheck',$trandate)}}" target="_blank" class="btn btn-primary form-control">Print Collection Report</a>
        @else
    <h3>No Collection on This Date.</h3>
    @endif
</div> 
</div>    
@stop

