<?php
$totalTuition=0;
$totalOtherFee = 0;
?>
@if ($type_of_account == 'regular')
    @foreach ($grades as $grade)
        <?php 
        $perUnit = $tuition->per_unit * $grade->percent_tuition;
        $totalperUnit = $perUnit / 100;
        $totalTuition=$grade->lec * $totalperUnit + $totalTuition;
        ?>
    @endforeach
@else
    <?php
    $totalTuition = $tuition->amount;
    ?>
@endif

<table class="col-sm-12">
    <tr>
        <td>Tuition Fee:</td>
        <td></td>
        <td><div align="right">{{$totalTuition}}</div></td>
    </tr>
    <tr>
        <td>Other Fees:</td>
        <td></td>
    </tr>
    @foreach ($other_fees as $other_fee)
    <tr>
        <td></td>
        <td>{{$other_fee->description}}</td>
        <td><div align="right">{{$other_fee->amount}}</div></td>
    </tr>
    <?php
    $totalOtherFee = $other_fee->amount + $totalOtherFee;
    ?>
    @endforeach
    <tr>
        <td>Total Other Fees</td>
        <td></td>
        <td style="border-top: 1pt solid;"><div align="right">{{$totalOtherFee}}</div></td>
    </tr>
    <tr>
        <td>Total Assessed Fees</td>
        <td></td>
        <td style="border-top: 1pt solid;"><div align="right">{{$totalOtherFee + $totalTuition}}</div></td>
    </tr>
</table>
<table class="col-sm-12">
    <tr>
        <td>Schedule of Payment</td>
        <td>Option 1</td>
    </tr>
    @foreach ($plans as $plan)
    <tr>
        <td>{{$plan->due_date}}</td>
    </tr>
    @endforeach
</table>