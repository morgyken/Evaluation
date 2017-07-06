<table class="table table-condensed table-striped">
    <tr>
        <td>
            {{$item->procedures->name}}
            <input type="hidden" name="item{{$item->id}}" value="{{$item->id}}" />
            <input type="hidden" name="test{{$item->id}}[]" value="{{$item->procedures->id}}" />
        </td>
        <td>
            <?php $type = $item->procedures->this_test?$item->procedures->this_test->lab_result_type:''; ?>
            @include('evaluation::partials.labs.input_field')
        </td>
    </tr>
    <tr>
        <td colspan="2">
            @include('evaluation::partials.labs.comment')
        </td>
    </tr>
</table>