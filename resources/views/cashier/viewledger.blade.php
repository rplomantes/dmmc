<?php
$receiptno = \App\CtrReferenceId::where('idno',Auth::user()->idno)->first();

$status =  \App\Status::where('idno',$idno)->first();
$ledgers = DB::Select("Select idno, category, sum(amount) as amount, sum(discount) as discount, sum(payment) as payment, sum(debit_memo) as debit_memo, sum(esc) as esc  "
        . " from ledgers where idno='$idno' and category_switch <= '3' group by idno,category");
$ledgerprevious = DB::Select("Select idno, category, school_year, period, sum(amount) as amount, sum(discount) as discount, sum(payment) as payment, sum(debit_memo) as debit_memo, sum(esc) as esc  "
        . " from ledgers where idno='$idno' and category_switch >= '10'  and "
        . "amount-discount-debit_memo-esc-payment >0 group by idno,category,school_year,period");
$previoustotal = 0;
$total=0; $subtotal=0;$amount=0;$discount=0;$payment=0;$debit_memo=0;$esc=0;
if(count($ledgerprevious)>0){
    foreach($ledgerprevious as $ledger){
        $amount=$amount+$ledger->amount;
        $discount=$discount+$ledger->discount;
        $payment=$payment+$ledger->payment;
        $debit_memo=$debit_memo+$ledger->debit_memo;
        $esc = $esc + $ledger->esc;
        $subtotal = $ledger->amount - $ledger->discount - $ledger->payment - $ledger->debit_memo - $ledger->esc;
        $previoustotal = $previoustotal + $subtotal;
    }
}
$otheracct= DB::Select("Select idno, description, amount, discount, debit_memo, payment from ledgers "
        . "where  idno = '$idno' AND category_switch = '5'");
$totalotheracct=0;
if(count($otheracct)>0){
    foreach($otheracct as $ledger){
        $amount=$amount+$ledger->amount;
        $discount=$discount+$ledger->discount;
        $payment=$payment+$ledger->payment;
        $debit_memo=$debit_memo+$ledger->debit_memo;
        //$esc = $esc + $ledger->esc;
        $subtotal = $ledger->amount - $ledger->discount - $ledger->payment - $ledger->debit_memo;
        $totalotheracct = $totalotheracct + $subtotal;
    }
}
$duedates = \App\LedgerDueDate::where('idno',$idno)->where('school_year',$status->school_year)->where('period',$status->period)->orderBy('due_switch')->orderBy('due_date')->get();
$totalpayments = DB::Select("select payment, debit_memo  from ledgers where idno = '$idno' AND category_switch <= '3'");
$totalpayment = 0;
if(count($totalpayments)>0){
    foreach($totalpayments as $tp){
        $totalpayment = $totalpayment + $tp->payment + $tp->debit_memo;
    }
}
$payments = \App\Payment::where('idno',$idno)->where('is_new','1')->orderBy('transaction_date')->get();
$mainpayment = 0;
$mainledgers = \App\ledger::where('idno',$idno)->where('category_switch','<=','3')->get();
$mainpayment = 0;
if(count($mainledgers)>0){
foreach($mainledgers as $payment){
   $mainpayment=$mainpayment+$payment->payment;
}}
$duedates = \App\LedgerDueDate::where('idno',$idno)->get();
$currentdue = \App\LedgerDueDate::where('idno',$idno)->where('due_date','<=', Carbon\Carbon::now())->get();
$dueamount = 0;

if(count($currentdue)>0){
    foreach($currentdue as $duedate){
        //if(date('Y-m-d',strtotime($duedate->duedate)) <= date('Y-m-d',strtotime(Carbon\Carbon::now()))){
            $dueamount = $dueamount + $duedate->amount;
        //}
    }
}

?>

@extends('layouts.cashierapp')
@section('content')
<style>
    #duedisplay{color:purple;font-size: 30pt;font-weight: bold}
