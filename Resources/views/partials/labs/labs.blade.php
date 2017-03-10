<?php
/*
 * Collabmed Solutions Ltd
 * Project: iClinic
 *  Author: Samuel Okoth <sodhiambo@collabmed.com>
 */
$performed_diagnosis = get_investigations($visit, ['laboratory']);
?>
<div>
    <div class="row">
        <div class="col-md-12">
            <div class="col-md-8">
                <div class="accordion">
                    <h4>Lab Tests</h4>
                    <div class="investigation_item">
                        @include('evaluation::partials.labs._new')
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="row">
                    <div class="col-md-12" id="show_selection">
                        <div class="box box-primary">
                            <div class="box-header">
                                <h4 class="box-title">Selected procedures</h4>
                            </div>
                            <div class="box-body">
                                <div id="diagnosisTable">
                                    <table id="diagnosisInfo" class=" table table-condensed">
                                        <thead>
                                            <tr>
                                                <th>Test</th>
                                                <th>Price</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                    <div class="pull-right">
                                        <button class="btn btn-success" id="saveDiagnosis">
                                            <i class="fa fa-save"></i> Save</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            @if(!$performed_diagnosis->isEmpty())
            <div class="box box-success">
                <div class="box-header">
                    <h4 class="box-title">Previously ordered tests</h4>
                </div>
                <div class="box-body">
                    <table class="table table-condensed">
                        <thead>
                            <tr>
                                <th>Procedure</th>
                                <th>Type</th>
                                <th>Price</th>
                                <th>Payment</th>
                                <th>Result</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($performed_diagnosis as $item)
                            <tr>
                                <td>{{str_limit($item->procedures->name,20,'...')}}</td>
                                <td>{{$item->type}}</td>
                                <td>{{$item->price}}</td>
                                <td>{!! payment_label($item->is_paid) !!}</td>
                                @if($item->has_result)
                                <td><a href="{{route('evaluation.view_result',$item->visit)}}" class="btn btn-xs btn-success" target="_blank">
                                        <i class="fa fa-external-link"></i> View Result
                                    </a></td>
                                @else
                                <td><span class="text-warning"><i class="fa fa-warning"></i> Pending</span></td>
                                @endif
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
<style>
    .investigation_item{
        height:400px;
        overflow-y: scroll;
    }
</style>