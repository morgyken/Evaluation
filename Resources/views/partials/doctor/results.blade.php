<?php
/*
 * =============================================================================
 *
 * Collabmed Solutions Ltd
 * Project: Collabmed Health Platform
 * Author: Samuel Okoth <sodhiambo@collabmed.com>
 *
 * =============================================================================
 */
extract($data);
?>
@extends('layouts.app')
@section('content_title','Patient Evaluation')
@section('content_description','Investigation Results')

@section('content')
@include('evaluation::partials.common.patient_details')
<div class="box box-info">
    <div class="box-body">
        @foreach($results as $item)
        <div class="col-md-12">
            <h4>Test #{{$loop->iteration}}: {{$item->procedures->name}}</h4>
            <div class="col-md-4">
                <dl class="dl-horizontal">
                    <dt>Procedure</dt><dd>{{$item->procedures->name}}</dd>
                    <dt>Type:</dt><dd><u>{{ucwords($item->type)}}</u></dd>
                    <dt>Requested By:</dt><dd>{{$item->doctors->profile->full_name}}</dd>
                    <dt>Instructions:</dt><dd><p>{{$item->instructions ?? 'Not provided'}}</p></dd>
                    <dt>Charges:</dt><dd>{{$item->pesa}}</dd>
                    <dt>Date:</dt><dd>{{smart_date_time($item->created_at)}}</dd>

                    <hr/>

                    <dt>Result By:</dt><dd>{{$item->results->users->profile->full_name}}</dd>
                    <dt>Result Date:</dt><dd>{{smart_date_time($item->results->create_at)}}</dd>
                </dl>
            </div>
            <div class="col-md-8">
                <h4>Test Results</h4>
                @include('evaluation::partials.labs.results.list')
                <div class="well well-sm">
                    <table class="table table-condensed table-striped">
                        @include('evaluation::partials.labs.results.list')
                    </table>
                </div>
                @if($item->results->documents)
                Uploaded File -
                <a href="{{route('reception.view_document',$item->results->documents->id)}}" target="_blank">
                    <i class="fa fa-file"></i> {{$item->results->documents->filename}}</a>
                @else
                <p class="text-warning"><i class="fa fa-warning"></i> No file uploaded</p>
                @endif
            </div>
        </div>
        <hr/>
        @endforeach
    </div>
    @endsection
</div>