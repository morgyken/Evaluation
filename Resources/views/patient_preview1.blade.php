<?php
/*
 * Collabmed Solutions Ltd
 * Project: iClinic
 *  Author: Samuel Okoth <sodhiambo@collabmed.com>
 */

$patient = $data['patient'];
$data['docs'] = \Dervis\Modules\Reception\Entities\PatientDocuments::wherePatient($patient->patient_id)->get();
$data['section'] = 'nurse';
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
                    <li><a href="#doctor" data-toggle="tab">Preliminary Examination</a></li>
                    @if($data['visits']->theatre)
                    <li><a href="#thetre" data-toggle="tab">Theatre</a></li>
                    @endif
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
                            @include('evaluation::partials.nurse_eye')
                        </div>
                    </div>
                    <div class="tab-pane" id="thetre">
                        <div>
                            @include('evaluation::partials.theatre')
                        </div>
                    </div>
                    <div class="tab-pane" id="history">
                        <div>
                            @include('evaluation::partials.history')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    var USER_ID = parseInt("{{ Auth::user()->id }}");
    var VISIT_ID = parseInt("{{ $data['visit'] }}");
    var VITALS_URL = "{{route('api.evaluation.save_vitals')}}";
    var NOTES_URL = "{{route('api.evaluation.save_notes')}}";
    var PRESCRIPTION_URL = "{{route('api.evaluation.save_prescription')}}";
    var SET_DATE_URL = "{{route('api.evaluation.set_visit_date')}}";
    var DIAGNOSIS_URL = "{{route('api.evaluation.save_diagnosis')}}";
    var OPNOTES_URL = "{{route('api.evaluation.save_opnotes')}}";
    var TREAT_URL = "{{route('api.evaluation.save_treatment')}}";
    var DRAWINGS_URL = "{{route('api.evaluation.save_drawings')}}";
</script>
<script src="{{Module::asset('evaluation:js/doctor_evaluation.min.js')}}"></script>
@endsection