
<table class="items table  table-striped" id="tab_logic">
    <thead>
        <tr>
            <th>Inventory Item</th>
            <th class="text-center" style="width: 10%;">Quantity</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        @if($procedure->items->count() > 0)
        @foreach($procedure->items as $item)
        <tr id='addr{{$item->item}}'>
            <td>
                <input disabled="" type="text" value="{{$item->inventory->name}}" name="item{{$item->item}}">
                <input type="hidden" value="{{$item->inventory->id}}" id="inventory_item{{$item->item}}">
            </td>
            <td>
                <input type="hidden"  value="{{$procedure->id}}" id="item_procedure{{$item->item}}">
                <input id="item_quantity{{$item->item}}" onkeyup="update_item(<?php echo $item->item; ?>, 'update')" type="text" name='qty{{$item->item}}' placeholder='Quantity' value="{{$item->units}}"/>
            </td>
            <td>
                <button onclick="update_item(<?php echo $item->item; ?>, 'delete')" id="remove_item{{$item->item}}" style="float: right" class="btn btn-xs btn-danger remove">
                    <i class="fa fa-trash-o"></i>
                </button>
            </td>
        </tr>
        @endforeach
        @endif
        <tr id='addr0'>
            <td>
                <select name="item0" class=" select2-single" style="width: 100%"></select>
            </td>
            <td>
                <input type="text" name='qty0' placeholder='Quantity' value="1"/>
            </td>
            <td>
                <button style="float: right" class="btn btn-xs btn-danger remove">
                    <i class="fa fa-trash-o"></i>
                </button>
            </td>
        </tr>
        <tr id='addr1'></tr>
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