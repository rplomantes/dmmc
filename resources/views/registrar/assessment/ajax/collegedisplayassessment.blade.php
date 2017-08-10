<?php
$totalTuition = 0;
$totalTuitionlec = 0;
$totalTuitionlab = 0;
$totalOtherFee = 0;
?>
@if ($type_of_account == 'regular')
@foreach ($grades as $grade)
<?php
$perUnit = $tuition->per_unit * $grade->percent_tuition;
$totalperUnit = $perUnit / 100;
$totalTuitionlec = $grade->lec * $totalperUnit + $totalTuitionlec;
if ($grade->lab > 0) {
    $totalTuitionlab = ($grade->lab * ($totalperUnit * 3)) + $totalTuitionlab;
}
$totalTuition = $totalTuitionlab + $totalTuitionlec;
?>
@endforeach
@else
<?php
$totalTuition = $tuition->amount;
?>
@endif

<table class="col-sm-12">
    <tr>
        <td><b>Tuition Fee:</b></td>
        <td></td>
        <td><div align="right">{{number_format($totalTuition,2)}}</div></td>
    </tr>
    <tr>
        <td><b>Other Fees:</b></td>
        <td></td>
    </tr>
    @foreach ($other_fees as $other_fee)
    <tr>
        <td></td>
        <td>{{$other_fee->description}}</td>
        <td><div align="right">{{number_format($other_fee->amount, 2)}}</div></td>
    </tr>    
    <?php
    $totalOtherFee = $other_fee->amount + $totalOtherFee;
    ?>
    @endforeach
    @if ($grade->lab>0)
    <tr>
        <td></td>
        <td>{{$lab_fee->description}}</td>
        <td><div align="right">{{number_format($lab_fee->amount, 2)}}</div></td>
    </tr>
    <?php $totalOtherFee = $lab_fee->amount + $totalOtherFee; ?>
    @endif
    <tr>
        <td><b>Total Other Fees</b></td>
        <td></td>
        <td style="border-top: 1pt solid;"><div align="right">{{number_format($totalOtherFee,2)}}</div></td>
    </tr>
    <tr>
        <td><b>Total Assessed Fees</b></td>
        <td></td>
        <td style="border-top: 1pt solid;"><div align="right"><?php $totalAssessedFee = $totalOtherFee + $totalTuition;
    echo number_format($totalAssessedFee, 2); ?></div></td>
    </tr>

    @if ($plan != 'Full')
    <?php
    $downpayment = $totalAssessedFee * .3;
    $payment = $totalAssessedFee - $downpayment;
    $installment = $payment * 1.12;
    $need_to_pay = $installment / count($plans);
    $totalInstallment = 0;
    ?>
    <tr>
        <td><h4>Schedule of Payment</h4></td>
        <td></td>
    </tr>
    <tr>
        <td><b>{{$plan}}</b></td>
        <td></td>
        <td></td>
    </tr>
    <tr>
        <td></td>
        <td>Downpayment</td>
        <td><div align="right">{{number_format($downpayment,2)}}</div></td>
    </tr>
    @foreach ($plans as $planss)
    <tr>
        <td></td>
        <td>{{date('M d, Y (D)', strtotime($planss->due_date))}}</td>
        <td><div align="right"><?php $totalInstallment = $need_to_pay + $totalInstallment; ?> {{number_format($need_to_pay,2)}}</div></td>
    </tr>
    @endforeach
    <tr>
        <td><b>Total Payment</b></td>
        <td></td>
        <td style="border-top: 1pt solid;"><div align="right"><b><?php $totalPayment = $totalInstallment + $downpayment;
    echo number_format($totalPayment, 2); ?></b></div></td>
    </tr>
    @else
    <tr>
        <td><b>Total Payment</b></td>
        <td></td>
        <td style="border-top: 1pt solid;"><div align="right"><b><?php $totalPayment = $totalAssessedFee; ?>{{number_format($totalPayment, 2)}}</b></div></td>
    </tr>
    @endif
</table>
