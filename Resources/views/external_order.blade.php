<?php
/*
 * Collabmed Solutions Ltd
 * Project: iClinic
 *  Author: Samuel Okoth <sodhiambo@collabmed.com>
 */
extract($data);
$results = getOrderResults($patient->id);
$external = true;
$r_mode = false;
if($results_mode){
    $r_mode = true;
}
?>
@extends('layouts.app')
@section('content_title','Patient Evaluation')
@section('content_description','Patient evaluation and Treatment')
@section('content')
<div class="box box-default">
    <div class="box-body">
        <div class="col-md-5">
            <dt>Patient Name:</dt>
            <dd>{{$patient->full_name}}
                <strong><u>{{$patient->sex}}</u></strong>
            </dd>
            <dt>Age:</dt>
            <dd>{{(new Date($patient->dob))->diff(Carbon\Carbon::now())->format('%y years, %m months and %d days')}} Old</dd>
        </div>
    </div>
    <hr>
    <div class="box-body">
        <div class="form-horizontal">
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li @if(!$r_mode) class="active" @endif>
                        <a href="#investigations" data-toggle="tab">Investigations</a>
                    </li>
                    <li>
                        <a href="#ordered" data-toggle="tab">
                            Ordered
                            <span class="badge alert-success">
                                {{$orders->count()}}
                            </span>
                        </a>
                    </li>
                    <li @if($r_mode) class="active" @endif>
                        <a href="#results" data-toggle="tab">
                            Results
                            <span class="badge alert-success">
                                {{$results->count()}}
                            </span>
                        </a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane @if(!$r_mode) active @endif" id="investigations">
                        <div>
                            @include('evaluation::partials.external.investigations')
                        </div>
                    </div>

                    <div class="tab-pane" id="ordered">
                        <div>
                            @include('evaluation::partials.external.ordered')
                        </div>
                    </div>

                    <div class="tab-pane @if($r_mode) active @endif" id="results">
                        <div>
                            @include('evaluation::partials.labs.results')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    var EXTERNAL_ORDER_URL = "{{route('api.evaluation.save_external_order')}}";
    $(document).ready(function () {
        $('.accordion').accordion({heightStyle: "content"});
    });
</script>
<script src="{{m_asset('evaluation:js/external_order.js')}}"></script>
@endsection