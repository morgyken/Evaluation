<?php
/**
 * Created by PhpStorm.
 * User: bravo
 * Date: 7/23/17
 * Time: 9:56 AM
 */
$tests = get_lab_template($item->procedures->id);
?>
@foreach($tests as $test)
    <?php
     try{
    if ($test_res[$test->subtest] !== '') {
        $u = getUnit($test->subtests);

        $interval = null;
        try {
            $range = get_ref_range($test->subtests);
            if (isset($range->lower) && isset($range->upper)){
                $min_range = $range->lower;
                $max_range = $range->upper;
                $interval = $range->lower.' - '.$range->upper;
            }else{
                $interval = $range->lg_type.' '.$range->lg_value;
            }
        } catch (\Exception $e) {
            //$interval = null;
        }
        ?>
        <tr>
            <td>{{$test->subtests->name}}</td>
            <td @if(strlen(strip_tags($test_res[$test->subtest]))>100)style="width: 60%"@endif>
                {{strip_tags($test_res[$test->subtest])}}
            </td>
            <td><?php echo $u ?></td>
            <td style="text-align: center">
                @if(!is_null($interval))
                    <?php echo getFlag($test_res[$test->subtest], $min_range, $max_range) ?>
                @endif
            </td>
            <td>
                {{$interval}}
            </td>
        </tr>
    <?php
    }
    }catch(\Exception $e){

    }
    ?>
@endforeach