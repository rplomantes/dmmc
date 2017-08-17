<?php
$tuitionfees =  \App\ledger::where('idno',$idno)->where('school_year',$school_year)->where('period',$period)->where('category_switch','3')->get();
$otherfees = \App\ledger::where('idno',$idno)->where('school_year',$school_year)->where('period',$period)->where('category_switch','<','3')->get();
?>
<h3>Tuition Fees</h3>
<table border ="1" class="table table-condensed">
    <tr>
        <td><b>Description</b></td>
        <td>Amount</td>
        <td>Discount</td>
        <td>Total</td>
    </tr>
       <?php $totaltuitionfees=0; ?>
        @foreach($tuitionfees as $tuitionfee)
        <tr>
        <td>{{$tuitionfee->description}}</td>
        <td align="right">{{number_format($tuitionfee->amount,2)}}</td>
        <td align="right">{{number_format($tuitionfee->discount,2)}}</td>
        <td align="right">{{number_format($tuitionfee->amount-$tuitionfee->discount,2)}}</td>
        <?php $totaltuitionfees = $totaltuitionfees +$tuitionfee->amount-$tuitionfee->discount; ?>       
    </tr>
     @endforeach 
    <tr>
        <td colspan="3">Total Tuition Fee</td>
        <td align="right"><b>{{number_format($totaltuitionfees,2)}}</b></td>   
    </tr>
    </table>

<h3>Other Fees</h3>
<table border ="1" class="table table-condensed">
    <tr>
        <td><b>Description</b></td>
        <td>Amount</td>
        <td>Discount</td>
        <td>Total</td>
    </tr>
        <?php $totaltuitionfees=0;?>
        @foreach($otherfees as $tuitionfee)
    <tr>
        
        <td>{{$tuitionfee->description}}</td>
        <td align="right">{{number_format($tuitionfee->amount,2)}}</td>
        <td align="right">{{number_format($tuitionfee->discount,2)}}</td>
        <td align="right">{{number_format($tuitionfee->amount-$tuitionfee->discount,2)}}</td>
        <?php $totaltuitionfees = $totaltuitionfees +$tuitionfee->amount-$tuitionfee->discount; ?>    
           
    </tr>
        @endforeach 
    <tr>
        <td colspan="3">Total Tuition Fee</td>
        <td align="right"><b>{{number_format($totaltuitionfees,2)}}</b></td>   
    </tr>
    </table>