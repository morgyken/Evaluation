<?php
/*
 * Collabmed Solutions Ltd
 * Project: iClinic
 *  Author: Samuel Okoth <sodhiambo@collabmed.com>
 */
?>
<div>
    <div class="row">
        <div class="col-md-12">
            <div class="col-md-8">
                <div class="accordion">
                    @if(!m_setting('evaluation.no_diagnostics'))
                        <h4>Diagnosis</h4>
                        <div class="investigation_item">
                            @include('evaluation::partials.doctor.investigations-diagnostics')
                        </div>
                    @endif

                    @if(!m_setting('evaluation.no_laboratory'))
                        <h4>Laboratory</h4>
                        <div class="investigation_item">
                            @include('evaluation::partials.doctor.investigations-laboratory')
                        </div>
                    @endif
                    @if(!m_setting('evaluation.no_radiology'))
                        <h4>Radiology</h4>
                        <div class="investigation_item">
                            @include('evaluation::partials.doctor.radiology')
                        </div>
                    @endif
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
                                        <div class="loader" id="diagnosisLoader"></div>
                                        <button class="btn btn-success" id="saveDiagnosis">
                                            <i class="fa fa-save"></i> Save
                                        </button>
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
                    <table id="previousInvestigations" class="table table-condensed table-striped" width="100%">
                        <thead>
                        <tr>
                            <th>Procedure</th>
                            <th>Type</th>
                            <th>Price</th>
                            <th>No. Performed</th>
                            <th>Amount</th>
                            <th>Payment</th>
                            <th>Date</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<style>
    .investigation_item {
        overflow: auto;
    }
</style>
<script type="text/javascript">
    var PERFOMED_INVESTIGATION_URL = "{{ route('api.evaluation.performed_investigations',$visit->id) }}";
    $(function () {
//        $('.investigation_item').find('input').iCheck({
//            checkboxClass: 'icheckbox_flat-blue',
//            radioClass: 'iradio_square-blue',
//            increaseArea: '20%' // optional
//        });
    });
</script>