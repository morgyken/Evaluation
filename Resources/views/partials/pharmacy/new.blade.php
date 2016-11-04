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
            <th width="60%">Prescriptions</th>
            <th>Price</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <tr id='proc_addr0'>
            <td><select name="proc_item0" id="proc_item_0" class="select2-single" style="width: 100%" ></select></td>
            <td><input type="text" id="proc_price_0" name='proc_price0' placeholder='Price'/></td>
            <td>
                <button class="btn btn-xs btn-danger remove"><i class="fa fa-trash-o"></i></button>
            </td>
        </tr>
        <tr id='proc_addr1'></tr>
    </tbody>
    <tfoot>
        <tr>
            <th><button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Save</button></th>
        </tr>
    </tfoot>
</table>
{!! Form::close()!!}
<script>
    var PROCEDURE_URL = "{{route('api.evaluation.get_procedures','laboratory')}}";
</script>
<script src="{{m_asset('evaluation:js/myselect.js')}}"></script>