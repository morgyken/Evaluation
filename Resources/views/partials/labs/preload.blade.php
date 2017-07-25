<?php
/**
 * Created by PhpStorm.
 * User: bravo
 * Date: 7/23/17
 * Time: 9:56 AM
 */
//$titles = get_titles_for_procedure($item->procedures->id);
$loaded = get_lab_template($item->procedures->id);
$headers = array();
foreach ($loaded as $l){
    if (!null){
        $headers[] = $l->header;
    }
}
?>
<table class="table table-condensed table-striped">
    <tr>
        @foreach(array_unique($headers) as $header)
        <tr>
            <th colspan="2">{{$header->name}}</th>
        </tr>
        <?php $tests = get_title_procedures($item->procedures->id, $header->id); ?>
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
                    ?>
                    @include('evaluation::partials.labs.input_field')
                </td>
            </tr>
            @endforeach
        @endforeach
        <td colspan="2">
            @include('evaluation::partials.labs.comment')
        </td>
    </tr>
</table>
