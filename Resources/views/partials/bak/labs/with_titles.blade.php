<?php $titles = get_titles_for_procedure($item->procedures->id); ?>
<table class="table table-condensed table-striped">
    @foreach($titles as $title)
    <?php
    $tests = get_title_procedures($item->procedures->id, $title->id);
    ?>
    <tr>
        <th colspan="2" style="background:#9999CC">{{$title->name}} ({{$tests->count()}})</th>
    </tr>
    @foreach($tests as $test)
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
    @endforeach
    <tr>
        <td colspan="2">
            @include('evaluation::partials.labs.comment')
        </td>
    </tr>
</table>