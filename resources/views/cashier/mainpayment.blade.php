<?php
$student=  \App\User::where('idno',$idno)->first();
$receiptno = \App\CtrReferenceId::where('idno',Auth::user()->idno)->first();

$status =  \App\Status::where('idno',$idno)->first();

///Main Account
$ledgers = DB::Select("Select idno, category, sum(amount) as amount, sum(discount) as discount, sum(payment) as payment, sum(debit_memo) as debit_memo, sum(esc) as esc  "
        . " from ledgers where idno='$idno' and category_switch <= '3' group by idno,category");
$ledgertotal=0;
if(count($ledgers)>0){
    foreach($ledgers as $ledger){
        $ledgertotal = $ledgertotal + $ledger->amount - $ledger->discount -$ledger->debit_memo - $ledger->payment - $ledger->esc;
    }
}
///End of Main Account

//previous account
$ledgerprevious = DB::Select("Select idno, category, school_year, period, sum(amount) as amount, sum(discount) as discount, sum(payment) as payment, sum(debit_memo) as debit_memo, sum(esc) as esc  "
        . " from ledgers where idno='$idno' and category_switch >= '10'  and "
        . "amount-discount-debit_memo-esc-payment >0 group by idno,category,school_year,period");

$totalprevious = 0;
if(count($ledgerprevious)>0){
    foreach($ledgerprevious as $previous){
        $totalprevious = $totalprevious + $previous->amount - $previous->debit_memo-$previous->payment-$previous->discount-$previous->esc;
    }
}
//end of previous account
$otheracct= DB::Select("Select id, idno, description,receipt_details, amount, discount, debit_memo, payment from ledgers "
        . "where (amount-discount-debit_memo-payment > 0) AND idno = '$idno' AND category_switch = '5'");
$duedates = \App\LedgerDueDate::where('idno',$idno)->where('school_year',$status->school_year)->where('period',$status->period)->orderBy('due_switch')->orderBy('due_date')->get();
$totalpayments = DB::Select("select payment, debit_memo  from ledgers where idno = '$idno' AND category_switch <= '3'");
$totalpayment = 0;
if(count($totalpayments)>0){
    foreach($totalpayments as $tp){
        $totalpayment = $totalpayment + $tp->payment + $tp->debit_memo;
    }
}
$payments = \App\Payment::where('idno',$idno)->where('is_new','1')->orderBy('transaction_date')->get();
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
    input{text-align:right}
    #duedisplay{color:purple;font-size: 30pt;font-weight: bold}
    #receivepayment{visibility: hidden}
    .paymenttitle{font-size:12pt; font-weight: bold}
    input#submit{visibility:hidden}
    #total_collected{font-size: 12pt; font-weight: bold;color: red}
