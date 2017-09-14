<?php
$tuitionfees =  \App\ledger::where('idno',$idno)->where('school_year',$school_year)->where('category_switch','3')->get();
$otherfees = \App\ledger::where('idno',$idno)->where('school_year',$school_year)->where('category_switch','<','3')->get();
$status = \App\Status::where('idno', $idno)->first();
$list_plans = \App\CtrDueDate::distinct()->where('academic_type', $status->academic_type)->get(['plan']);
?>
<h3>Tuition Fees</h3>
<table border ="1" class="table table-condensed table-bordered">
    <tr>
        <td><b>Description</b></td>
        <td>Amount</td>
        <td>Discount</td>
        <td>ESC</td>
        <td>Total</td>
    </tr>
       <?php $totaltuitionfees=0; ?>
        @foreach($tuitionfees as $tuitionfee)
        <tr>
        <td>{{$tuitionfee->description}}</td>
        <td align="right">{{number_format($tuitionfee->amount,2)}}</td>
        <td align="right">{{number_format($tuitionfee->discount,2)}}</td>
        <td align="right">{{number_format($tuitionfee->esc,2)}}</td>
        <td align="right">{{number_format(($tuitionfee->amount - $tuitionfee->discount)- $tuitionfee->esc,2)}}</td>
        <?php $totaltuitionfees = ($totaltuitionfees + ($tuitionfee->amount - $tuitionfee->discount)-$tuitionfee->esc); ?>       
    </tr>
     @endforeach 
    <tr>
        <td colspan="4">Total Tuition Fee</td>
        <td align="right"><b>{{number_format($totaltuitionfees,2)}}</b></td>   
    </tr>
    </table>

<h3>Other Fees</h3>
<table border ="1" class="table table-condensed table-bordered">
    <tr>
        <td><b>Description</b></td>
        <td>Amount</td>
        <td>Discount</td>
        <td>ESC</td>
        <td>Total</td>
    </tr>
        <?php $totalotherfees=0;?>
        @foreach($otherfees as $tuitionfee)
    <tr>
        
        <td>{{$tuitionfee->description}}</td>
        <td align="right">{{number_format($tuitionfee->amount,2)}}</td>
        <td align="right">{{number_format($tuitionfee->discount,2)}}</td>
        <td align="right">{{number_format($tuitionfee->esc,2)}}</td>
        <td align="right">{{number_format(($tuitionfee->amount-$tuitionfee->discount)- $tuitionfee->esc,2)}}</td>
        <?php $totalotherfees = $totalotherfees +($tuitionfee->amount-$tuitionfee->discount)-$tuitionfee->esc; ?>    
           
    </tr>
        @endforeach 
    <tr>
        <td colspan="4">Total Other Fees</td>
        <td align="right"><b>{{number_format($totalotherfees,2)}}</b></td> </tr> 
        <td colspan="4"><span class="totalfee">Total Fee</span></td>
        <td align="right"><span class="totalfee">{{number_format($totalotherfees+$totaltuitionfees,2)}}</span></td></tr>
    </tr>
    </table>
<form class="form-horizontal" action="{{url('registrar', 'process_payment')}}" method="POST">
    {{ csrf_field()}}
    <input type="hidden" name='idno' value='{{$idno}}'>
    <input type="hidden" name='academic_type' value='{{$status->academic_type}}'>
    <input type="hidden" name='totalTuition' value='{{$totalotherfees+$totaltuitionfees}}'>
    <div class="row">
        <div class="form form-group">
            <div class="col-sm-12">
                <label class="label">Select Plan </label>
                <select id="plan" required="" name="plan" class="form form-control" onchange="displaydownpayment(this.value)">
                    <option value="">Choose Payment</option>
                    <option value="full">Full Payment</option>
                        @if(count($list_plans)>0)
                            @foreach($list_plans as $plan)
                                <option value="{{$plan->plan}}">{{$plan->plan}}</option>
                            @endforeach
                        @endif
                </select>    
            </div>
        </div>
        <div class="form form-group">
            <div class="col-md-12" id="downpayment">
                <!--<input name="downpaymentamount" style="text-align: right" type="number" min="{{($totalotherfees+$totaltuitionfees)*.3}}" class="form-control" id="downpaymentamount" value="{{($totalotherfees+$totaltuitionfees)*.3}}">-->
            </div>    
        </div>
        <div class="form form-group">
            <div class="col-sm-12">
                <input type="submit"class="col-sm-12 btn btn-success" value="Process Payment">
            </div>
        </div>
    </div>
</form>

<script>
    function displaydownpayment(plan){
        $('#downpayment').empty()
        if (plan!="full"){
            $('#downpayment').html("<label class=\"label\">Downpayment</label><div class=\"input-group stylish-input-group\"><span class=\"input-group-addon\">Php</span><input name=\"downpaymentamount\" style=\"text-align: right\" type=\"text\" min=\"{{($totalotherfees+$totaltuitionfees)*.3}}\" class=\"form-control\" id=\"downpaymentamount\" value=\"{{($totalotherfees+$totaltuitionfees)*.3}}\"></div>").show()
        } 
    }
    
    $(document).ready(function() {
        $("#downpayment").keydown(function (e) {
            if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
                (e.keyCode === 65 && (e.ctrlKey === true || e.metaKey === true)) || 
                (e.keyCode >= 35 && e.keyCode <= 40)) {
                     return;
            }
            if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
                e.preventDefault();
            }
        });
    });
    $('#submit').click(function() {
    var downpayment = parseFloat("{{($totalotherfees+$totaltuitionfees)*.3}}");
    var downpaymentamount = parseFloat($("#downpaymentamount").val());
    var plan = $("#plan").val();
    if (plan !== "full"){
        if (downpaymentamount === downpayment){
            return true;
        }
        if (downpaymentamount > downpayment){
            return true;
        }
        if (downpaymentamount < downpayment) {
            alert("Downpayment must be greater than or equal to Php " + downpayment + ".");
            return false;
        }
    }
});
</script>