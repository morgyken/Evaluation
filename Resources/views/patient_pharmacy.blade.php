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
@section('content_description','Patient evaluation | Pharmacy')

@section('content')
<div class="box box-info">
    <div class="box-body">
        @include('evaluation::partials.common.patient_details')
        <div class="form-horizontal">
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#ordered" data-toggle="tab">Ordered Prescriptions</a></li>
                    <li><a href="#new" data-toggle="tab">Order new prescriptions</a> </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active " id="ordered">
                        @include('evaluation::partials.pharmacy.ordered')
                    </div>
                    <div class="tab-pane" id="new">
                        @include('evaluation::partials.pharmacy.new')
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection