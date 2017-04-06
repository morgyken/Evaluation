<?php
$patient = $data['visit']->patients;
$dob = \Carbon\Carbon::parse($patient->dob);
$age_days = $dob->diffInDays();
$age_str = (new Date($dob))->diff(Carbon\Carbon::now())->format('%y years, %m months and %d days');
$age_years = $dob->age;
$item = $data['results']; //->investigations->where('type', 'laboratory')->where('has_result', true);
?>
@include('evaluation::prints.partials.head')
<table border='1'>
    <tr>
        <td>
            <strong>Patient:</strong>{{$item->visits->patients->full_name}}<br>
            <strong>Age:</strong>{{$age_str}}<br>
            <strong>Sex:</strong> {{$item->visits->patients->sex}}<br>
        </td>
        <td colspan="4">
            <strong>Clinic:</strong>
            {{$item->visits->clinics->name}}<br>
            <strong>Ordered By:</strong>
            {{$item->doctors->profile->full_name}}<br>
            <strong>Conducted By:</strong>
            {{$item->results->users->profile->full_name}}<br>
            <strong>Date:</strong>
            {{smart_date_time($item->results->create_at)}}<br>
            @if(isset($item->visits->external_doctors))
            <strong>Request From:</strong>
            {{$item->visits->external_doctors->profile->full_name}}<br>
            ({{$item->visits->external_doctors->profile->partnerInstitution->name}})
            @endif
        </td>
    </tr>
    <tr>
        <th>Test</th>
        <th>Results</th>
        <th>Units</th>
        <th style="text-align:center">Flag</th>
        <th>Ref Range</th>
    </tr>
    <?php
    $results = json_decode($item->results->results);
    ?>
    @if(is_array($results))<!-- Check if result is array -->
    <?php
    try {//For procedures with titles
        if ($item->procedures->this_test) {
            #if this procedure has a subprocedure
            $titles = json_decode($item->procedures->this_test->titles);
            if (isset($titles)) {#only if titles is not null
                foreach ($titles as $key => $value) {
                    $title = \Ignite\Evaluation\Entities\HaemogramTitle::find($value);
                    ?>
                    <tr>
                        <td style="background:#9999CC" colspan="5">
                            <strong>{{strtoupper($title->name)}}</strong>
                        </td>
                    </tr>
                    <?php
                    $all_tests = array();
                    $their_result = array();
                    foreach ($results as $_r) {
                        $all_tests[] = $_r[0];
                        $their_result[] = $_r[1];
                    }
                    $test_res = array_combine($all_tests, $their_result);
                    foreach ($title->tests as $_t) {
                        $u = getUnit($_t->_procedure);
                        $min_range = get_min_range($_t->_procedure, $age_days, $age_years);
                        $max_range = get_max_range($_t->_procedure, $age_days, $age_years);
                        ?>
                        <tr>
                            <td>{{$_t->_procedure->name}}</td>
                            <td>{{$test_res[$_t->procedure]}}</td>
                            <td><?php echo $u ?></td>
                            <td>
                                @if(isset($min_range) && isset($max_range))
                                <?php echo getFlag($test_res[$_t->procedure], $min_range, $max_range) ?>
                                @endif
                            </td>
                            <td>
                                @if(isset($min_range) && isset($max_range))
                                {{$min_range}}  {{$max_range}}
                                @endif
                            </td>
                        </tr>
                        <?php
                    }
                }
                ?>
                <?php
            } else {//This is a normal procedure without fucking titles
                ?>
                @foreach ($results as $r)
                @if($r[1]!=='')
                <?php
                $p = Ignite\Evaluation\Entities\Procedures::find($r[0]);
                if ($p->this_test) {
                    ?>
                    <?php
                    $min_range = get_min_range($p, $age_days, $age_years);
                    $max_range = get_max_range($p, $age_days, $age_years);
                    ?>
                    <tr>
                        <td>{{$p->name}}</td>
                        <td>{{$r[1]}}</td>
                        <td><?php echo getUnit($p) ?></td>
                        <td style="text-align:center">
                            @if(isset($min_range) && isset($max_range))
                            <?php echo getFlag($r[1], $min_range, $max_range) ?>
                            @endif
                        </td>
                        <td>
                            @if(isset($min_range) && isset($max_range))
                            {{$min_range}}  {{$max_range}}
                            @endif
                        </td>
                    </tr>
                    <?php
                } else {
                    ?>
                    <tr>
                        <td>{{$p->name}}</td>
                        <td>{{ strip_tags($r[1])}}</td>
                        <td>
                            @if(strpos($p->name, '%'))
                            %
                            @endif
                        </td>
                        <td style="text-align:center"></td>
                        <td> - </td>
                    </tr>
                    <?php
                }##end of else
                ?>
                @endif
                @endforeach
                <?php
            }# end of else
        } else {
            ?>
            <!-- Procedure does not have sub-procedure but result stored in json -->
            <tr>
                <td>{{ $item->procedures->name}}</td>
                <td colspan="3">
                    <?php
                    $r_ = GuzzleHttp\json_decode($item->results->results);
                    echo strip_tags($r_[0][1]);
                    ?>
                </td>
            </tr>
            <!--End of  is_array If Statement -->
            <tr>
                <td><strong>Comments:</strong></td>
                <td colspan="4">
                    {{$item->results->comments ?? 'Not provided'}}
                </td>
            </tr>

            <?php
        }#end of if this procedure has a subprocedure
    } catch (\Exception $e) {
        #catch and sip your coffee
    }#end of try catch for procedure with titles
    ?>
    @else <!-- Just display it if it is not an array -->
    <tr>
        <td>{{$item->procedures->name}}</td>
        <td>{{ strip_tags($item->results->results)}}</td>
        <td>
            @if(strpos($item->procedures->name, '%'))
            %
            @else
            -
            @endif
        </td>
        <td style="text-align:center">N/A</td>
        <td>N/A</td>
    </tr>
    @endif <!-- End of the is_array IF statement -->
    <tr>
        <td colspan="5">
            <strong>Comments:</strong>
            <p>{{$item->results->comments ?? 'Not provided'}}</p>
        </td>
    </tr>
</table>
@include('evaluation::prints.partials.footer')