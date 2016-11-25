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
@section('content_description','Patient evaluation | Theatre')

@section('content')
@include('evaluation::partials.common.patient_details')
<div class="box box-info">
    <div class="box-body">
        <div class="form-horizontal">
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#theatre" data-toggle="tab">Theatre</a></li>
                    <li><a href="#theatre_operations" data-toggle="tab">Theatre Operations</a></li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="theatre">
                        <div>
                            @include('evaluation::partials.theatre.theatre')
                        </div>
                    </div>
                    <div class="tab-pane" id="theatre_operations">
                        <div>
                            @include('evaluation::partials.theatre.theatre-templates')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@include('evaluation::routes')
<script src="{{asset('js/doctor_evaluation.min.js')}}"></script>
@endsection