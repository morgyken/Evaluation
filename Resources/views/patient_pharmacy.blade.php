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
                    <li class="active">
                        <a href="#disp" data-toggle="tab">
                            Order new drugs
                        </a>
                    </li>
                    <li>
                        <a href="#ordered" data-toggle="tab">
                            Ordered
                            <span class="badge alert-info">
                                {{$drug_prescriptions->count()}}
                            </span>
                        </a>
                    </li>
                    <li>
                        <a href="#dispensed" data-toggle="tab">
                            Dispensed
                            <span class="badge alert-info">
                                {{$dispensed->count()}}
                            </span>
                        </a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="disp">
                        @include('evaluation::partials.pharmacy.dispense')
                    </div>
                    <div class="tab-pane" id="ordered">
                        @include('evaluation::partials.pharmacy.ordered')
                    </div>
                    <div class="tab-pane" id="dispensed">
                        @include('evaluation::partials.pharmacy.dispensed')
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@include('evaluation::routes')
@endsection