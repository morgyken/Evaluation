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
foreach ($loaded as $l) {
    if (!empty($l->header)) {
        $headers[] = $l->header;
    }
}
?>
@foreach(array_unique($headers) as $header)
<tr>
    @if(contains_strings($test_res))
        <td style="color:black; font-weight: bolder" colspan="2">{{$header->name}}</td>
    @else
        <td style="color:black; font-weight: bolder" colspan="5">{{$header->name}}</td>
    @endif
</tr>
<?php
$tests = get_title_procedures($item->procedures->id, $header->id);
?>
@foreach($tests as $test)
<?php
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
            <td @if(strlen(strip_tags($test_res[$test->subtest]))>100)style="width: 60%"@endif>
                 {{get_result($test_res,$test->subtests)}}
        </td>
        @if(contains_strings($test_res))
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