</style>
<div class="container-fluid">
    <div class="col-md-12">
        <a class="btn btn-primary" href="{{url('viewledger',$idno)}}">Back</a>
        <a class="btn btn-primary" href="{{url('mainpayment',$idno)}}">Refresh</a>
        <a class="btn btn-primary" href="{{url('/')}}">Home</a>
    </div>    
    <hr />
    <div class="col-md-12">
        <div class="col-md-6">{{date("M d, Y")}}<br>{{$student->idno}}<br><b>{{$student->lastname}}, {{$student->firstname}}</b></div>
        <div class="col-md-6"><div class="nav navbar pull-right"> Receipt No: <span style="font-size:20pt;font-weight:bold;color:red">{{$receiptno->receipt_no}}</span></div></div>
    </div>    
   <hr />  
   <div class="col-md-6">
       <form id="paymentform" class="form-horizontal" method="POST" action="{{url('mainpayment')}}">
           {!!csrf_field()!!}
           <input type="hidden" name="idno" value="{{$idno}}">
   <table border ='1' class="table table-striped">
       <tr align="center"><th>Particular</th><th>Max Amount</th><th>Amount To Be Collected</th>
        @if(count($ledgerprevious)>0)
        <tr><td>Previous Balance</td><td align="right">{{$totalprevious}}</td><td><input class="form form-control" type="text" name="previousaccount"  id="previousaccount" value="{{$totalprevious}}"></td></tr>
        @else
        <tr><td colspan="2"><input type="hidden" id="previousaccount" name="previousaccount" value="0"></td>
        @endif
        <?php $displaydue=0;if($dueamount-$mainpayment < 0 ){$displaydue="0.00";}else{$displaydue=$dueamount-$mainpayment;} ?>
        <tr><td>Main Account</td><td align="right">{{$ledgertotal}}</td><td><input class="form form-control" type="text" name="mainaccount"  id="mainaccount" value="{{round($displaydue,2)}}"></td></tr>
        
        
        @if(count($otheracct)>0)
        <tr><td>Other Payment : </td><td></td><td></td></tr>
        @foreach($otheracct as $other)
        <tr><td>{{$other->receipt_details}}</td><td align="right">{{$other->amount-$other->debit_memo-$other->payment-$other->discount}}</td><td><input onkeypress="otherFunction(event,this,{{$other->amount-$other->debit_memo-$other->payment-$other->discount}})" class="form form-control otheracct" type="text" id="otheracct"  name="otheracct[{{$other->id}}]" value='{{$other->amount-$other->debit_memo-$other->payment-$other->discount}}'></td></tr>
        @endforeach
       @endif
       <tr><td colspan="2"><b>Total Amount To Be Collected</b></td><td><input type="text" disabled="disabled" class="form form-control" value="0.00" name="total_collected" id="total_collected"></td></tr>
   </table>
    </div> 
   <div class="col-md-6">
    <table border="1" style="backround-color:#ddd" class="table table-striped" id="receivepayment"><tr><th>Payment Type</th><th>Cash Payment</th></tr>
        <tr><td><span>Cash Receive</span></td><td><input type="text" name="cashamount" id="cashamount" class="form form-control"></td></tr>
        <tr><td></td><td><b>Check Payment</b></td></tr>
        <tr><td>Bank</td><td><input type="text" name="bank" id="bank" class="form form-control"></td></tr>
        <tr><td>Check Number</td><td><input type="text" name="checkno" id="checkno" class="form form-control"></td></tr>
        <tr><td>Check Amount</td><td><input type="text" name="checkamount" id="checkamount" class="form form-control"></td></tr>
        <tr><td>Change</td><td><input type="text" name="change" id="change" class="form form-control" disabled="disabled"></td></tr>
        <tr><td>Remarks</td><td><input type="text" name="remarks" id="remarks" class="form form-control" disabled="disabled"></td></tr>
    </table>    
           <input type="submit" class="form form-control btn btn-primary" name="submit" id="submit" value="Process Payment">
    </form>       
   </div>    
  </div> 


<script>
$(document).ready(function(){
    $(".otheracct").keyup(function(){
                    if (this.value != this.value.replace(/[^0-9\.]/g, '')) {
                    this.value = this.value.replace(/[^0-9\.]/g, '');
                }}); 
            
   
    
   
    
    
    if($("#previousaccount").val() > 0){
        $("#previousaccount").focus();
        myevent("#previousaccount","#mainaccount",{{$totalprevious}})         
    } else {
        $('#mainaccount').focus();   
    }
    
    myevent("#mainaccount","mainaccount",{{$ledgertotal}});
    //casamount event
    $("#cashamount").keypress(function(e){
        var ev = e.keyCode || event.which
        switch(ev){
            case 27:
                $("#cashamount").val("");
                $("cashamount").focus();
                break;
            case 13:
                if($("#cashamount").val()==""){
                   $("#cashamount").val("0.00");
                   $("#bank").focus();
                }
                if(parseFloat($("#cashamount").val()) >= parseFloat($("#total_collected").val())){
                    $total = parseFloat($("#cashamount").val()) - parseFloat($("#total_collected").val())
                    $("#change").val($total.toFixed(2));
                    $("#bank").val("");
                    $("#checkno").val("");
                    $("#checkamount").val("");
                    $("#remarks").removeAttr('disabled');
                    $("#remarks").focus();
                } else {
                    $("#bank").focus();
                }
                e.preventDefault();
                return false;
                break;
        }
    });
    $("#cashamount").keyup(function(){
        if (this.value != this.value.replace(/[^0-9\.]/g, '')) {
            this.value = this.value.replace(/[^0-9\.]/g, '');
        }
    });
    
   $("#bank").keypress(function(e){
       var ev = e.keyCode || event.which
       if(ev==13){
           $("#checkno").focus();
           e.preventDefault();
           return false;
       }
   })
   
   $("#checkno").keypress(function(e){
       var ev = e.keyCode || event.which
       if(ev==13){
           $("#checkamount").focus();
           e.preventDefault();
           return false;
       }
   })
   
   $("#checkamount").keyup(function(){
        if (this.value != this.value.replace(/[^0-9\.]/g, '')) {
            this.value = this.value.replace(/[^0-9\.]/g, '');
        }
   });
   
   $("#checkamount").keypress(function(e){
       //alert("hello")
       checkFunction(e.keyCode);
       if(e.keyCode==13){
       e.preventDefault();
       return false;
      }
      
   });
   $("#remarks").keypress(function(e){
       var ev = e.keyCode || event.which
       if(ev==13){
           if($("#checkamount").val()==""){
               $("#checkamount").val("0.00");
           }
           if($("#cashamount").val()==""){
               $("#cashamount").val("0.00");
           }
           
           $("#submit").css('visibility','visible');
           $("#submit").focus();
           e.preventDefault();
           return false;
       }
   })
});

