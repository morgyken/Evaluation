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
                                        <p><strong>Investigations History</strong><br/>
                                            {{$_visit->notes->investigations}}</p>
                                        <p><strong>Diagnosis</strong><br/>
                                            {{$_visit->notes->diagnosis}}</p>
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
                                    <h3 class="box-title">Prescriptions</h3>
                                </div>
                                <div class="box-body">
                                    @if(!empty($_visit->prescriptions) && !$_visit->prescriptions->isEmpty())
                                        <table class="table table-condensed">
                                            <thead>
                                            <tr>
                                                <th>Drug</th>
                                                <th>Dose</th>
                                                <th>Duration</th>
                                                <th>Date</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($_visit->prescriptions as $item)
                                                <tr>
                                                    <td>{{$item->drug}}</td>
                                                    <td>{{$item->dose}}</td>
                                                    <td>{{$item->duration}}</td>
                                                    <td>{{smart_date($item->created_at)}}</td>
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
                        <!--
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
-->
                            <div class="box box-success">
                                <div class="box-header">
                                    <h3 class="box-title">Vitals</h3>
                                </div>
                                <div class="box-body">
                                    @if(!empty($_visit->vitals))
                                        <dl class="dl-horizontal">
                                            <dt>Weight</dt>
                                            <dd>{{$_visit->vitals->weight }}</dd>
                                            <dt>Height</dt>
                                            <dd>{{$_visit->vitals->height}}</dd>
                                        </dl>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="box box-success">
                                <div class="box-header">
                                    <h3 class="box-title">Treatment</h3>
                                </div>
                                <div class="box-body">
                                    <table class="table table-condensed">
                                        <thead>
                                        <tr>
                                            <th>Procedure</th>
                                            <th>Cost</th>
                                            <th>Payment</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php try { ?>
                                        @foreach($_visit->investigations->where('type','treatment') as $item)
                                            <tr>
                                                <td>{{str_limit($item->procedures->name,20,'...')}}</td>
                                                <td>{{$item->price}}</td>
                                                <td>{!! payment_label($item->is_paid) !!}</td>
                                            </tr>
                                        @endforeach
                                        <?php
                                        } catch (Exception $ex) {

                                        }
                                        ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="box box-success">
                                <div class="box-header">
                                    <h3 class="box-title">Diagnosis</h3>
                                </div>
                                <div class="box-body">
                                    <table class="table table-condensed">
                                        <thead>
                                        <tr>
                                            <th>Procedure</th>
                                            <th>Cost</th>
                                            <th>Payment</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php try { ?>
                                        @foreach($_visit->investigations->where('type','diagnosis') as $item)
                                            <tr>
                                                <td>{{str_limit($item->procedures->name,20,'...')}}</td>
                                                <td>{{$item->price}}</td>
                                                <td>{!! payment_label($item->is_paid) !!}</td>
                                            </tr>
                                        @endforeach
                                        <?php
                                        } catch (Exception $ex) {

                                        }
                                        ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="box box-success">
                                <div class="box-header">
                                    <h3 class="box-title">Laboratory</h3>
                                </div>
                                <div class="box-body">
                                    <table class="table table-condensed">
                                        <thead>
                                        <tr>
                                            <th>Procedure</th>
                                            <th>Cost</th>
                                            <th>Payment</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($_visit->investigations->where('type','laboratory') as $item)
                                            <tr>
                                                <td>{{str_limit($item->procedures->name,20,'...')}}</td>
                                                <td>{{$item->price}}</td>
                                                <td>{!! payment_label($item->is_paid) !!}</td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        {!! Form::open(['id'=>'sickoff','route' => 'evaluation.print.patient_notes_specific','target'=>"_blank"])!!}
                        <input type="hidden" name="patient" value="{{$visit->patient}}"/>
                        <input type="hidden" name="visit" value="{{$_visit->id}}"/>
                        <div class="pull-right">
                            <button type="submit" class="btn btn-primary"><i class="fa fa-file-word-o"></i> Print
                            </button>
                        </div>
                        {!! Form::close()!!}

                        {!! Form::open(['id'=>'sickoff','route' => 'evaluation.print.to_word_specific','target'=>"_blank"])!!}
                        <input type="hidden" name="patient" value="{{$visit->patient}}"/>
                        <input type="hidden" name="visit" value="{{$_visit->id}}"/>
                        <div class="pull-right">
                            <button type="submit" class="btn btn-primary"><i class="fa fa-file-word-o"></i> Save to Word
                            </button>
                        </div>
                        {!! Form::close()!!}
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