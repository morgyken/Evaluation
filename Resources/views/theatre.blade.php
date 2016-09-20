<?php
/*
 * Collabmed Solutions Ltd
 * Project: iClinic
 *  Author: Samuel Okoth <sodhiambo@collabmed.com>
 */

$patient = $data['patient'];
$data['docs'] = \Dervis\Modules\Reception\Entities\PatientDocuments::wherePatient($patient->patient_id)->get();
$data['section'] = 'theatre';
?>
@extends('layouts.app')
@section('content_title','Patient Evaluation')
@section('content_description','Patient evaluation | Theatre')

@section('content')
<div class="box box-info">
    <div class="box-body">
        @include('evaluation::partials.patient_details')
        <div class="form-horizontal">
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#theatre" data-toggle="tab">Theatre</a></li>
                    <li><a href="#theatre_operations" data-toggle="tab">Theatre Operations</a></li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="theatre">
                        <div>
                            @include('evaluation::partials.theatre')
                        </div>
                    </div>
                    <div class="tab-pane" id="theatre_operations">
                        <div>
                            @include('evaluation::partials.theatre-templates')
                        </div>
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
</script>
<script src="{{asset('js/doctor_evaluation.min.js')}}"></script>
@endsection