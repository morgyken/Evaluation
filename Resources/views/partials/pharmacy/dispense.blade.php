{!! Form::open(['class'=>'form-horizontal', 'route'=>'evaluation.evaluate.pharmacy.prescription']) !!}
<!--<input type="hidden" name="payment_mode" value="{{$visit->mode}}"> -->
<input type="hidden" name="visit" value="{{$visit->id}}">
<table class="items table  table-striped table-condensed" id="tab_logic">
    <thead>
        <tr>
            <th style="width: 20%;">Drug</th>
            <th class="text-center">Dose</th>
            <th class="text-center">Duration</th>
            <th style="width: 2%;">Substitution allowed?</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <tr id='addr0'>
            <td>
                <select name="drug"   id="item_0" class="select2-single" style="width: 100%" required=""></select>
            </td>
            <td>
                <input type="text" name="take" id="Take" class="form-control"/>
                {!! Form::select('whereto',mconfig('evaluation.options.prescription_whereto'),null,['class'=>'form-control'])!!}
                {!! Form::select('method',mconfig('evaluation.options.prescription_method'),null,['class'=>'form-control'])!!}
                <span id="fb0"></span>
            </td>
            <td class="text-center">
                <input type="text" name="duration" placeholder="e.g 3 days" class='form-control'/>
                {!! Form::select('time_measure',mconfig('evaluation.options.prescription_duration'),null,['class'=>'form-control'])!!}
            </td>
            <td>
                Yes:<input type="checkbox" name="allow_substitution" value="1"/>
            </td>
            <td>
                <button class="btn btn-xs btn-danger remove"><i class="fa fa-trash-o"></i></button>
            </td>
        </tr>
    </tbody>
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