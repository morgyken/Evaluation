<?php
/*
 * Collabmed Solutions Ltd
 * Project: iClinic
 *  Author: Samuel Okoth <sodhiambo@collabmed.com>
 */
extract($data);
$diagnoses = $visit->investigations->where('type', 'diagnosis')->where('has_result', false);
$results = $visit->investigations->where('type', 'diagnosis')->where('has_result', true);
?>
@extends('layouts.app')
@section('content_title','Patient Evaluation | Diagnostics')
@section('content_description','Patient evaluation | Diagnostics')

@section('content')
@include('evaluation::partials.common.patient_details')
<div class="box box-default">
    <div class="box-body">
        <div class="form-horizontal">
            <div class="col-md-12">
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#ordered" data-toggle="tab">
                                Ordered Tests <span class="badge alert-info">{{$diagnoses->count()}}</span></a></li>
                        <li><a href="#new" data-toggle="tab">
                                Order Diagnostics <span class="badge alert-success">new</span></a> </li>
                        <li><a href="#results" data-toggle="tab">
                                Results <span class="badge alert-success">{{$results->count()}}</span></a> </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active " id="ordered">
                            @include('evaluation::partials.diagnostics.ordered')
                        </div>
                        <div class="tab-pane" id="new">
                            @include('evaluation::partials.diagnostics.new')
                        </div>
                        <div class="tab-pane" id="results">
                            @include('evaluation::partials.diagnostics.results')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    var VISIT_ID = "{{ $visit->id }}";
    var SAVE_URL = "{{route('api.evaluation.investigation_result')}}";
</script>
<script src="{{m_asset('evaluation:js/results.min.js')}}"></script>
@endsection