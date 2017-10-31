<?php
/*
 * Collabmed Solutions Ltd
 * Project: iClinic
 *  Author: Samuel Okoth <sodhiambo@collabmed.com>
 */
$performed_diagnosis = get_investigations($visit, ['diagnostics']);
$performed_labs = get_investigations($visit, ['laboratory']);
$performed_radio = get_investigations($visit, ['radiology']);
$performed_ultrasound = get_investigations($visit, ['ultrasound']);
?>
<div>
    <div class="row">
        <div class="col-md-12">
            <div class="col-md-8">
                <div class="accordion">
                    <h4>Diagnosis</h4>
                    <div class="investigation_item">
                        @include('evaluation::partials.doctor.investigations-diagnostics')
                    </div>
                    <h4>Laboratory</h4>
                    <div class="investigation_item">
                        @include('evaluation::partials.doctor.investigations-laboratory')
                    </div>
                    <h4>Radiology</h4>
                    <div class="investigation_item">
                        @include('evaluation::partials.doctor.radiology')
                    </div>
                    <h4>Ultrasound</h4>
                    <div class="investigation_item">
                        @include('evaluation::partials.doctor.ultrasound')
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
                                            @if(!m_setting('evaluation.hide_procedure_prices'))
                                            <th>Price</th>
                                            @endif
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
            <div class="box box-success">
                <div class="box-header">
                    <h4 class="box-title">Previously ordered tests</h4>
                </div>
                <div class="box-body">
                    <table id="t" class="table table-condensed table-striped">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Procedure</th>
                            <th>Type</th>
                            <th>Price</th>
                            <th>No. Performed</th>
                            <th>Discount</th>
                            <th>Amount</th>
                            <th>Payment</th>
                            <th>Created</th>
                            <th>Result</th>
                        </tr>
                        </thead>
                        <tbody class="done_investigation"></tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</div>
<style>
    .investigation_item{
        overflow: auto;
    }
</style>
<script>
    var DONE_IVESTIGATION_URL = "{{ route('api.evaluation.done_investigation',$visit->id) }}";
    $(document).ready(function() {
        try {
            $('#t').DataTable();
        }catch ($e){

        }
    } );
    window.alert = (function() {
        var nativeAlert = window.alert;
        return function(message) {
           // window.alert = nativeAlert;
            message.indexOf("DataTables warning") === 0 ?
                console.warn(message) :
                nativeAlert(message);
        }
    })();
</script>