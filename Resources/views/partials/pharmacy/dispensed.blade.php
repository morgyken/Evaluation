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
<table class="table table-striped table-condensed">
    <tr>
        <th>#</th>
        <th>Date</th>
        <th>Drug</th>
        <th>Prescription</th>
        <th>Price</th>
        <th>Discount</th>
        <th>Quantity Given</th>
        <th>Amount</th>
        <th>Action</th>
    </tr>
    <?php try { ?>
        @foreach($dispensed as $presc)
        @foreach($presc->dispensing as $disp)
        @foreach($disp->details as $item)
        <tr>
            <td>{{$loop->iteration}}</td>
            <td>{{$disp->created_at}}</td>
            <td>{{$item->drug->name}}</td>
            <td>
                <strong>Dose:</strong>{{$presc->dose}},
                <strong>Date:</strong>{{smart_date_time($presc->created_at)}},
                <strong>By:</strong>{{$presc->users->profile->full_name}}
            </td>
            <td>{{$item->price}}</td>
            <td>{{$item->discount}}</td>
            <td>{{$item->quantity}}</td>
            <td>{{((100-$item->discount)/100)*$item->quantity*$item->price}}</td>
            <td>
                <!--
                <a href="" class="btn btn-primary btn-xs">Print</a>
                -->
                |<a href="{{route('evaluation.pharmacy.purge.presc', $presc->id)}}" class="btn btn-danger btn-xs">Cancel</a>

            </td>
        </tr>
        @endforeach
        @endforeach
        @endforeach
        <?php
    } catch (Exception $ex) {
        //Sip Keg
    }
    ?>
</table>
@else
<p>No drugs have been dispensed for this patient yet</p>
@endif