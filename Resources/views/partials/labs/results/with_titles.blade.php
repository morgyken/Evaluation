<?php $titles = get_titles_for_procedure($item->procedures->id); ?>
@foreach($titles as $title)
<?php
$tests = get_title_procedures($item->procedures->id, $title->id);
?>
<tr>
    <th colspan="5" style="background:#9999CC">{{$title->name}}({{$tests->count()}})</th>
</tr>
@foreach($tests as $test)
<?php
try {
    if ($test_res[$test->subtest] !== '') {
        $u = getUnit($test->subtests);
        $min_range = get_min_range($test->subtests, $age_days, $age_years);
        $max_range = get_max_range($test->subtests, $age_days, $age_years);
        ?>
        <tr>
            <td>{{$test->subtests->name}}</td>
            <td>{{$test_res[$test->subtest]}}</td>
            <td><?php echo $u ?></td>
            <td>
                @if(isset($min_range) && isset($max_range))
                <?php echo getFlag($test_res[$test->subtest], $min_range, $max_range) ?>
                @endif
            </td>
            <td>
                @if(isset($min_range) && isset($max_range))
                {{$min_range}} - {{$max_range}}
                @endif
            </td>
        </tr>
        <?php
    }
} catch (\Exception $e) {

}
?>
@endforeach
@endforeach