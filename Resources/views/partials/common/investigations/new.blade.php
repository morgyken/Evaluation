<?php
/*
 * =============================================================================
 *
 * Collabmed Solutions Ltd
 * Project: Collabmed Health Platform
 * Author: Bravo Gidi <bkiptoo@collabmed.com>
 *
 * =============================================================================
 */
?>
<table class="table table-condensed" id="evaluation_order">
    <thead>
        <tr>
            <th width="60%">Procedure</th>
            <th>Price</th>
            <th>Number Performed</th>
            <th>
                Discount(%)
                @if(is_array($discount_allowed) && !in_array('radiology', $discount_allowed))
                    <br><small style="color:red">Not Enabled!</small>
                @endif
            </th>
            <th>Amount</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <tr id='addr0'>
            <td><select name="item0" id="item_0" class="select2-single" style="width: 100%;"></select></td>
            <td><input type="text" id="price_0" name='price0' placeholder='Price' readonly/></td>
            <td><input type="text" id="quantity_0" name='quantity0' value="1" placeholder="No. Performed"/></td>
            <td>
                @if(is_array($discount_allowed) && in_array($type, $discount_allowed))
                    <input type="text" id="discount_0" name='discount0' value="0" placeholder="Discount"/>
                @else
                    <input type="hidden" id="no_discount" value="1">
                    <input type="text" style="background-color:#EBEBE4;border:1px solid #ABADB3;padding:2px 1px;" id="discount_0" name='discount0' value="0" placeholder="Discount" readonly/>
                @endif
            </td>
            <td><input type="text" id="amount_0" name='amount0' placeholder="Amount" readonly/></td>
            <td>
                <button class="btn btn-xs btn-danger remove"><i class="fa fa-trash-o"></i></button>
            </td>
        </tr>
        <tr id='addr1'></tr>
    </tbody>
    <tfoot>
        <tr>
            <th>
                <input type="submit" class="btn btn-success" id = "save_investigations" value="Save" name="Save">
            </th>
        </tr>
    </tfoot>
</table>