<?php
/*
 * Collabmed Solutions Ltd
 * Project: iClinic
 *  Author: Samuel Okoth <sodhiambo@collabmed.com>
 */
extract($data);
?>
@extends('layouts.app')
@section('content_title','Patient Evaluation')
@section('content_description','Patient evaluation | Nursing')

@section('content')
@include('evaluation::partials.common.patient_details')
<div class="box box-default">
    <div class="box-body">
        <div class="form-horizontal">
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#vitals" data-toggle="tab">Vitals</a></li>
                    <li><a href="#doctor" data-toggle="tab">Preliminary Examination</a></li>
                    <li><a href="#treatment" data-toggle="tab">Treatment</a></li>
                    @if($visit->theatre)
                    <li><a href="#thetre" data-toggle="tab">Theatre</a></li>
                    @endif
                    <li><a href="#history" data-toggle="tab">History</a></li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="vitals">
                        <div>
                            @include('evaluation::partials.nurse.patient_vitals')
                        </div>
                    </div>
                    <div class="tab-pane" id="doctor">
                        <div>
                            @include('evaluation::partials.nurse.eye')
                        </div>
                    </div>
                    <div class="tab-pane" id="treatment">
                        <div>
                            @include('evaluation::partials.nurse.procedures')
                        </div>
                    </div>
                    <div class="tab-pane" id="thetre">
                        <div>
                            @include('evaluation::partials.theatre.theatre')
                        </div>
                    </div>
                    <div class="tab-pane" id="history">
                        <div>
                            @include('evaluation::partials.common.history')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    var USER_ID = parseInt("{{ Auth::user()->id }}");
    var VISIT_ID = parseInt("{{ $visit->id }}");
    var VITALS_URL = "{{route('api.evaluation.save_vitals')}}";
    var NOTES_URL = "{{route('api.evaluation.save_notes')}}";
    var PRESCRIPTION_URL = "{{route('api.evaluation.save_prescription')}}";
    var SET_DATE_URL = "{{route('api.evaluation.set_visit_date')}}";
    var DIAGNOSIS_URL = "{{route('api.evaluation.save_diagnosis')}}";
    var OPNOTES_URL = "{{route('api.evaluation.save_opnotes')}}";
    var DRAWINGS_URL = "{{route('api.evaluation.save_drawings')}}";
</script>
<script src="{{m_asset('evaluation:js/nurse-vitals.js')}}"></script>
@endsection