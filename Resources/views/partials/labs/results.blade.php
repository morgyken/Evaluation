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
                    <td><strong>Conducted By:</strong></td>
                    <td>{{$item->doctors->profile->full_name}}</td>
                </tr>
                <tr>
                    <td><strong>Instructions:</strong></td>
                    <td>{{$item->results->instructions ?? 'Not provided'}}</td>
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
                @if(isset($item->visits->external_doctors))
                <tr>
                    <td><strong>Request By:</strong></td>
                    <td>
                        {{$item->visits->external_doctors?$item->visits->external_doctors->profile->full_name:''}}
                        ({{$item->visits->external_doctors?$item->visits->external_doctors->profile->partnerInstitution->name:''}})
                    </td>
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
                        <th style="text-align:center"><i class="fa fa-flag"></i>Flag</th>
                        <th>Ref Range</th>
                    </tr>
                    <?php
                    $results = json_decode($item->results->results);
                    ?>
                    @if(is_array($results))<!-- Check if result is array -->
                    @foreach ($results as $r)
                    @if($r[1]!=='')
                    <?php
                    $p = Ignite\Evaluation\Entities\Procedures::find($r[0]);
                    if ($p->this_test) {
                        ?>
                        <?php
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
                                <span style="color: greenyellow;"> L</span>
                                @elseif($r[1]>$max_range)
                                <span style="color: red;"> H</span>
                                @else
                                <span style="color: green;"> N</span>
                                @endif
                                @endif
                            </td>
                            <td>{{$min_range}} - {{$max_range}}</td>
                        </tr>
                        <?php
                    } else {
                        ?>
                        <tr>
                            <td>{{$p->name}}</td>
                            <td>{{ strip_tags($r[1])}}</td>
                            <td></td>
                            <td style="text-align:center"></td>
                            <td></td>
                        </tr>
                        <?php
                    }
                    ?>
                    @endif
                    @endforeach

                    @else <!-- Just Display it if it is not an array -->
                    <tr>
                        <td>{{$item->procedures->name}}</td>
                        <td>{{ strip_tags($item->results->results)}}</td>
                        <td></td>
                        <td style="text-align:center"></td>
                        <td></td>
                    </tr>
                    @endif <!--End of  is_array If Statement -->
                    <tr>
                        <td><strong>Comments:</strong></td>
                        <td colspan="4">
                            {{$item->results->comments ?? 'Not provided'}}
                        </td>
                    </tr>
                </table>
            </div>
            <!--Action Pane -->
            <a class="btn btn-info btn-xs" target="blank" href="{{route('evaluation.print.print_lab.one', ['id'=>$item->id,'visit'=>$data['visit']->id])}}">
                Print<i class="fa fa-print"></i>
            </a>

            @if($item->results->status==0)
            <a class="btn btn-primary btn-xs" href="{{route('evaluation.lab.approve_result', $item->results->id)}}">
                Verify and Publish<i class="fa fa-send"></i>
            </a>
            @else
            <span class="btn btn-success btn-xs">
                <i class="fa fa-check"></i>Published
            </span>
            @endif

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