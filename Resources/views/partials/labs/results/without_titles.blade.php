<?php
$tests = get_lab_template($item->procedures->id);
?>
@if(isset($tests))
@foreach($tests as $test)
<?php
$u = getUnit($test->subtests);

$patient = $data['visit']->patients;
$dob = \Carbon\Carbon::parse($patient->dob);
$age_days = $dob->diffInDays();
$age_str = (new Date($dob))->diff(Carbon\Carbon::now())->format('%y years, %m months and %d days');
$age_years = $dob->age;

$min_range = get_min_range($test->subtests, $age_days, $age_years);
$max_range = get_max_range($test->subtests, $age_days, $age_years);
if(array_key_exists($test->subtest, $test_res)){
if (!empty($test_res[$test->subtest])){
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
} ?>
@endforeach
@else
<tr>
    <td colspan="5">Subtest(s) may have been deleted at templating, please revert this test</td>
</tr>
@endif