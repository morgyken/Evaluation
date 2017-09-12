<?php
/**
 * Created by PhpStorm.
 * User: bravo
 * Date: 7/25/17
 * Time: 3:20 PM
 */
$tests = get_lab_template($item->procedures->id);
$t_array = array();
?>
<table class="table table-condensed table-striped">
    <tr>
        @foreach($tests as $test)
            <?php
            $t_array[] = $test->subtests->id;
            ?>
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
                    {{--<input type="text"  name="test{{$item->id}}[]" value="{{$test->subtests->id}}" />--}}
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
    <input type="hidden"  name="tests{{$item->id}}" value="{{json_encode($t_array)}}" />
    <td colspan="2">
        @include('evaluation::partials.labs.comment')
    </td>
    </tr>
</table>
