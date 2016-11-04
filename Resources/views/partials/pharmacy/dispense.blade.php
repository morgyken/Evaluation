{!! Form::open(['class'=>'form-horizontal', 'route'=>'inventory.shopfront']) !!}
<input type="hidden" name="pharmacy" value="1">
<input type="hidden" name="payment_mode" value="{{$visit->mode}}">
<input type="hidden" name="visit_id" value="{{$visit->id}}">
<input type="hidden" name="patient_id" value="{{$patient->id?$patient->id:''}}">
<table class="items table  table-striped table-condensed" id="tab_logic">
    <thead>
        <tr>
            <th style="width: 20%;">Item</th>
            <th class="text-center" style="width: 10%;">Quantity</th>
            <th class="text-center" style="width: 20%;">Price</th>
            <th style="width: 2%;">Discount (%)</th>
            <th style="width: 12%;">Total</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <tr id='addr0'>
            <td><select name="item0"   id="item_0" class="select2-single" style="width: 100%" required=""></select></td>
            <td>
                <input type="text" id="item_qty_0" autocomplete="off"  name='qty0' placeholder='Quantity' value="0"
                       class="quantities"/>
                <input type="hidden" name="batch0">
                <span id="fb0"></span>
            </td>
            <td><input type="text" id="item_price_0" name='price0' placeholder='Price'/></td>
            <td><input type="text" name='dis0' placeholder='Discount' value="0"/></td>
            <td><span id="total0">0.00</span></td>
            <td>
                <button class="btn btn-xs btn-danger remove"><i class="fa fa-trash-o"></i></button>
            </td>
        </tr>
        <tr id='addr1'>
            <td><select name="item1"   id="item_1" class=" select2-single" style="width: 100%"></select></td>
            <td>
                <input type="text"  name='qty1' id="item_qty_1" autocomplete="off"  placeholder='Quantity' value="0"
                       class="quantities"/>
                <input type="hidden" name="batch1">
                <span id="fb1"></span>
            </td>
            <td><input type="text" name='price1' placeholder='Price'/></td>
            <td><input type="text" name='dis1' placeholder='Discount' value="0"/></td>
            <td><span id="total1">0.00</span></td>
            <td>
                <button class="btn btn-xs btn-danger remove"><i class="fa fa-trash-o"></i></button>
            </td>
        </tr>
        <tr id='addr2'>
            <td><select name="item2"  id="item_2" class=" select2-single" style="width: 100%"></select></td>
            <td>
                <input type="text" name='qty2' id="item_qty_2" autocomplete="off"  placeholder='Quantity' value="0" class="quantities"/>
                <span id="fb2"></span>
                <input type="hidden" name="batch2">
            </td>
            <td><input type="text" name='price2' placeholder='Price'/></td>
            <td><input type="text" name='dis2' placeholder='Discount' value="0"/></td>
            <td><span id="total2">0.00</span></td>
            <td>
                <button class="btn btn-xs btn-danger remove"><i class="fa fa-trash-o"></i></button>
            </td>

        </tr>
        <tr id='addr3'></tr>
    </tbody>
    <tfoot>
        <tr>
            <td>
                <a id="add_row" class="btn btn-primary btn-sm pull-left">
                    <i class="fa fa-plus"></i>
                    Add</a>
            </td>
            <td colspan="3"></td>
            <td><strong id="total">0.00</strong></td>
            <td></td>
        </tr>
    </tfoot>
</table>

<table class="table table-condensed">
    <tr>
        <td style="text-align: right">Total:</td><td><strong id="sum"></strong></td>
        <td style="text-align: right">Discount:</td><td><strong id="discount"></strong></td>
        <td style="text-align: right">Amount:</td><td>
            <input name="amount" type="text" id="amnt" class="form-control" required/><br>
            <button type="submit" id="save" class="btn btn-success pull-right">
                <i class="fa fa-send"></i> Dispense
            </button>
        </td>
    </tr>
</table>
{!! Form::close() !!}

<script>
    var INSURANCE = false;
    var STOCK_URL = "{{route('api.inventory.getstock')}}";
    var PRODUCTS_URL = "{{route('api.inventory.get.products')}}";
    var CREDIT_URL = "{{route('api.inventory.credit.rate')}}";
</script>
<script src="{!! m_asset('inventory:js/shopfront.js') !!}"></script>