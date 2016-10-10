<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$history = patient_visits($visit->patient);
?>
<div class="row">
    <div class="col-md-12">
        <div class="accordion">
            @foreach($history as $_visit)
            <h3>{{(new Date($_visit->created_at))->format('dS M y')}} <span
                    class="pull-right">{{$_visit->clinics->name}}</span></h3>
            <div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="box box-default">
                            <div class="box-header">
                                <h3 class="box-title">Doctor's Notes</h3>
                            </div>
                            <div class="box-body">
                                @if(!empty($_visit->notes))
                                <p><strong>Presenting Complaints</strong><br/>
                                    {{$_visit->notes->presenting_complaints}}</p>
                                <p><strong>Past Medical History</strong><br/>
                                    {{$_visit->notes->past_medical_history}}</p>
                                <p><strong>Examination</strong><br/>
                                    {{$_visit->notes->examination}}</p>
                                <p><strong>Diagnosis</strong><br/>
                                    {{implode(', ',unserialize($_visit->notes->diagnosis))}}</p>
                                <p><strong>Treatment Plan</strong><br/>
                                    {{$_visit->notes->treatment_plan}}</p>
                                @else
                                <p class="text-warning"><i class="fa fa-info-circle"></i> Notes not available
                                </p>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="box box-default">
                            <div class="box-header">
                                <h3 class="box-title">Treatment</h3>
                            </div>
                            <div class="box-body">
                                @if(!empty($_visit->treatments) && !$_visit->treatments->isEmpty())
                                <table class="table table-condensed">
                                    <thead>
                                        <tr>
                                            <th>Procedure</th>
                                            <th>Cost</th>
                                            <th>No.</th>
                                            <th>Payment</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($_visit->treatments as $item)
                                        <tr>
                                            <td>{{str_limit($item->procedures->name,20,'...')}}</td>
                                            <td>{{$item->price}}</td>
                                            <td>{{$item->no_performed}}</td>
                                            <td>{{$item->is_paid?'Paid':'Not Paid'}}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                @else
                                <p class="text-warning"><i class="fa fa-info-circle"></i> No treatment records
                                    available</p>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="box box-default">
                            <div class="box-header">
                                <h3 class="box-title">OP Notes</h3>
                            </div>
                            <div class="box-body">
                                @if(!empty($_visit->opnotes))
                                <p><strong>Surgery Indications</strong><br/>
                                    {{$_visit->opnotes->surgery_indication}}</p>
                                <p><strong>Implants</strong><br/>
                                    {{$_visit->opnotes->implants}}</p>
                                <p><strong>Post OP</strong><br/>
                                    {{$_visit->opnotes->postop}}</p>
                                <p><strong>Indication + procedure</strong><br/>
                                    {{$_visit->opnotes->indication}}</p>
                                @else
                                <p><i class="fa fa-info-circle"></i> No records</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="box box-success">
                            <div class="box-header">
                                <h3 class="box-title">Vitals</h3>
                            </div>
                            <div class="box-body">
                                @if(!empty($_visit->vitals))
                                <dl class="dl-horizontal">
                                    <dt>Weight</dt><dd>{{$_visit->vitals->weight }}</dd>
                                    <dt>Height</dt><dd>{{$_visit->vitals->height}}</dd>
                                </dl>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="box box-success">
                            <div class="box-header">
                                <h3 class="box-title">Diagnosis</h3>
                            </div>
                            <div class="box-body">

                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="box box-success">
                            <div class="box-header">
                                <h3 class="box-title">Lab tests</h3>
                            </div>
                            <div class="box-body">

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        $('.accordion').accordion({heightStyle: "content"});
    });
</script>