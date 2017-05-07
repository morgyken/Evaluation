<?php
/*
 * Collabmed Solutions Ltd
 * Project: iClinic
 *  Author: Samuel Okoth <sodhiambo@collabmed.com>
 */
extract($data);
$investigations = $visit->investigations->where('type', 'diagnosis')->where('has_result', false);
$results = $visit->investigations->where('type', 'diagnosis')->where('has_result', true);
$category = 'diagnosis';
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
                        <li class="active">
                            <a href="#ordered" data-toggle="tab">
                                Ordered Tests <span class="badge alert-info">{{$investigations->count()}}</span></a>
                        </li>
                        <li>
                            <a href="#new" data-toggle="tab">
                                Order Diagnostics <span class="badge alert-success">new</span></a>
                        </li>
                        <li>
                            <a href="#results" data-toggle="tab">
                                Results <span class="badge alert-success">{{$results->count()}}</span></a>
                        </li>
                        @if($results->count()>0)
                        <li>
                            <a target="blank" href="{{route('evaluation.print.print_res', ['visit'=>$visit,'type'=>$category])}}">
                                Print Results<span class="badge alert-success"></span></a>
                        </li>
                        @endif
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active " id="ordered">
                            @include('evaluation::partials.common.investigations.ordered')
                        </div>
                        <div class="tab-pane" id="new">
                            @include('evaluation::partials.diagnostics.new')
                        </div>
                        <div class="tab-pane" id="results">
                            @include('evaluation::partials.common.investigations.res')
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