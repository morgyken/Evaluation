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
{!! Form::open(['route'=>['evaluation.order','laboratory']])!!}
{!! Form::hidden('visit',$visit->id) !!}
<table class="table table-condensed" id="evaluation_order">
    <thead>
        <tr>
            <th width="60%">Lab Test</th>
            <th>Price</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <tr id='addr0'>
            <td><select name="item0" id="item_0" class="select2-single" style="width: 100%" ></select></td>
            <td><input type="text" id="price_0" name='price0' placeholder='Price' readonly=""/></td>
            <td><input type="text" id="quantity_0" name='quantity0' value="1" placeholder="No. Performed"/></td>
            <td><input type="text" id="discount_0" name='discount0' value="0" placeholder="Discount"/></td>
            <td><input type="text" id="amount_0" name='amount0' placeholder="Amount" readonly='' /></td>
            <td>
                <button class="btn btn-xs btn-danger remove"><i class="fa fa-trash-o"></i></button>
            </td>
        </tr>
        <tr id='addr1'></tr>
    </tbody>
    <tfoot>
        <tr>
            <th>
                <input type="submit" class="btn btn-success" value="Save" name="Save">
            </th>
        </tr>
    </tfoot>
</table>
{!! Form::close()!!}
<?php
$url = route('api.evaluation.get_procedures', ['laboratory', $visit->id]);
?>
<script>
    var PROCEDURE_URL = "{{$url}}";
    var ORDERING = true;
</script>
<script src="{{m_asset('evaluation:js/order_investigation.js')}}"></script>