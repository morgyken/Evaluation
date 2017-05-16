<?php $titles = get_titles_for_procedure($item->procedures->id); ?>
@foreach($titles as $title)
<tr>
    <th colspan="5" style="background:#9999CC">{{$title->name}}</th>
</tr>
<?php
$tests = get_title_procedures($item->procedures->id, $title->id);
?>
@foreach($tests as $test)
<?php try { ?>

    <?php
    if ($test_res[$_t->procedure] !== '') {
        ?>
        <?php
        $u = getUnit($test->subtests);
        $min_range = get_min_range($test->subtests, $age_days, $age_years);
        $max_range = get_max_range($test->subtests, $age_days, $age_years);
        ?>
        <tr>
            <td>{{$test->subtests->name}}</td>
            <td><?php print_r($test_res) ?></td>
            <td><?php echo $u ?></td>
            <td></td>
            <td></td>
        </tr>
    <?php } ?>

    <?php
} catch (\Exception $e) {

}
?>
@endforeach
@endforeach
<tr>
    <td colspan="2">
        Comments
    </td>
</tr>