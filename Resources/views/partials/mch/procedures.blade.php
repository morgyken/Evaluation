<?php
/*
 * Collabmed Solutions Ltd
 * Project: iClinic
 *  Author: Samuel Okoth <sodhiambo@collabmed.com>
 */

$discount_allowed = json_decode(m_setting('evaluation.discount'));

$co = null;
$visit = \Ignite\Evaluation\Entities\Visit::find($visit->id);
?>
<div class="col-md-12">
    <div class="col-md-8">
        <div class="accordion">
            <h4>Dental Procedures</h4>
            <div class="treatment_item">
                {!! Form::open(['id'=>'procedures_doctor_form'])!!}
                {!! Form::hidden('visit',$visit->id) !!}
                <table class="table table-condensed table-borderless" id="procedures" width="100%">
                    @include('evaluation::partials.mch.procedure_table',['_list'=>'MCH','_type'=>'mch'])
                </table>
                {!! Form::close()!!}
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="row">
            <div class="col-md-12" id="selected_treatment">
                <div class="box box-primary">
                    <div class="box-header">
                        <h4 class="box-title">Selected procedures</h4>
                    </div>
                    <div class="box-body">
                        <table id="treatment" class=" table table-condensed">
                            <thead>
                            <tr>
                                <th>Procedure</th>
                                <th>Amount</th>
                            </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                        <div class="pull-right">
                            <button class="btn btn-success" id="saveTreatment"><i class="fa fa-save"></i> Save
                            </button>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
<br/>
<br/>
<div class="row">
    <div class="col-md-12">
        <div class="box box-success">
            <div class="box-header">
                <h4 class="box-title">Previously administered procedures</h4>
            </div>
            <div class="box-body">
                <table class="table table-condensed" id="in_table" width="100%">
                    <thead>
                    <tr>
                        <th>Procedure</th>
                        <th>Type</th>
                        <th title="Unit price">Price</th>
                        <th title="Number performed">No. Perf</th>
                        <th title="Discount">Disc(%)</th>
                        <th>Total</th>
                        <th>Payment</th>
                        <th>Date Ordered</th>
                    </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<!-- -->
<style>
    #treatment_form {
        height: 400px;
        overflow-y: scroll;
    }

    .treatment_item {
        overflow-y: scroll;
    }
</style>
<script type="text/javascript">
    var PERFOMED_URL = "{{ route('api.evaluation.performed_treatment',[$visit->id,'type'=>'mch']) }}";
    $(function () {
        $('.treatment_item').find('input').iCheck({
            checkboxClass: 'icheckbox_flat-blue',
            radioClass: 'iradio_square-blue',
            increaseArea: '20%' // optional
        });

    });
</script>