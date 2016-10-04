<?php
/*
 * Collabmed Solutions Ltd
 * Project: iClinic
 *  Author: Samuel Okoth <sodhiambo@collabmed.com>
 */
$performed_diagnosis = get_investigations($data['visit']);
?>
<div>
    <div class="row">
        <div class="col-md-12">
            <div class="col-md-8">
                <div class="accordion">
                    <h4>Diagnosis</h4>
                    <div class="investigation_item">
                        @include('evaluation::partials.diagnosis')
                    </div>
                    <h4>Laboratory</h4>
                    <div class="investigation_item">
                        @include('evaluation::partials.labs')
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="row">
                    <div class="col-md-12">
                        <div class="box box-primary">
                            <div class="box-header">
                                <h4 class="box-title">Selected diagnosis procedures</h4>
                            </div>
                            <div class="box-body">
                                <div class="alert alert-success alert-dismissible">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                    <i class="fa fa-check-circle-o"></i> New selected diagnosis will appear here
                                </div>
                                <div id="diagnosisTable">
                                    <table id="diagnosisInfo" class=" table table-condensed">
                                        <thead>
                                            <tr>
                                                <th>Test</th>
                                                <th>Cost</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                    <div class="pull-right">
                                        <button class="btn btn-success" id="saveDiagnosis"><i class="fa fa-save"></i> Save</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        @if(!empty($performed_diagnosis))
                        <div class="box box-success">
                            <div class="box-header">
                                <h4 class="box-title">Previously ordered diagnosis</h4>
                            </div>
                            <div class="box-body">
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
                                        @foreach($performed_diagnosis as $item)
                                        <tr>
                                            <td>{{str_limit($item->procedures->name,20,'...')}}</td>
                                            <td>{{$item->price}}</td>
                                            <td>{{$item->is_paid?'Paid':'Not Paid'}}</td>
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
        </div>
    </div>

</div>
<style>
    .investigation_item{
        height:400px;
        overflow:scroll;
    }
</style>