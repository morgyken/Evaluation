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
<div id="feedback-box"><p>NOTE: Ensure the corresponding check-boxes are checked to proceed</p></div>
@if(!$drug_prescriptions->isEmpty())
    {!! Form::open(['route'=>'evaluation.pharmacy.dispense']) !!}
    {{Form::hidden('visit',$visit->id)}}
    <table class="table table-condensed" width="100%" id="myTable">
        <thead>
        <tr>
            <th>#</th>
            <th>Drug</th>
            <th>Prescription</th>
            <th>Price</th>
            <th>Quantity</th>
            <th>Total</th>
        </tr>
        </thead>
        <tbody>
        @foreach($drug_prescriptions as $item)
            @if($item->payment->paid || $item->payment->invoiced || $visit->admission_request_id != 0)
                <?php

                $visit = $item->visits;

                ?>
                <tr id="row{{$item->id}}">
                    <td>
                        {{$loop->iteration}}
                        <input type="hidden" name="presc{{$item->id}}" value="{{$item->id}}">
                        <input type="hidden" name="drug{{$item->id}}" value="{{$item->drugs->id}}">
                        <input type="hidden" value="{{$item->id}}" name="item{{$item->id}}">
                    </td>
                    <td>
                        {{$item->drugs->name}}<br>
                        {{--<i>{{ $item->drugs->stocks?$item->drugs->stocks->quantity>0?$item->drugs->stocks->quantity:0:0}}--}}
                            {{--in--}}
                            {{--store</i>--}}
                    </td>
                    <td>
                        <dl class="dl-horizontal">
                            <dt>Dose:</dt>
                            <dd>{{$item->dose}}</dd>
                            <dt>Date:</dt>
                            <dd>{{smart_date_time($item->created_at)}}</dd>
                            <dt>Prescribed By:</dt>
                            <dd> {{$item->users->profile->full_name}} </dd>
                            <dt>Notes</dt>
                            <dd><em><u>{{$item->notes??'N/A'}}</u></em></dd>
                            <!-- <b>Payment Mode: </b> Cash<br> -->
                        </dl>
                    </td>
                    <td>
                        <code>{{$item->payment->price}}</code>
                        <input type="hidden" value="{{$item->payment->price}}" name="prc{{$item->id}}"
                               id="prc{{$item->id}}">
                    </td>
                    <td>
                        <input name="qty{{$item->id}}" id="quantity{{$item->id}}"
                               class="qty{{$item->id}}"
                               value="{{$item->payment->quantity}}"
                               size="4"
                               type="text" readonly></td>
                    <td>
                        <input class="txt" size="10" readonly id="total{{$item->id}}" type="text"
                               name="txt"/>
                    </td>
                </tr>

            @else
                <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>Drug {{$loop->iteration}}</td>
                    <td><span class="text-danger">Send patient to cashier first</span></td>
                    <td>---</td>
                    <td>---</td>
                    <td><span class="label label-danger">NOT PAID</span></td>
                </tr>
            @endif
        @endforeach
        </tbody>
    </table>
    <div>
        <button type="submit" class="btn btn-round btn-success">
            <i class="fa fa-hand-o-right"></i>
            Dispense
        </button>
    </div>
    <script>
        $(document).ready(function () {
            
            function doMaths() {
                var sum = 0;
                $('#myTable').find('tbody').find('tr').each(function () {
                    var price = parseFloat($(this).find("[id^='prc']").val());
                    var quantity = parseFloat($(this).find("[id^='quantity']").val());
                    var total = (price * quantity);
                    $(this).find("[id^='total']").val(total);
                    sum += parseFloat(total);
                });
                $("input#sum1").val(sum);
            }

            doMaths();
        });
    </script>
    {!! Form::close()!!}
@else
    <p>No drugs ordered for this patient</p>
@endif