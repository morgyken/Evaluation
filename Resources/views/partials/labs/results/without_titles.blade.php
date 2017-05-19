<?php
$tests = get_lab_template($item->procedures->id);
?>
@if(isset($tests))
@foreach($tests as $test)
<?php
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
@endforeach
@else

<tr>
    <td colspan="5">Subtest(s) may have been deleted at templating, please revert this test</td>
</tr>
@endif