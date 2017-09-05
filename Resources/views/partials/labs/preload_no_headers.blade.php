<?php
/**
 * Created by PhpStorm.
 * User: bravo
 * Date: 7/25/17
 * Time: 3:20 PM
 */
$tests = get_lab_template($item->procedures->id);
?>
<table class="table table-condensed table-striped">
    <tr>
        @foreach($tests as $test)
        @if($test->subtests->sensitivity)
            <?php
            $s_item =$test->subtests;
            ?>
            @include('evaluation::partials.labs.sensitivity')
        @else
            <tr>
                <td>
                    {{$test->subtests->name}}
                    <input type="hidden" name="item{{$item->id}}" value="{{$item->id}}" />
                    <input type="hidden" name="test{{$item->id}}[]" value="{{$test->subtest}}" />
                </td>
                <td>
                    <?php
                    if(!empty($test->subtests->this_test)){
                        $type = $test->subtests->this_test->lab_result_type;
                    }else{
                        $type = null;
                    }
                    ?>
                    @include('evaluation::partials.labs.input_field')
                </td>
            </tr>
        @endif
        @endforeach
    <td colspan="2">
        @include('evaluation::partials.labs.comment')
    </td>
    </tr>
</table>
