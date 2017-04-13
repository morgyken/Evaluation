{!! Form::open(['class'=>'form-horizontal', 'route'=>'evaluation.evaluate.pharmacy.prescription']) !!}
<!--<input type="hidden" name="payment_mode" value="{{$visit->mode}}"> -->
<input type="hidden" name="visit" value="{{$visit->id}}">
<table class="table" style="width: 70%">
    <tr>
        <th>Drug</th>
        <td><select name="drug"   id="item_0" class="select2-single" style="width: 100%" required=""></select></td>
    </tr>
    <tr>
        <th>Dose</th>
        <td>
            <input type="text" name="take" id="Take" class="form-control"/>
            {!! Form::select('whereto',mconfig('evaluation.options.prescription_whereto'),null,['class'=>'form-control'])!!}
            {!! Form::select('method',mconfig('evaluation.options.prescription_method'),null,['class'=>'form-control'])!!}
        </td>
    </tr>
    <tr>
        <th>Duration</th>
        <td>
            <input type="text" name="duration" placeholder="e.g 3" class='form-control'/>
            {!! Form::select('time_measure',mconfig('evaluation.options.prescription_duration'),null,['class'=>'form-control'])!!}</td>
    </tr>
    <tr>
        <th>Substitution Allowed?</th>
        <td>
            Yes:<input type="checkbox" name="allow_substitution" value="1"/>
        </td>
    </tr>
</table>
<button type="submit" class="btn btn-xs btn-primary " id="savePrescription">
    <i class="fa fa-save"></i> Save
</button>
{!! Form::close() !!}
<script>
    var INSURANCE = false;
    var STOCK_URL = "{{route('api.inventory.getstock')}}";
    var PRODUCTS_URL = "{{route('api.inventory.get.products')}}";
</script>
<script src="{!! m_asset('evaluation:js/prescription.js') !!}"></script>