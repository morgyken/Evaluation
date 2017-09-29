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
@section('content_description','Patient evaluation and Treatment')

@section('content')
    @include('evaluation::partials.common.patient_details')
    <div class="box box-default">
        <div class="box-body">
            <div class="form-horizontal">
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">

                        <li class="active"><a href="#vitals" data-toggle="tab">Vitals</a></li>
                        <!--
                        <li><a href="#pre-exam" data-toggle="tab">Preliminary</a></li>
                        -->
                        <li><a href="#doctor" data-toggle="tab">Doctors' notes</a></li>
                        <li><a href="#procedures" data-toggle="tab">Treatment</a></li>
                        <li><a href="#investigations" data-toggle="tab">Investigations</a></li>
                        @if(m_setting('evaluation.op_notes'))
                            <li><a href="#op" data-toggle="tab">OP Notes</a></li>
                        @endif
                        @if(m_setting('evaluation.drawings'))
                            <li><a href="#drawings" data-toggle="tab">Drawings</a></li>
                        @endif
                        <li><a href="#documents" data-toggle="tab">Documents</a></li>
                        <li><a href="#history" data-toggle="tab">History</a></li>
                        <!-- <li><a href="#v1history" data-toggle="tab">V1 History</a></li> -->
                        <li>
                            <a class="btn btn-primary pull-right" target="blank"
                               href="{{route('evaluation.print.patient_notes',$data['visit'])}}"><i
                                        class="fa fa-print"></i> Print</a>
                        </li>
                    <!--
                    <li>
                        <a class="btn btn-primary pull-right" target="blank" href="{{route('evaluation.print.to_word',$data['visit'])}}"><i class="fa fa-download"></i>Send to Word</a>
                    </li>
                    -->
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="vitals">
                            <div>
                                @include('evaluation::partials.nurse.patient_vitals')
                            </div>
                        </div>
                        <div class="tab-pane" id="pre-exam">
                            <div>
                                @include('evaluation::partials.nurse.eye')
                            </div>
                        </div>
                        <div class="tab-pane" id="doctor">
                            <div>
                                @include('evaluation::partials.doctor.doctors_notes')
                            </div>
                        </div>
                        <div class="tab-pane" id="investigations">
                            <div>
                                @include('evaluation::partials.doctor.investigations')
                            </div>
                        </div>
                        <div class="tab-pane" id="procedures">
                            <div>
                                @include('evaluation::partials.doctor.procedures')
                            </div>
                        </div>
                        @if(m_setting('evaluation.op_notes'))
                            <div class="tab-pane" id="op">
                                <div>
                                    @include('evaluation::partials.doctor.op_notes')
                                </div>
                            </div>
                        @endif
                        <div class="tab-pane" id="documents">
                            <div>
                                @include('evaluation::partials.common.documents_list')
                            </div>
                        </div>

                        <div class="tab-pane" id="history">
                            <div>
                                @include('evaluation::partials.common.history')
                            </div>
                        </div>


                        <div class="tab-pane" id="v1history">
                            <div>
                                @include('evaluation::partials.common.v1history')
                            </div>
                        </div>

                        @if(m_setting('evaluation.drawings'))
                            <div class="tab-pane" id="drawings">
                                @include('evaluation::partials.doctor.drawings')
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('evaluation::routes')
@endsection