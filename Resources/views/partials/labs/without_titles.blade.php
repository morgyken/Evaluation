<table class="table table-condensed table-striped">
    <?php
    $tests = get_lab_template($item->procedures->id);
    ?>
    @if(isset($tests))
    @foreach($tests as $test)
    <tr>
        <td>
            {{$test->subtests->name}}
            <input type="hidden" name="item{{$item->id}}" value="{{$item->id}}" />
            <input type="hidden" name="test{{$item->id}}[]" value="{{$test->subtest}}" />
        </td>
        <td>
            <?php
            $type = $test->subtests->this_test->lab_result_type;
            $_options = $test->subtests->this_test->lab_result_options;
            ?>
            @include('evaluation::partials.labs.input_field')<br/>
            {{get_formula($test->subtests->id)}}
        </td>
    </tr>
    @endforeach
    <tr>
        <td colspan="2">
            @include('evaluation::partials.labs.comment')
        </td>
    </tr>
    @endif
</table>