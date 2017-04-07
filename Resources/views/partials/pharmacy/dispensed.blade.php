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
@if(!$dispensed->isEmpty())
{!! Form::open(['route'=>'evaluation.pharmacy.dispense']) !!}
<table class="table">
    <tr>
        <th>#</th>
        <th>Drug</th>
        <th>Prescription</th>
        <th>Price</th>
        <th>Discount</th>
        <th>Quantity Given</th>
        <th>Total</th>
        <th>Action</th>
    </tr>
    @foreach($dispensed as $item)
    <?php
    $price = 0;
    $stock = 0;
    $cash_price = 0;
    $credit_price = 0;
    foreach ($item->drugs->prices as $p) {
        if ($p->price > $price) {
            $price = $p->price;
        }
    }

    if (isset($item->drugs->categories->cash_markup)) {
        $cp = (($item->drugs->categories->cash_markup + 100) * $price) / 100;
    } else {
        $cp = $price;
    }

    if (isset($item->drugs->categories->credit_markup)) {
        $crp = (($item->drugs->categories->credit_markup + 100) * $price) / 100;
    } else {
        $crp = $price;
    }

    $cash_price += $cp;
    $credit_price += $crp;
    ?>
    <tr>
        <td>{{$loop->iteration}}</td>
        <td>{{$item->drugs->name}}</td>
        <td>
            <dl class="dl-horizontal">
                <dt>Dose:</dt><dd>{{$item->dose}}</dd>
                <dt>Date:</dt><dd>{{smart_date_time($item->created_at)}}</dd>
                <dt>Prescribed By: </dt><dd> {{$item->users->profile->full_name}} </dd>
                <!-- <b>Payment Mode: </b> Cash<br> -->
            </dl>
        </td>
        <td>
            <?php
            if (preg_match('/Insurance/', $visit->mode)) {
                $price = $credit_price;
                ?>
                <code>{{number_format($credit_price,2)}}</code>
                <?php
            } else {
                $price = $cash_price;
                ?>
                <code>{{number_format($cash_price,2)}}</code>
                <?php
            }
            ?>
            <input type="hidden" value="{{$price}}" name="prc{{$item->id}}" id="prc{{$item->id}}">
        </td>
        <td><input size="5" class="discount" id="discount{{$item->id}}" type="text" onkeyup="getTotal(<?php echo $item->id; ?>)" name="discount{{$item->id}}" value="0" /></td>
        <td>
            <input name="qty{{$item->id}}" id="quantity{{$item->id}}" onkeyup="getTotal(<?php echo $item->id; ?>)" class="qty{{$item->id}}" value="0" size="4" type="text" autocomplete="off"></td>
        <td>
            <input class="txt" size="10" readonly=""id="total{{$item->id}}" type="text" name="txt" />
        </td>
        <td><a href="#" onclick="cancelPrescription(<?php echo $item->id; ?>)" class="btn btn-danger btn-xs">Cancel</a></td>
    </tr>
    @endforeach
    <tr id="summation">
        <td  colspan ="6" align="right">
            Sum :
        </td>
        <td>
            <input type="hidden" name="visit" value="{{$visit->id}}">
        </td>
        <td></td>
    </tr>
</table>
@else
<p>No drugs have been dispensed yet</p>
@endif