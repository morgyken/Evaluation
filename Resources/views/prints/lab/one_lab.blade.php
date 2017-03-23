<?php
$item = $data['results']; //->investigations->where('type', 'laboratory')->where('has_result', true);
?>
@include('evaluation::prints.partials.head')
<table border='1'>
    <tr>
        <td>
            <strong>Patient:</strong>{{$item->visits->patients->full_name}}<br>
            <strong>Age:</strong>{{$item->visits->patients->age}}<br>
            <strong>Sex:</strong> {{$item->visits->patients->sex}}<br>
        </td>
        <td colspan="4">
            <strong>Clinic:</strong>
            {{$item->visits->clinics->name}}<br>
            <strong>Doctor:</strong>
            {{$item->doctors->profile->full_name}}<br>
            <strong>Lab Tech:</strong>
            {{$item->results->users->profile->full_name}}<br>
            <strong>Date:</strong>
            {{smart_date_time($item->results->create_at)}}
        </td>
    </tr>
    <tr>
        <th>Test</th>
        <th>Results</th>
        <th>Units</th>
        <th>Flag</th>
        <th>Ref Range</th>
    </tr>
    <?php
    $results = json_decode($item->results->results);
    ?>
    @foreach ($results as $r)
    @if($r[1]!=='')
    <?php
    $p = Ignite\Evaluation\Entities\Procedures::find($r[0]);
    $min_range = $max_range = null;
    try {
        if ($age_days < 4) {
            $min_range = $p->this_test->_0_3d_minrange;
            $max_range = $p->this_test->_0_3d_maxrange;
        } elseif ($age_days >= 4 && $age_days <= 30) {
            $min_range = $p->this_test->_4_30d_minrange;
            $max_range = $p->this_test->_4_30d_maxrange;
        } elseif ($age_days > 30 && $age_days <= 730) {
            $min_range = $p->this_test->_1_24m_minrange;
            $max_range = $p->this_test->_1_24m_maxrange;
        } elseif ($age_days > 730 && $age_days <= 1825) {
            $min_range = $p->this_test->_25_60m_minrange;
            $max_range = $p->this_test->_25_60m_maxrange;
        } else {
            if ($age_years > 4 && $age_years <= 19) {
                $min_range = $p->this_test->_5_19y_minrange;
                $max_range = $p->this_test->_5_19y_maxrange;
            } else {
                $min_range = $p->this_test->adult_minrange;
                $max_range = $p->this_test->adult_maxrange;
            }
        }
    } catch (\Exception $e) {
        $min_range = $p->this_test->lab_min_range;
        $max_range = $p->this_test->lab_max_range;
    }
    ?>
    <tr>
        <td>{{$p->name}}</td>
        <td>{{$r[1]}}</td>
        <td></td>
        <td>
            @if(isset($min_range) && isset($max_range))
            @if($r[1]<$min_range)
            <span style="color: greenyellow;"><i class="fa fa-flag"></i></span>Low
            @elseif($r[1]>$max_range)
            <span style="color: red;"><i class="fa fa-flag"></i></span>High
            @else
            <span style="color: green;"><i class="fa fa-flag"></i></span>Normal
            @endif
            @endif
        </td>
        <td>{{$min_range}} - {{$max_range}}</td>
    </tr>
    @endif
    @endforeach
</table>
@include('evaluation::prints.partials.footer')