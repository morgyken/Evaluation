<?php
/*
 * Collabmed Solutions Ltd
 * Project: iClinic
 *  Author: Samuel Okoth <sodhiambo@collabmed.com>
 */
$visit = $data['visit'];
$history = $data['visits'];
$patient = $data['patient'];
$status = $data['status'];
?>
@extends('layouts.app')
@section('content_title','Manage Patient Visits')
@section('content_description','View patient visits')

@section('content')
<div class="box box-info">
    <div class="box-body">
        <div class="col-md-4">
            <h4>Patient Information</h4>
            <dl class="dl-horizontal">
                <dt>Name:</dt><dd>{{$patient->full_name}}</dd>
                <dt>Date of Birth:</dt><dd>{{(new Date($patient->dob))->format('m/d/y')}}
                    <strong>({{(new Date($patient->dob))->age}} years old)</strong></dd>
                <dt>Gender:</dt><dd>{{$patient->sex}}</dd>
                <dt>Mobile Number:</dt><dd>{{$patient->mobile}}</dd>
            </dl>
        </div>
        <div class="col-md-8">
            <h4>Patient Evaluation</h4>
            @if($data['checked_in'])
            <a href="{{route('evaluation.new_visit',$data['schedule']->id)}}" class="btn btn-info">
                <i class="fa fa-medkit"></i> New Visit</a>
            @else
            <p class="text-warning">This patient is not checked in. Checkin patient to create a new visit</p>
            @endif
            <h4>Visit History</h4>
            @if($history->isEmpty())
            <p>No history previous visits</p>
            @else
            <table class="table table-striped">
                <tbody>
                    @foreach($history as $visit)
                    <tr>
                        <td>{{$visit->clinics->name}}</td>
                        <td>{{(new Date($visit->created_at))->format('dS M Y g:i a')}}</td>
                        <td>
                            @if($visit->sign_out)
                            Signed Out
                            @else
                            Active Visit
                            @endif
                        </td>
                        <td><a class='btn btn-xs' href="{{route('evaluation.evaluate',$visit->id)}}">
                                <i class="fa fa-wpforms"></i> Review</a>
                            @if(!$visit->sign_out)
                            <a class="btn btn-xs" href="{{route('evaluation.sign_out',$visit->id)}}">
                                <i class="fa fa-sign-out"></i> Check out</a>
                            @endif</td>
                    </tr>
                    @endforeach
                </tbody>
                <thead>
                    <tr>
                        <th>Clinic</th>
                        <th>Date/Time</th>
                        <th>Status</th>
                        <th></th>
                    </tr>
                </thead>
            </table>
            @endif
        </div>
    </div>
</div>
@endsection