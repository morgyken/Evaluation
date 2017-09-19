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
$calculated = array();
$with_headers = array();
$other_tests = get_lab_template($item->procedures->id);
foreach ($loaded as $l) {
    if (!empty($l->header)) {
        $headers[] = $l->header;
    }
}
?>
@foreach(array_unique($headers) as $header)
<?php
$tests = get_title_procedures($item->procedures->id, $header->id);
?>
@if(count($tests)>0)
<tr>
    @if(contains_strings($test_res))
        <td style="color:black; font-weight: bolder" colspan="2">{{$header->name}}</td>
    @else
        <td style="color:black; font-weight: bolder" colspan="5">{{$header->name}}</td>
    @endif
</tr>
@endif
@foreach($tests as $test)
<?php
$with_headers[] = $test->subtests->id;
try {
    if (get_result($test_res, $test->subtests) !== '') {
        $u = getUnit($test->subtests);
        $interval = null;
        $range = get_ref_range($test->subtests);
        $critical = is_critical($test,$test_res);

        try {
            if ($range->type =='range') {
                $min_range = $range->lower;
                $max_range = $range->upper;
                $interval = $range->lower . ' - ' . $range->upper;
            } else {
                $interval = $range->lg_type . ' ' . $range->lg_value;
            }
        } catch (\Exception $e) {
            $interval = null;
        }
        ?>
        <tr>
            <td>{{strtoupper($test->subtests->name)}}</td>
            <td>
                @if($test->subtests->sensitivity)
                    @include('evaluation::partials.labs.results.sensitivity')
                @else
                    {{get_result($test_res,$test->subtests)}}
                @endif
            </td>
            @if(contains_strings($test_res) || $test->subtests->sensitivity)
            @else
            <td><?php echo str_replace(' ', '', $u) ?></td>
            <td style="text-align: center">
                @if(!$critical)
                    @if(!is_null($interval))
                    <?php echo getFlag($test_res[$test->subtest], $range) ?>
                    @endif
                @else
                    <p>C<p>
                @endif
            </td>
            <td>
            {{$interval}}
            </td>
            @endif
        </tr>
        <?php
    }
    ?>
    <?php
} catch (\Exception $e) {

}
?>
@endforeach
@endforeach


<tr style="background-color: #eee">
    @if(contains_strings($test_res))
        <th style="color:black; font-weight: bolder" colspan="2"><hr/></th>
    @else
        <th style="color:black; font-weight: bolder" colspan="5"><hr/></th>
    @endif
</tr>
@foreach($other_tests as $othertest)
    <?php
    try {
    if (get_result($test_res, $othertest->subtests) !== '') {
    $u = getUnit($othertest->subtests);
    // $interval = null;
    try {
        $range = get_ref_range($othertest->subtests);
        $critical = is_critical($othertest,$test_res);
        if (isset($range->lower) && isset($range->upper)) {
            $min_range = $range->lower;
            $max_range = $range->upper;
            $interval = $range->lower . ' - ' . $range->upper;
        } else {
            $interval = $range->lg_type . ' ' . $range->lg_value;
        }
    } catch (\Exception $e) {
        $interval = null;
    }
    ?>
    <tr>
        <td>{{$othertest->subtests->name}}</td>
        <td>
            @if($othertest->subtests->sensitivity)
                @include('evaluation::partials.labs.results.sensitivity')
            @else
                {{get_result($test_res,$othertest->subtests)}}
            @endif
        </td>
        @if(contains_strings($test_res)||$othertest->subtests->sensitivity)
        @else
            <td><?php echo $u ?></td>
            <td style="text-align: center">
                @if(!$critical)
                    @if(!is_null($interval))
                        <?php echo getFlag($test_res[$othertest->subtest], $range) ?>
                    @endif
                @else
                    <p>C<p>
                @endif
            </td>
            <td>
                {{$interval}}
            </td>
        @endif
    </tr>
    <?php
    }
    } catch (\Exception $e) {

    }
    ?>
@endforeach


