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
try {
    if (get_result($test_res, $test->subtests) !== '') {
        $u = getUnit($test->subtests);
       // $interval = null;
        $range = get_ref_range($test->subtests);
        $critical = is_critical($test,$test_res);
        $interval = get_ref_interval($range);
        ?>
        <tr>
            <td>{{$test->subtests->name}}</td>
            <td>
                @if($test->subtests->sensitivity)
                    @include('evaluation::partials.labs.results.sensitivity')
                @else
                {{get_result($test_res,$test->subtests)}}
                @endif
            </td>
                <td><?php echo $u ?></td>
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
} catch (\Exception $e) {

}
?>
@endforeach