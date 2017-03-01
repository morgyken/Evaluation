<?php
/*
 * Collabmed Solutions Ltd
 * Project: iClinic
 *  Author: Bravo <bkiptoo@collabmed.com>
 */
extract($data);
?>
@extends('layouts.app')
@section('content_title','Patient Evaluation')
@section('content_description','Patient evaluation | Physiotherapy')

@section('content')
@include('evaluation::partials.common.patient_details')
<div class="box box-default">
    <div class="box-body">
        <div class="form-horizontal">
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li class="active">
                        <a href="#ordered" data-toggle="tab">Treatment</a>
                    </li>
                    <li><a href="#history" data-toggle="tab">History</a></li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="ordered">
                        <div>
                            @include('evaluation::partials.physio.treatment')
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
<script src="{{m_asset('evaluation:js/doctor_evaluation.min.js')}}"></script>
@endsection