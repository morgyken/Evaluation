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
foreach ($loaded as $l){
    if (!empty($l->header)){
        $headers[] = $l->header;
    }
}
?>
        @foreach(array_unique($headers) as $header)
        <tr>
            <th style="color:black; font-weight: bolder" colspan="5">{{$header->name}}</th>
        </tr>
        <?php
        $tests = get_title_procedures($item->procedures->id, $header->id);
        ?>
            @foreach($tests as $test)
            <?php
            try{
           if ($test_res[$test->subtest] !== '') {
                $u = getUnit($test->subtests);
                $min_range = get_min_range($test->subtests, $age_days, $age_years);
                $max_range = get_max_range($test->subtests, $age_days, $age_years);

             ?>
            <tr>
                <td>{{$test->subtests->name}}</td>
                <td>
                    {{$test_res[$test->subtest]}}
                </td>
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
            ?>
            <?php
            }catch (\Exception $e){

            }
            ?>
            @endforeach
        @endforeach
