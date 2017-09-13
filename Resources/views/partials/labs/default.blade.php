<table class="table table-condensed table-striped">
    <?php
    $tests = get_lab_template($item->procedures->id);
    $t_array = array();
    ?>
    @foreach($tests as $test)
    <?php $t_array[] = $test->subtests->id; ?>
    <tr>
        <td>
            {{$test->subtests->name}}
            <input type="hidden" name="item{{$item->id}}" value="{{$item->id}}" />
            <input type="hidden" name="test{{$item->id}}[]" value="{{$test->subtest}}" />
        </td>
        <td>
            <?php $type = $test->subtests->this_test->lab_result_type; ?>
            @include('evaluation::partials.labs.input_field')
        </td>
    </tr>
    @endforeach
    <tr>
        <td colspan="2">
            @include('evaluation::partials.labs.comment')
        </td>
    </tr>
</table>