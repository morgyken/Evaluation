<?php
/*
 * Collabmed Solutions Ltd
 * Project: iClinic
 *  Author: Samuel Okoth <sodhiambo@collabmed.com>
 */
$patient = $data['patient'];
$data['docs'] = get_patient_documents($patient->id);
$data['section'] = 'evaluation';
?>
@extends('layouts.app')
@section('content_title','Patient Evaluation')
@section('content_description','Patient evaluation and Treatment')

@section('content')
<div class="box box-info">
    <div class="box-body">
        @include('evaluation::partials.patient_details')
        <div class="form-horizontal">
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#vitals" data-toggle="tab">Vitals</a></li>
                    <li><a href="#doctor" data-toggle="tab">Doctors' notes</a></li>
                    <li><a href="#treatment" data-toggle="tab">Treatment</a></li>
                    <li><a href="#investigations" data-toggle="tab">Investigations</a></li>
                    <li><a href="#op" data-toggle="tab">OP Notes</a></li>
                    <li><a href="#drawings" data-toggle="tab">Drawings</a></li>
                    <li><a href="#documents" data-toggle="tab">Documents</a></li>
                    <li><a href="#history" data-toggle="tab">History</a></li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="vitals">
                        <div>
                            @include('evaluation::partials.patient_vitals')
                        </div>
                    </div>
                    <div class="tab-pane" id="doctor">
                        <div>
                            @include('evaluation::partials.doctors_notes')
                        </div>
                    </div>
                    <div class="tab-pane" id="investigations">
                        <div>
                            @include('evaluation::partials.investigations')
                        </div>
                    </div>
                    <div class="tab-pane" id="treatment">
                        <div>
                            @include('evaluation::partials.treatment')
                        </div>
                    </div>
                    <div class="tab-pane" id="op">
                        <div>
                            @include('evaluation::partials.op_notes')
                        </div>
                    </div>
                    <div class="tab-pane" id="documents">
                        <div>
                            @include('reception::partials.doc_list')
                        </div>
                    </div>

                    <div class="tab-pane" id="history">
                        <div>
                            @include('evaluation::partials.history')
                        </div>
                    </div>
                    <div class="tab-pane" id="drawings">
                        @include('evaluation::partials.drawings')
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    var USER_ID = parseInt("{{ Auth::user()->user_id }}");
    var VISIT_ID = parseInt("{{ $data['visit'] }}");
    var VITALS_URL = "{{route('evaluation.ajax.save_vitals')}}";
    var NOTES_URL = "{{route('evaluation.ajax.save_notes')}}";
    var PRESCRIPTION_URL = "{{route('evaluation.ajax.save_prescription')}}";
    var SET_DATE_URL = "{{route('evaluation.ajax.set_visit_date')}}";
    var DIAGNOSIS_URL = "{{route('evaluation.ajax.save_diagnosis')}}";
    var OPNOTES_URL = "{{route('evaluation.ajax.save_opnotes')}}";
    var TREAT_URL = "{{route('evaluation.ajax.save_treatment')}}";
    var DRAWINGS_URL = "{{route('evaluation.ajax.save_drawings')}}";
    var VISIT_METAS_URL = "{{route('evaluation.ajax.save_visit_metas')}}";
</script>
<script src="{{asset('js/doctor_evaluation::min.js')}}"></script>
@endsection