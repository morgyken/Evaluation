<?php
$patient = $data['visit']->patients;
$dob = \Carbon\Carbon::parse($patient->dob);
$age_days = $dob->diffInDays();
$age_years = $dob->age;
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
    @if(is_array($results))<!-- Check if results is an array -->
    @foreach ($results as $r)
    @if($r[1]!=='')
    <?php
    $p = Ignite\Evaluation\Entities\Procedures::find($r[0]);
    if ($p->this_test) {
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
            <td style="text-align:center">
                @if(isset($min_range) && isset($max_range))
                @if($r[1]<$min_range)
                <span style="color: greenyellow;">L</span>
                @elseif($r[1]>$max_range)
                <span style="color: red;">H</span>
                @else
                <span style="color: green;">N</span>
                @endif
                @endif
            </td>
            <td>{{$min_range}} - {{$max_range}}</td>
        </tr>
    <?php } else {
        ?>
        <tr>
            <td>{{$p->name}}</td>
            <td>{{ strip_tags($r[1])}}</td>
            <td>N/A</td>
            <td style="text-align:center">N/A</td>
            <td>N/A</td>
        </tr>
    <?php } ?>
    @endif
    @endforeach
    @else <!-- Just display it if it is not an array -->


    <tr>
        <td>{{$item->procedures->name}}</td>
        <td>{{ strip_tags($item->results->results)}}</td>
        <td>N/A</td>
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