<?php
$payment = \App\Payment::where('reference_id',$reference_id)->first();
$accountingscredit = DB::Select("Select reference_id, receipt_type, receipt_details, sum(credit) as credit from accountings where reference_id = '$reference_id'"
        . " and receipt_type = 'OR' group by reference_id,receipt_details, receipt_type");
$discount = DB::Select("Select sum('debit') as debit from accountings where reference_id = '$reference_id' and category = 'Discount' and receipt_type='OR'");
$totaldiscount = 0;
$totaldiscountar=0;

if(count($discount)>0){
foreach($discount as $disc){
$totaldiscount = $totaldiscount + $disc->debit;
}
}
$accountingscreditar = DB::Select("Select reference_id, receipt_type, receipt_details, sum(credit) as credit from accountings where reference_id = '$reference_id'"
        . " and receipt_type = 'AR' group by reference_id,receipt_details, receipt_type");
$discountar = DB::Select("Select sum('debit') as debit from accountings where reference_id = '$reference_id' and category = 'Discount' and receipt_type='AR'");
if(count($discountar)>0){
foreach($discountar as $discar)    
$totaldiscountar = $totaldiscountar + $discar->debit;
}
$status = \App\Status::where('idno',$payment->idno)->first();
$totalwithor=0;
$totalwithar=0;
?>
@extends('layouts.cashierapp')
@section('content')
<div class="container-fluid">
<div class="col-md-12">
<h3>Payment Details</h3>    
<div class="col-md-6">
 
@if(count($accountingscredit)>0)
<h5>With Official Receipt</h5> 
<table border = "1" class="table table-responsive">
        <tr><td>Official Receipt No</td><td><b>{{$payment->receipt_no}}</b></td></tr>
        @if(count($status)>0) 
        @if($status->status >= 4)
        <tr><td>Date</td><td>{{$payment->transaction_date}}</td></tr>
        <tr><td>ID Number</td><td>{{$payment->idno}}</td></tr>
        <tr><td>Name</td><td>{{$payment->paid_by}}</td></tr>
        @else
         <tr><td>Date</td><td>{{$payment->transaction_date}}</td></tr>
        <tr><td>Receive From</td><td>{{$payment->paid_by}}</td></tr>
        @endif
        @else
         <tr><td>Date</td><td>{{$payment->transaction_date}}</td></tr>
        <tr><td>Receive From</td><td>{{$payment->paid_by}}</td></tr>
        @endif
        <tr><td colspan="2">Particular</td></tr>
        @foreach($accountingscredit as $credit)
            @if($credit->credit > 0)
            <?php $totalwithor = $totalwithor + $credit->credit;?>
            <tr><td>{{$credit->receipt_details}}</td><td align="right"><b>{{number_format($credit->credit,2)}}</b></td></tr>
            @endif
        @endforeach
        <tr><td>Less : Discount</td><td align="right"><b>{{number_format($totaldiscount,2)}}</b></td></tr>
        <?php $totalwithor = $totalwithor - $totaldiscount;?>
        <tr><td>Total</td><td align="right"><b>{{number_format($totalwithor-$totaldiscount,2)}}</b></tr>
        
</table>
@else
<h5>No Official Receipt Issued</h5>
@endif
</div>
<div class="col-md-6">
@if(count($accountingscreditar)>0)
<h5> With Acknowledgement Receipt</h5>    
<table border = "1" class="table table-responsive">
        <tr><td>Acknowledgement Receipt  No</td><td><b>{{$payment->acknowledgement_no}}</b></td></tr>
        @if(count($status)>0) 
        @if($status->status >= 4)
        <tr><td>Date</td><td>{{$payment->transaction_date}}</td></tr>
        <tr><td>ID Number</td><td>{{$payment->idno}}</td></tr>
        <tr><td>Name</td><td>{{$payment->paid_by}}</td></tr>
        @else
         <tr><td>Date</td><td>{{$payment->transaction_date}}</td></tr>
        <tr><td>Receive From</td><td>{{$payment->paid_by}}</td></tr>
        @endif
        @else
         <tr><td>Date</td><td>{{$payment->transaction_date}}</td></tr>
        <tr><td>Receive From</td><td>{{$payment->paid_by}}</td></tr>
        @endif
        <tr><td colspan="2">Particular</td></tr>
        @foreach($accountingscreditar as $credit)
            @if($credit->credit > 0)
            <?php $totalwithar = $totalwithar + $credit->credit;?>
            <tr><td>{{$credit->receipt_details}}</td><td align="right"><b>{{number_format($credit->credit,2)}}</b></td></tr>
            @endif
        @endforeach
        <tr><td>Less : Discount</td><td align="right"><b>{{number_format($totaldiscountar,2)}}</b></td></tr>
        <?php $totalwithar = $totalwithar - $totaldiscountar;?>
        <tr><td>Total</td><td align="right"><b>{{number_format($totalwithar-$totaldiscountar,2)}}</b></tr>
        
</table> 
@else
<h5>No Acknowledgement Receipt Issued</h5>
@endif
</div>
</div>
    <div class="col-md-12"> 
        <h5>Payment Details</h5>
    <table class="table table-responsive"> 
        <tr><td>Bank</td><td>{{$payment->bank_name}}</td></tr>
        <tr><td>Check No</td><td>{{$payment->check_number}}</td></tr>
        <tr><td>Check Amount</td><td align="right">{{number_format($payment->check_amount,2)}}</td></tr>
        <tr><td>Cash Amount</td><td align="right">{{number_format($payment->cash_amount-$payment->change_amount,2)}}
        <tr><td>Change</td><td align="right">{{number_format($payment->change_amount,2)}}
        <tr><td>Cash Receive</td><td align="right">{{number_format($payment->cash_amount,2)}}
        <tr><td>Explanation</td><td>{{$payment->remarks}}</td></tr>    
    </table>    
   
</div>
   

<div class="col-md-12">
 <div class="col-md-6">
      @if($payment->idno != "999999")
        <a href="{{url('/viewledger',$payment->idno)}}" class="btn btn-primary form-control"> Back To Ledger</a>
      @else
         <a href="{{url('/')}}" class="btn btn-primary form-control"> Home</a>
      @endif
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

