<?php
/**
 * Created by PhpStorm.
 * User: bravoh
 * Date: 9/4/17
 * Time: 5:35 PM
 */
?>

<table class="sensitivity table  table-striped" id="sense_logic">
    <thead>
    <tr>
        <th>Drug</th>
        <th class="text-center" style="width: 10%;">Sensitive</th>
        <th class="text-center" style="width: 10%;">Reactive</th>
        <th></th>
    </tr>
    </thead>
    <tbody>
    <tr id='row0'>
        <td>
            <select name="drug0" class="drugs" style="width: 100%"></select>
        </td>
        <td>
            <input type="text" name='sensitive0' placeholder='Sensitive' value="1"/>
        </td>
        <td><input type="text" name='reactive0' placeholder='Reactive' value="1"/></td>
        <td>
            <button style="float: right" class="btn btn-xs btn-danger remove">
                <i class="fa fa-trash-o"></i>
            </button>
        </td>
    </tr>
    <tr id='row1'></tr>
    </tbody>
    <tfoot>
    <tr>
        <td>
            <a id="add_row" class="btn btn-primary btn-xs pull-left">
                <i class="fa fa-plus"></i>
                Add
            </a>
        </td>
    </tr>
    </tfoot>
</table>
<script>
    function update_item(id, type) {
        var procedure = $('#item_procedure' + id).val();
        var item = $('#inventory_item' + id).val();
        var quantity = $('#item_quantity' + id).val();
        $.ajax({
            type: 'GET',
            url: '{{route("api.evaluation.manage_inventory_items")}}',
            data: {'procedure': procedure, 'item': item, 'quantity': quantity, 'type': type},
            success: function (data) {
                alertify.success(data);
            },
            error: function () {
                alertify.error('Could not update procedure inventory item');
            }
        });
    }
</script>
<script type="text/javascript">
    var PRODUCTS_URL = "{{route('api.inventory.get_products')}}";
</script>
<script src="{!! m_asset('evaluation:js/sensitivity.js') !!}"></script>
