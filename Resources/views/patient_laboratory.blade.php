<?php
/*
 * Collabmed Solutions Ltd
 * Project: iClinic
 *  Author: Samuel Okoth <sodhiambo@collabmed.com>
 */
extract($data);
$labs = $visit->investigations->where('type', 'laboratory')->where('has_result', false);
$results = $visit->investigations->where('type', 'laboratory')->where('has_result', true);
?>
@extends('layouts.app')
@section('content_title','Patient Evaluation | Laboratory')
@section('content_description','Patient evaluation | Laboratory')

@section('content')
@include('evaluation::partials.common.patient_details')
<div class="box box-default">
    <div class="box-body">
        <div class="form-horizontal">
            <div class="col-md-12">
                <div class="nav-tabs-custom">
                    <ul id="tabs" class="nav nav-tabs">
                        <li class="active"><a href="#ordered" data-toggle="tab">
                                Ordered Labs<span class="badge alert-info">{{$labs->count()}}</span></a></li>
                        <li><a href="#new" data-toggle="tab">
                                Order labs   <span class="badge alert-success">new</span></a> </li>
                        <li><a href="#results" data-toggle="tab" id="view_results">
                                Lab Results <span class="badge alert-success">{{$results->count()}}</span></a> </li>
                        @if($results->count()>0)
                        <li><a target="blank" href="{{route('evaluation.print.print_lab', $visit)}}">
                                Print Results<span class="badge alert-success"></span></a></li>
                        @endif
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active " id="ordered">
                            @include('evaluation::partials.labs._ordered')
                        </div>
                        <div class="tab-pane" id="new">
                            @include('evaluation::partials.labs.new')
                        </div>
                        <div class="tab-pane" id="results">
                            @include('evaluation::partials.labs.results')
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

    $("view_results").click(function (e) {
        e.preventDefault();
        reload();
    });

    function reload() {
        location.reload();
    }
</script>
<script src="{{m_asset('evaluation:js/results.js')}}"></script>
@endsection