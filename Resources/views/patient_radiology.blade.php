<?php
/*
 * Collabmed Solutions Ltd
 * Project: iClinic
 *  Author: Samuel Okoth <sodhiambo@collabmed.com>
 */
extract($data);
$tests = $visit->investigations->where('type', 'radiology')->where('has_result', false);
$results = $visit->investigations->where('type', 'radiology')->where('has_result', true);
?>
@extends('layouts.app')
@section('content_title','Patient Evaluation | Radiology')
@section('content_description','Patient evaluation | Radiology')

@section('content')
@include('evaluation::partials.common.patient_details')
<div class="box box-default">
    <div class="box-body">
        <div class="form-horizontal">
            <div class="col-md-12">
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#ordered" data-toggle="tab">
                                Ordered Procedures<span class="badge alert-info">{{$tests->count()}}</span></a></li>
                        <li><a href="#new" data-toggle="tab">
                                New Procedures  <span class="badge alert-success">new</span></a> </li>
                        <li><a href="#results" data-toggle="tab">
                                Results <span class="badge alert-success">{{$results->count()}}</span></a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active " id="ordered">
                            @include('evaluation::partials.radio.ordered')
                        </div>
                        <div class="tab-pane" id="new">
                            @include('evaluation::partials.radio.new')
                        </div>
                        <div class="tab-pane" id="results">
                            @include('evaluation::partials.radio.results')
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