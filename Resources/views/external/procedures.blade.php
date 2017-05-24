<table class="table table-condensed" id="evaluation_order">
    <thead>
        <tr>
            <th width="60%">Procedure</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <tr id='addr0'>
            <td>
                <select name="item0" id="item_0" class="select2-single" style="width:100%" >
                </select>
            </td>
            <td>
                <button class="btn btn-xs btn-danger remove"><i class="fa fa-trash-o"></i></button>
            </td>
        </tr>
        <tr id='addr1'></tr>
    </tbody>
    <tfoot>
        <tr>
            <th>
                <input type="submit" class="btn btn-success" value="Save" name="Save">
            </th>
        </tr>
    </tfoot>
</table>

<?php
$url = route('api.evaluation.get_all_procedures');
?>
<script>
    var PROCEDURE_URL = "{{$url}}";
</script>
<script src="{{m_asset('evaluation:js/external_procedure.js')}}"></script>