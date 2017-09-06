<?php
/**
 * Created by PhpStorm.
 * User: bravoh
 * Date: 9/4/17
 * Time: 5:35 PM
 */
?>
<input type='hidden' id='__test_id{{$s_item->id}}' name='__test_id' value='{{$s_item->id}}'>
<input type='hidden' id='__procedure_id{{$s_item->id}}_{{$item->procedures->id}}' value='{{$s_item->id}}'>
<input type='hidden' id='__visit_id' name='__visit_id' value='{{$visit->id}}'>
<script>
    var TEST_ID = "{{$s_item->id}}";
</script>
<table class="sensitivity table  table-striped" id="sense_logic">
    <thead>
    <tr><td colspan="4">{{$s_item->name}}</td></tr>
    <tr>
        <th>Drug</th>
        <th class="text-center" style="width: 10%;">Reactive</th>
        <th class="text-center" style="width: 10%;">Sensitive</th>
        <th></th>
    </tr>
    </thead>
    <tbody>
    <tr id='row0'>
        <td>
            <select name="drug0" id="drug0" class="drugs" style="width: 100%"></select>
        </td>
        <td><input onclick='save_sensitivity(0,"R",TEST_ID)' style="margin-left: 40%" type="checkbox" class="radio" value="reactive" name="rs0" /></td>
        <td><input onclick='save_sensitivity(0,"S",TEST_ID)' style='margin-left: 40%' type="checkbox" class="radio" value="sensitive" name="rs0" /></td>
        <td>
            <button style="float: right" class="btn btn-xs btn-danger remove">
                <i class="fa fa-trash-o"></i>
            </button>
        </td>
    </tr>
    </tbody>
    <tfoot>
    <tr>
        <td>
            <a  class="add_row btn btn-primary btn-xs pull-left">
                <i class="fa fa-plus"></i>
                Add
            </a>
        </td>
    </tr>
    </tfoot>
</table>
<script type="text/javascript">
    var PRODUCTS_URL = "{{route('api.inventory.get_products')}}";
</script>
<script src="{!! m_asset('evaluation:js/sensitivity.js') !!}"></script>
<script>
    function save_sensitivity(i,type,id) {
        var test_id = $('#__test_id' + id).val();
       // var procedure_id = $('#__procedure_id' + id).val();
        var visit_id = $("#__visit_id").val();
        var drug_id = $('#drug' + i).val();
        var sensitivity = type;
        $.ajax({
            type: 'GET',
            url: '{{route("api.evaluation.save_sensitivity")}}',
            data: {
                'test_id': test_id,
                'visit_id': visit_id,
                'drug_id': drug_id,
                'sensitivity': sensitivity
            },
            success: function (data) {
                alertify.success(data);
            },
            error: function () {
                alertify.error('Could not update procedure inventory item');
            }
        });
    }
</script>