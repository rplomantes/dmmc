<?php
$list_plans = \App\CtrDueDate::distinct()->get(['plan']);
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
        <?php $totalotherfees=0;?>
        @foreach($otherfees as $tuitionfee)
    <tr>
        
        <td>{{$tuitionfee->description}}</td>
        <td align="right">{{number_format($tuitionfee->amount,2)}}</td>
        <td align="right">{{number_format($tuitionfee->discount,2)}}</td>
        <td align="right">{{number_format($tuitionfee->amount-$tuitionfee->discount,2)}}</td>
        <?php $totalotherfees = $totalotherfees +$tuitionfee->amount-$tuitionfee->discount; ?>    
           
    </tr>
        @endforeach 
    <tr>
        <td colspan="3">Total Other Fees</td>
        <td align="right"><b>{{number_format($totalotherfees,2)}}</b></td> </tr> 
        <td colspan="3"><span class="totalfee">Total Fee</span></td>
        <td align="right"><span class="totalfee">{{number_format($totalotherfees+$totaltuitionfees,2)}}</span></td></tr>
    </tr>
    </table>
 <div class="col-sm-6">
        <label class="label">Select Plan </label>
               <select id="plan" class="form form-control">
                   <option value="">Full Payment</option>
                         @if(count($list_plans)>0)
                               @foreach($list_plans as $plan)
                                           <option value="{{$plan->paln}}">{{$plan->plan}}</option>
                               @endforeach
                               @endif
                               </select>    
                               </div>
<div class="col-md-12">
    <div class="form form-group">
        <label>Intended Downpayment</label>
        <input style="text-align: right" type="number" min="{{($totalotherfees+$totaltuitionfees)*.3}}" class="form-control" id="downpaymentamount" value="{{($totalotherfees+$totaltuitionfees)*.3}}">
    </div>    
</div>    