</style>
<div class="container-fluid">
    
    <div class="col-md-12">
        <div class="col-md-6">Date Today : <b>{{date("M d, Y")}}</b></div>
        <div class="col-md-6"><div class="nav navbar pull-right"> Receipt No: <span style="font-size:20pt;font-weight:bold;color:red">{{$receiptno->receipt_no}}</span></div></div>
    </div>    
   <hr />  
    <div class="col-md-9">
        <div class="form-group">
            <a href="{{url('/')}}" class="btn btn-primary">Back</a>
            <a href="{{url('otherpayment',$idno)}}" class="btn btn-primary">Other Payment</a>
        </div>  
        <div class="form-group">
            <ul class="nav navbar-header">
                <li>Student Id : {{$student->idno}}</li>
                <li><b>Student Name : {{$student->lastname}}, {{$student->firstname}}</b></li> 
                    @if($status->status>2)
                        @if($status->academic_type=="Senior High School")
                            <li>Grade/Section : {{$status->level}} - {{$status->section}}<li>
                        @else
                            <li>Course/Level : {{$status->program_code}} - {{$status->level}}
                        @endif
                    @else 
                       <li>Status : <span style="color:red;font-weight: bold">Not Currently Assessed</span></li>
                    @endif
                    @if($status->status == 3)
                    <li>Status : <span style="color:red;font-weight: bold">Assessed</span></li>
                    @elseif($status->status == 4)
                    <li>Status : <span style="color:red;font-weight: bold">Enrolled</span></li>
                    @endif
            </ul>
        </div>        
    </div>
    <div class="col-md-3">
        
        <table class="table table-responsive">
            <tr>
                <td align="center">Amount Due Today<td>
            </tr>
        <tr>
            <td align="right"><div id="duedisplay">@if (($dueamount-$mainpayment + $previoustotal + $totalotheracct)<0) 0 @else{{number_format($dueamount-$mainpayment + $previoustotal + $totalotheracct,2)}}@endif</div></td>
        </tr>
        </table>
        <a href="{{url('mainpayment',$idno)}}" class="btn btn-danger form-control">Go To Payment</a>
        
    </div>