function checkFunction(evt){
    if(evt==13){
        
        
        if(parseFloat($("#checkamount").val()) > parseFloat($("#total_collected").val())){
            alert("Invalid Amount. The Amount in Check Should Not Be Greater Than " + $("#total_collected").val()) 
            $("#checkamunt").val("");
        }else{
            if(parseFloat($("#checkamount").val())+parseFloat($("#cashamount").val()) > parseFloat($("#total_collected").val())){
              totalchange=  parseFloat($("#checkamount").val())+parseFloat($("#cashamount").val()) - parseFloat($("#total_collected").val());
              $("#change").val(totalchange.toFixed(2))
            }
            if($("#bank").val()==""){
                alert("Please Fill Up Check Details");
                $("#bank").focus();
            }else if($("#checkno").val()==""){
                alert("Please Fill Up Check Number");
                $("#checkno").focus();
            } 
            else if(parseFloat($("#checkamount").val())+parseFloat($("#cashamount").val())< parseFloat($("#total_collected").val())){
                alert("Amount Receive Should Be Equal or Greater Than The Amount Collected");
                $("#checkamount").focus();
            }
                else{
                $("#remarks").removeAttr('disabled');
                $("#remarks").focus();
            }
        }
       
    }
}

function myevent(varobject, varnextobject,total){
    var object = $(varobject);
    var nextobject = $(varnextobject);
    object.keypress(function(e){
                    var ev = e.keyCode || event.which;
                switch(ev){
                  
                        case 27:
                        object.val("");
                        object.focus();
                        $("#receivepayment").css('visibility','hidden');
                        break;
                        
                        case 13: 
                        //totalprevious = {{$totalprevious}};
                        if(object.val() > total){
                            alert("The Value Should Not Be Greater Than " + total);
                            object.val(total);
                            object.focus();
                        } else{
                            if(object.val()==""){
                            object.val("0.00");
                            }
                            
                            if(nextobject){
                            nextobject.focus();
                            } else{
                                processcompute();
                            }
                            
                            if(varnextobject=="mainaccount"){
                                processcompute();   
                            }
                           }
                           e.preventDefault();
                           return false;
                           break;
                        default:
                        $("#receivepayment").css('visibility','hidden');
                    }
                })
                object.keyup(function(){
                    if (this.value != this.value.replace(/[^0-9\.]/g, '')) {
                    this.value = this.value.replace(/[^0-9\.]/g, '');
                } 
                 })
                 
    
}

function processcompute(){
    var totalother=0;
    if($("input#otheracct")){
    $('input#otheracct').each(function(){
       totalother = parseFloat(totalother) + parseFloat(this.value); 
    });
    }
    if($("input#mainaccount")) {
    totalother = parseFloat(totalother) + parseFloat($("input#mainaccount").val());
    }
    
    if($("#previousaccount")){
     totalother = parseFloat(totalother) + parseFloat($("input#previousaccount").val());
    }
     
    $("#total_collected").val(totalother.toFixed(2));
    $("#receivepayment").css('visibility','visible');
    $("#cashamount").focus();
}

function otherFunction(e,object,maxamount){
    var event = e.keyCode || event.which;
    if(event==27){
       object.value="";
       $("#receivepayment").css('visibility','hidden');
    }
    else if(event==13){
        if(object.value > maxamount){
        alert("The Maximum Amount For This Account Is " + maxamount);
        object.value=maxamount;
        processcompute();
        }else if(object.value==""){
        object.value="0.00";
        processcompute();
        }else
        {    
        processcompute();
    }
    e.preventDefault();
    return false;
    }else{
        $("#receivepayment").css('visibility','hidden');
    }
}
</script>




@stop