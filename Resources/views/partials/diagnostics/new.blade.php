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
$discount_allowed = json_decode(m_setting('evaluation.discount'));
?>
{!! Form::open(['route'=>['evaluation.order','diagnosis']])!!}
<table class="table table-condensed" id="evaluation_order">
    {!! Form::hidden('visit',$visit->id) !!}
    <thead>
        <tr>
            <th width="60%">Diagnostics</th>
            <th>Price</th>
            <th>Number Performed</th>
            <th>
                Discount(%)
                @if(!in_array('diagnostics', $discount_allowed))
                <br><small style="color:red">Not Enabled!</small>
                @endif
            </th>
            <th>Amount</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <tr id='addr0'>
            <td><select name="item0" id="item_0" class="select2-single" style="width: 100%" ></select></td>
            <td><input type="text" id="price_0" name='price0' placeholder='Price' readonly=""/></td>
            <td><input type="text" id="quantity_0" name='quantity0' value="1" placeholder="No. Performed"/></td>
            <td>
                @if(in_array('diagnostics', $discount_allowed))
                <input type="text" id="discount_0" name='discount0' value="0" placeholder="Discount"/>
                @else
                <input type="hidden" id="no_discount" value="1">
                <input type="text" style="background-color:#EBEBE4;border:1px solid #ABADB3;padding:2px 1px;" id="discount_0" name='discount0' value="0" placeholder="Discount" readonly=""/>
                @endif
            </td>
            <td><input type="text" id="amount_0" name='amount0' placeholder="Amount" readonly='' /></td>
            <td>
                <button class="btn btn-xs btn-danger remove"><i class="fa fa-trash-o"></i></button>
            </td>
        </tr>
        <tr id='addr1'></tr>
    </tbody>
    <tfoot>
        <tr>
            <th><button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Save</button></th>
        </tr>
    </tfoot>
</table>
{!! Form::close()!!}
<?php
$url = route('api.evaluation.get_procedures', ['diagnostics', $visit->id]);
?>
<script>
    var PROCEDURE_URL = "{{$url}}";
</script>
<script src="{{m_asset('evaluation:js/order_investigation.js')}}"></script>