<div class="col-md-8">
    @if(count($ledgerprevious)>0)
    <h3>Previous Balance/s</h3>
    <table class="table table-responsive"><thead><tr><th>Description</th><th>Period</th><th>Amount</th><th>Discount</th><th>Debit Memo</th><th>ESC</th><th>Payment</th><th>Balance</th></tr></thead>
        <?php $total=0; $subtotal=0;$amount=0;$discount=0;$payment=0;$debit_memo=0;$esc=0;?>
        <tbody>
        @foreach($ledgerprevious as $ledger)
        <?php
        $amount=$amount+$ledger->amount;
        $discount=$discount+$ledger->discount;
        $payment=$payment+$ledger->payment;
        $debit_memo=$debit_memo+$ledger->debit_memo;
        $esc = $esc + $ledger->esc;
        $subtotal = $ledger->amount - $ledger->discount - $ledger->payment - $ledger->debit_memo - $ledger->esc;
        $total = $total + $subtotal;
        ?>
        <tr><td>{{$ledger->category}}</td><td>{{$ledger->school_year}} - {{$ledger->period}}</td><td align="right">{{number_format($ledger->amount,2)}}</td><td align="right">{{number_format($ledger->discount,2)}}</td>
            <td align="right">{{number_format($ledger->debit_memo,2)}}</td><td align="right">{{number_format($ledger->esc,2)}}</td><td align="right">{{number_format($ledger->payment,2)}}</td><td align="right">{{number_format($subtotal,2)}}</td></tr>    
        @endforeach
    <tr><td colspan="2">Balance</td><td align="right">{{number_format($amount,2)}}</td><td align="right">{{number_format($discount,2)}}</td><td align="right">{{number_format($debit_memo,2)}}</td><td align="right">{{number_format($esc,2)}}</td>
        <td align="right">{{number_format($payment,2)}}</td><td align="right">{{number_format($total,2)}}</td></tr></tbody></table>    
    @endif
    @if(count($ledgers)>0)
    <h3>Main Account</h3>
    <table class="table table-responsive"><thead><tr><th>Description</th><th>Amount</th><th>Discount</th><th>Debit Memo</th><th>ESC</th><th>Payment</th><th>Balance</th></tr></thead>
        <?php $total=0; $subtotal=0;$amount=0;$discount=0;$payment=0;$debit_memo=0;$esc=0;?>
        <tbody>
        @foreach($ledgers as $ledger)
        <?php
        $amount=$amount+$ledger->amount;
        $discount=$discount+$ledger->discount;
        $payment=$payment+$ledger->payment;
        $debit_memo=$debit_memo+$ledger->debit_memo;
        $esc = $esc + $ledger->esc;
        $subtotal = $ledger->amount - $ledger->discount - $ledger->payment - $ledger->debit_memo - $ledger->esc;
        $total = $total + $subtotal;
        ?>
        <tr><td>{{$ledger->category}}</td><td align="right">{{number_format($ledger->amount,2)}}</td><td align="right">{{number_format($ledger->discount,2)}}</td>
            <td align="right">{{number_format($ledger->debit_memo,2)}}</td><td align="right">{{number_format($ledger->esc,2)}}</td><td align="right">{{number_format($ledger->payment,2)}}</td><td align="right">{{number_format($subtotal,2)}}</td></tr>    
        @endforeach
    <tr><td>Balance</td><td align="right">{{number_format($amount,2)}}</td><td align="right">{{number_format($discount,2)}}</td><td align="right">{{number_format($debit_memo,2)}}</td><td align="right">{{number_format($esc,2)}}</td>
        <td align="right">{{number_format($payment,2)}}</td><td align="right">{{number_format($total,2)}}</td></tr></tbody></table>    
    @else
    @endif
    
    @if(count($otheracct)>0)
    <h3>Other Account</h3>
    <table class="table table-responsive"><thead><tr><th>Description</th><th>Amount</th><th>Discount</th><th>Debit Memo</th><th>Payment</th><th>Balance</th></tr></thead>
        <?php $total=0; $subtotal=0;$amount=0;$discount=0;$payment=0;$debit_memo=0;?>
        <tbody>
        @foreach($otheracct as $ledger)
        <?php
        $amount=$amount+$ledger->amount;
        $discount=$discount+$ledger->discount;
        $payment=$payment+$ledger->payment;
        $debit_memo=$debit_memo+$ledger->debit_memo;
        $subtotal = $ledger->amount - $ledger->discount - $ledger->payment - $ledger->debit_memo;
        $total = $total + $subtotal;
        ?>
        <tr><td>{{$ledger->description}}</td><td align="right">{{number_format($ledger->amount,2)}}</td><td align="right">{{number_format($ledger->discount,2)}}</td>
            <td align="right">{{number_format($ledger->debit_memo,2)}}</td><td align="right">{{number_format($ledger->payment,2)}}</td><td align="right">{{number_format($subtotal,2)}}</td></tr>    
        @endforeach
        <tr><td>Balance</td><td align="right">{{number_format($amount,2)}}</td><td align="right">{{number_format($discount,2)}}</td><td align="right">{{number_format($debit_memo,2)}}</td>
        <td align="right">{{number_format($payment,2)}}</td><td align="right">{{number_format($total,2)}}</td></tr></tbody></table>
        @else
        @endif
        
        @if(count($payments)>0)
        <h3>Payment History</h3>
        <table class="table table-responsive"><tr><th>Date</th><th>Particular</th><th>Receipt No</th><th>Amount</th><th>Status</th><th>View</th><tr> 
        @foreach($payments as $payment)
        <tr><td>{{$payment->transaction_date}}</td><td>{{$payment->remarks}}</td><td>{{$payment->receipt_no}}</td><td align="right">{{number_format($payment->cash_amount+$payment->check_amount-$payment->change_amount,2)}}</td>
        <td>@if($payment->isreverse == '1')
            Reversed
            @else
            OK
            @endif 
            </td><td><a href="{{url('/viewreceipt',$payment->reference_id)}}">View</a></td></tr>
        @endforeach 
        </table>
        @endif
</div>
    <div class="col-md-4">
        @if(count($duedates)>0)
        <?php $balancedue = 0;?>
        <h3>Schedule of Payments</h3>
        <table class="table table-responsive"><tr><td>Due Date</td><td>Amount</td><td>Balance</td></tr>
           
            @foreach($duedates as $duedate)
            @if($duedate->due_switch=="0")
            <tr><td>Down Payment</td><td align="right">{{number_format($duedate->amount,2)}}</td><td align="right"><?php if($mainpayment >= $duedate->amount){$mainpayment=$mainpayment-$duedate->amount; echo "0.00";}else{$balancedue = $balancedue+$duedate->amount -$mainpayment; echo number_format($balancedue,2); $mainpayment=0;}?></td></tr>
            @else
             <tr><td>{{$duedate->due_date}}</td><td align="right">{{number_format($duedate->amount,2)}}</td><td align="right"><?php if($mainpayment >= $duedate->amount){$mainpayment=$mainpayment-$duedate->amount; echo "0.00";}else{$balancedue =$balancedue+$duedate->amount -$mainpayment; echo number_format($balancedue,2); $mainpayment=0;}?></td></tr>
            @endif
            
            @endforeach
         </table>   
        @else
        @endif
    </div>    
</div>
@stop
