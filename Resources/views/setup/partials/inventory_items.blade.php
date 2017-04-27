
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
            </td>
            <td>
                <input type="text" name='qty{{$item->item}}' placeholder='Quantity' value="{{$item->units}}"/>
            </td>
            <td>
                <button style="float: right" class="btn btn-xs btn-danger remove">
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