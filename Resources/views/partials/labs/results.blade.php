<?php
/*
 * =============================================================================
 *
 * Collabmed Solutions Ltd
 * Project: Collabmed Health Platform
 * Author: Samuel Okoth <sodhiambo@collabmed.com>
 *
 * =============================================================================
 */
$patient = $data['visit']->patients;
$dob = \Carbon\Carbon::parse($patient->dob);
$age_days = $dob->diffInDays();
$age_years = $dob->age;
?>
<div class="row" id="stripper">
    @foreach($results as $item)
    <div class="col-md-12">
        <h4>Laboratory test #{{$loop->iteration}}: {{$item->procedures->name}}</h4>
        <div class="col-md-4">
            <table class="table table-condensed table-striped">
                <tr>
                    <td><strong>Procedure:</strong></td>
                    <td>{{$item->procedures->name}}</td>
                </tr>
                <tr>
                    <td><strong>Requested By:</strong></td>
                    <td>{{$item->doctors->profile->full_name}}</td>
                </tr>
                <tr>
                    <td><strong>Instructions:</strong></td>
                    <td>{{$item->instructions ?? 'Not provided'}}</td>
                </tr>
                <tr>
                    <td><strong>Charges:</strong></td>
                    <td>{{$item->pesa}}</td>
                </tr>
                <tr>
                    <td><strong>Date:</strong></td>
                    <td>{{smart_date_time($item->created_at)}}</td>
                </tr>
                <tr>
                    <td><strong>Result Date:</strong></td>
                    <td>{{smart_date_time($item->results->create_at)}}</td>
                </tr>
                @if(isset($item->visits->requesting_institutions->name))
                <tr>
                    <td><strong>Requesting Institution:</strong></td>
                    <td>{{$item->visits->requesting_institutions->name}}</td>
                </tr>
                @endif
            </table>
        </div>
        <div class="col-md-8">
            <h4>Test Results</h4>
            <div class="well well-sm">
                <table class="table table-condensed table-striped">
                    <tr>
                        <th>Test</th>
                        <th>Result</th>
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
            </div>
            <a target="blank" href="{{route('evaluation.print.print_lab.one', $item->id)}}">
                Print<span class="badge alert-success"></span></a>
            @if($item->results->documents)
            Uploaded File -
            <a href="{{route('reception.view_document',$item->results->documents->id)}}" target="_blank">
                <i class="fa fa-file"></i> {{$item->results->documents->filename}}</a>
            @else
            <p class="text-warning"><i class="fa fa-warning"></i> No file uploaded</p>
            @endif
        </div>
    </div>
    <hr/>
    @endforeach
</div>
<style>
    #striper > div:nth-of-type(odd) {
        background: #e0e0e0;
    }
</style>