<?php
$receiptno = \App\CtrReferenceId::where('idno',Auth::user()->idno)->first()->receipt_no;
?>
@extends('layouts.cashierapp')
@section('content')
<div class="container-fluid">
    <div class="form-group">
        <p style="text-align:right; color: red; font-size: 12pt;font-weight: bold">Receipt No : {{$receiptno}}</p>
    </div>    
    <h3>CASHIER - PAYMENT FOR STUDENT</h3>
    <div class="form-group">
        <input type="text" class="form-control" placeholder="Search" id="search">
    </div>
    <div class="form-group">
        <div id="displaylist">
        </div>    
    </div>    
</div>    

<script>
    $(document).ready(function(){
        $("#search").keypress(function(e){
           var theEvent = e || window.event;
           var key = theEvent.keyCode || theEvent.which;
            if(key==13){
                var array = {}
                array['search']=$("#search").val();
                $.ajax({
                    type:"GET",
                    url:"/cashier/getstudentlist",
                    data:array,
                    success:function(data){
                        $("#displaylist").html(data);
                        $("#search").val("");
                    }
                })
            }
        });
    });
</script>    
@stop

