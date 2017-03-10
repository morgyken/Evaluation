
<table class="items table  table-striped" id="tab_logic">
    <thead>
        <tr>
            <th>Inventory Item</th>
            <th class="text-center" style="width: 10%;">Quantity</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
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