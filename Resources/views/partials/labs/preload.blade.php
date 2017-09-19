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
$t_array = array();
$with_headers = array();
foreach ($loaded as $l){
    if (!empty($l->header)){
        $headers[] = $l->header;
    }
}
$other_tests = get_lab_template($item->procedures->id);
?>
<table class="table table-condensed table-striped">
    <tr>
        @foreach(array_unique($headers) as $header)
        <tr>
            <th colspan="2">{{$header->name}}</th>
        </tr>
        <?php $tests = get_title_procedures($item->procedures->id, $header->id); ?>
            @foreach($tests as $test)
            <?php
            $t_array[] = $test->subtests->id;
            $with_headers[] = $test->subtests->id;
            ?>
            @if($test->subtests->sensitivity)
            <?php $s_item =$test->subtests; ?>
                @include('evaluation::partials.labs.sensitivity')
            @else
                    <tr>
                        <td>
                            {{strtoupper($test->subtests->name)}}
                            <input type="hidden" name="item{{$item->id}}" value="{{$item->id}}" />
                            <input type="hidden" name="test{{$item->id}}[]" value="{{$test->subtest}}" />
                        </td>
                        <td>
                            <?php
                                try{
                                    $type = $test->subtests->this_test->lab_result_type;
                                }catch (\Exception $e){

                                }
                            ?>
                            @include('evaluation::partials.labs.input_field')
                        </td>
                    </tr>
            @endif
            @endforeach
        @endforeach
    <tr>
        <th colspan="2">-</th>
    </tr>
    @foreach($other_tests as $_test)
        @if(!in_array($_test->subtests->id,$with_headers))
            <?php $t_array[] = $_test->subtests->id; ?>
            @if($_test->subtests->sensitivity)
                <?php
                $s_item =$_test->subtests;
                ?>
                @include('evaluation::partials.labs.sensitivity')
             @else
            <tr>
                <td>
                    {{$_test->subtests->name}}
                    <input type="hidden" name="item{{$item->id}}" value="{{$item->id}}" />
                </td>
                <td>
                    <?php
                    if(!empty($_test->subtests->this_test)){
                        $type = $_test->subtests->this_test->lab_result_type;
                    }else{
                        $type = null;
                    }
                    ?>
                    @include('evaluation::partials.labs.input_field')
                </td>
            </tr>
            @endif
        @endif
    @endforeach

        <input type="hidden"  name="tests{{$item->id}}" value="{{json_encode($t_array)}}" />
        <td colspan="2">
            @include('evaluation::partials.labs.comment')
        </td>
    </tr>
</table>
