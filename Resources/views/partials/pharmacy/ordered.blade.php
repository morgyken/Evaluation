<?php
/*
 * =============================================================================
 *
 * Collabmed Solutions Ltd
 * Project: Collabmed Health Platform
 * Author: Samuel Okoth <sodhiambo@collabmed.com>
 *
 * =============================================================================
 */
?>
<div id="feedback-box"></div>


@if(!$drug_prescriptions->isEmpty())
{!! Form::open(['route'=>'evaluation.pharmacy.dispense']) !!}
<table class="table table-striped">
    @foreach($drug_prescriptions as $item)
    <?php
    $price = 0;
    $stock = 0;
    foreach ($item->drugs->prices as $p) {
        if ($p->selling > $price) {
            $price = $p->selling;
        }
    }
    ?>
    <tr id="{{$item->id}}row">
        <td>
            <small>check me</small><br>
            <input type="hidden" name="drug{{$item->id}}" value="{{$item->drugs->id}}">
            <input type="checkbox" id="check{{$item->id}}" onclick="bill(<?php echo $item->id; ?>)" name="item{{$item->id}}">
        </td>
        <td colspan="2">
            <b>{{$item->drugs->name}}</b><br>
            <code>Price:{{number_format($price,2)}}</code><br><br>
            <input type="hidden" value="{{$price}}" name="prc{{$item->id}}" id="prc{{$item->id}}">
            Dispensable Units: {{$item->drugs->stocks?$item->drugs->stocks->quantity:''}}<br>
            Qty Given:<input name="qty{{$item->id}}" onkeyup="bill(<?php echo $item->id; ?>)" class="qty{{$item->id}}" value="1" size="4" type="text" autocomplete="off">
            <br clear="all">
            <p class="sub_total_text{{$item->id}}"></p>
            <input type="hidden" name="item_subtotal{{$item->id}}" class="sub_total{{$item->id}}">
        </td>
        <td>
            <dl class="dl-horizontal">
                <dt>Dose:</dt><dd>{{$item->dose}}</dd>
                <dt>Date:</dt><dd>{{smart_date_time($item->created_at)}}</dd>
                <dt>Prescribed By: </dt><dd> {{$item->users->profile->full_name}} </dd>
                <!-- <b>Payment Mode: </b> Cash<br> -->
            </dl>
        </td>
        <td>
            <!-- <br clear="all">NOT PAID<br> -->
            <a href="#" onclick="cancelPrescription(<?php echo $item->id; ?>)" class="btn btn-warning btn-xs">Cancel</a>
        </td>
    </tr>
    @endforeach
    <tr>
        <td>
            Total Bill:<input type="text" value="0" name="total_bill" class="total_bill">
            <input type="hidden" name="visit" value="{{$visit->id}}">
        </td>
        <td>
            <button type="submit" class="btn btn-xs btn-info"> <i class="fa fa-hand-o-right"></i>Dispense Selected Drugs</button>
        </td>
        <td>

        </td>
    </tr>
</table>
<script>
    var prescURL = "{{route('evaluation.pharmacy.prescription.cancel')}}";
</script>
{!! Form::close()!!}
@else
<p>No drugs ordered for this patient</p>
@endif