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
    <td style="color:black; font-weight: bolder" colspan="5">{{$header->name}}</td>
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
        $interval = get_ref_interval($range);
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

@if(with_and_without_headers($other_tests,$with_headers))
<tr style="background-color: #eee">
        <th style="color:black; font-weight: bolder" colspan="5"><hr/></th>
</tr>
@foreach($other_tests as $othertest)
    <?php
    try {
    if (get_result($test_res, $othertest->subtests) !== '') {
    $u = getUnit($othertest->subtests);
    $range = get_ref_range($test->subtests);
    $critical = is_critical($test,$test_res);
    $interval = get_ref_interval($range);
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
    </tr>
    <?php
    }
    } catch (\Exception $e) {

    }
    ?>
@endforeach
@endif


