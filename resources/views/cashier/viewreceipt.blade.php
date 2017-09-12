<?php
$payment = \App\Payment::where('reference_id',$reference_id)->first();
$accountingscredit = DB::Select("Select reference_id, receipt_details, sum(credit) as credit from accountings where reference_id = '$reference_id'"
        . " group by reference_id,receipt_details");
$status = \App\Status::where('idno',$payment->idno)->first();
?>
@extends('layouts.cashierapp')
@section('content')
<div class="container-fluid">
<div class="col-md-12">
<h3>Payment Details</h3>    
<div class="col-md-6">
<table border = "1" class="table table-responsive">
        <tr><td>Receipt No</td><td><b>{{$payment->receipt_no}}</b></td></tr>
        @if(count($status)>0 || $status->status >= 4)
        <tr><td>Date</td><td>{{$payment->transaction_date}}</td></tr>
        <tr><td>ID Number</td><td>{{$payment->idno}}</td></tr>
        <tr><td>Name</td><td>{{$payment->paid_by}}</td></tr>
        @else
         <tr><td>Date</td><td>{{$payment->transaction_date}}</td></tr>
        <tr><td>Date</td><td>{{$payment->paid_by}}</td></tr>
        @endif
        <tr><td colspan="2">Particular</td></tr>
        @foreach($accountingscredit as $credit)
            @if($credit->credit > 0)
            <tr><td>{{$credit->receipt_details}}</td><td align="right"><b>{{number_format($credit->credit,2)}}</b></td></tr>
            @endif
        @endforeach
        <tr><td>Less : Discount</td><td align="right"><b>0.00</b></td></tr>
        <tr><td>Total</td><td align="right"><b>{{number_format($payment->cash_amount+$payment->check_amount-$payment->change_amount,2)}}</b></tr>
        <tr><td>Explanation</td><td>{{$payment->remarks}}</td></tr>
</table>
</div>
    <div class="col-md-6">    
    <table class="table table-responsive"> 
        <tr><td>Bank</td><td>{{$payment->bank_name}}</td></tr>
        <tr><td>Check No</td><td>{{$payment->check_number}}</td></tr>
        <tr><td>Check Amount</td><td align="right">{{number_format($payment->check_amount,2)}}</td></tr>
        <tr><td>Cash Amount</td><td align="right">{{number_format($payment->cash_amount-$payment->change_amount,2)}}
        <tr><td>Change</td><td align="right">{{number_format($payment->change_amount,2)}}
        <tr><td>Cash Receive</td><td align="right">{{number_format($payment->cash_amount,2)}}
    
    </table>    
   
</div>
</div>    

<div class="col-md-12">
 <div class="col-md-6">
        <a href="{{url('/viewledger',$payment->idno)}}" class="btn btn-primary form-control"> Back To Ledger</a>
    </div>    
    <div class="col-md-6">
        @if($payment->transaction_date == date('Y-m-d'))
        @if($payment->isreverse==0)
        <?php $action ="reverse";?>
        <a href="{{url('/reverserestore',array($reference_id,$action))}}" class="btn btn-danger form-control" onclick="return confirm('Are You Sure To Reverse This Transaction?')">Reverse</a>
        @else
        <?php $action="restore";?>
         <a href="{{url('/reverserestore',array($reference_id,$action))}}" class="btn btn-primary form-control">Restore</a>
        @endif
        @endif
    </div>   
</div>
</div>    
@stop

