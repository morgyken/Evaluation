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
                        <th style="text-align:center"><i class="fa fa-flag"></i> Flag</th>
                        <th>Ref Range</th>
                    </tr>
                    <?php
                    $results = json_decode($item->results->results);
                    ?>
                    @if(is_array($results))
                    <!-- Check if result is array -->
                    <?php
                    // try {//For procedures with titles
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
                                            {{$min_range}} - {{$max_range}}
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
                            @foreach ($results as $___r)
                            @if($___r[1]!=='')
                            <?php
                            $p = Ignite\Evaluation\Entities\Procedures::find($___r[0]);
                            if ($p->this_test) {
                                ?>
                                <?php
                                $min_range = get_min_range($p, $age_days, $age_years);
                                $max_range = get_max_range($p, $age_days, $age_years);
                                ?>
                                <tr>
                                    <td>{{$p->name}}</td>
                                    <td>{{$___r[1]}}</td>
                                    <td><?php echo getUnit($p) ?></td>
                                    <td style="text-align:center">
                                        @if(isset($min_range) && isset($max_range))
                                        <?php echo getFlag($___r[1], $min_range, $max_range) ?>
                                        @endif
                                    </td>
                                    <td>
                                        @if(isset($min_range) && isset($max_range))
                                        {{$min_range}} - {{$max_range}}
                                        @endif
                                    </td>
                                </tr>
                                <?php
                            } else {
                                ?>
                                <tr>
                                    <td>{{$p->name}}</td>
                                    <td>{{ strip_tags($___r[1])}}</td>
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
                            <td>{{$item->procedures->name}}</td>
                            <td>
                                <?php
                                $r_ = GuzzleHttp\json_decode($item->results->results);
                                echo strip_tags($r_[0][1]);
                                ?>
                            </td>
                            <td>
                                @if(strpos($item->procedures->name, '%'))
                                %
                                @endif
                            </td>
                            <td style="text-align:center"> - </td>
                            <td> - </td>
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
                    //  } catch (\Exception $e) {
                    //catch and sip your coffee
                    //  }#end of try catch for procedure with titles
                    ?>
                    @else <!-- Just Display it if it is not an array -->
                    <tr>
                        <td>{{$item->procedures->name}}</td>
                        <td>{{ strip_tags($item->results->results)}}</td>
                        <td>
                            @if(strpos($item->procedures->name, '%'))
                            %
                            @endif
                        </td>
                        <td style="text-align:center"> - </td>
                        <td> - </td>
                    </tr>
                    <!--End of  is_array If Statement -->
                    <tr>
                        <td><strong>Comments:</strong></td>
                        <td colspan="4">
                            {{$item->results->comments ?? 'Not provided'}}
                        </td>
                    </tr>
                    @endif
                </table>
            </div>
            <!--Action Pane -->
            @if($item->results->status==0) <!--pending -->
            <a class="btn btn-primary btn-xs" href="{{route('evaluation.lab.verify', $item->results->id)}}">
                Verify<i class="fa fa-send"></i>
            </a>
            <a title="Note this will delete these results and revert back to test phase" class="btn btn-danger btn-xs" href="{{route('evaluation.lab.revert', $item->results->id)}}">
                Revert<i class="fa fa-trash"></i>
            </a>
            @elseif($item->results->status==1)<!--verified -->
            <a class="btn btn-success btn-xs" href="{{route('evaluation.lab.publish', $item->results->id)}}">
                Accept and Publish <i class="fa fa-send"></i>
            </a>
            @elseif($item->results->status==2)<!--accepted and published -->
            <span class="btn btn-success btn-xs">
                <i class="fa fa-check"></i>Published
            </span>
            <a class="btn btn-info btn-xs" target="blank" href="{{route('evaluation.print.print_lab.one', ['id'=>$item->id,'visit'=>$data['visit']->id])}}">
                Print<i class="fa fa-print"></i>
            </a>
            <a class="btn btn-warning btn-xs" href="{{route('evaluation.lab.send', $item->results->id)}}">
                Send <i class="fa fa-send"></i>
            </a>
            @elseif($item->results->status==3)<!--sent -->
            <span class="btn btn-success btn-xs">
                <i class="fa fa-send"></i>Sent
            </span>
            <a class="btn btn-info btn-xs" target="blank" href="{{route('evaluation.print.print_lab.one', ['id'=>$item->id,'visit'=>$data['visit']->id])}}">
                Print<i class="fa fa-print"></i>
            </a>
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