<?php
/*
 * Collabmed Solutions Ltd
 * Project: iClinic
 *  Author: Samuel Okoth <sodhiambo@collabmed.com>
 */
extract($data);
//dd($department);
?>
@extends('layouts.app')
@section('content_title','Patient Evaluation')
@section('content_description','Patient evaluation and Treatment')

@section('content')
<div class="box box-info">
    <div class="box-body">
        <div class="col-md-4">
            <h4>Patient Information</h4>
            <dl class="dl-horizontal">
                <dt>Name:</dt>
                <dd>{{$patient->full_name}}</dd>
                <dt>Date of Birth:</dt>
                <?php try{ ?>
                <dd>{{(new Date($patient->dob))->format('m/d/y')}}
                    <strong>({{(new Date($patient->dob))->age}} years old)</strong></dd>
                <?php }catch (\Exception $e){} ?>
                <dt>Gender:</dt>
                <dd>{{$patient->sex}}</dd>
                <dt>Mobile Number:</dt>
                <dd>{{$patient->mobile}}</dd>
            </dl>
        </div>
        <div class="col-md-8">
            <h4>Patient Evaluation</h4>
            <a href="{{route('evaluation.evaluate',[$visit->id,$department])}}" class="btn btn-info">
                <i class="fa fa-medkit"></i> Evaluate Patient</a>
            <h4>Visit History</h4>
            @if($history->isEmpty())
            <p class="text-info"><i class="fa fa-info-circle"></i> No records of previous visits</p>
            @else
            <table class="table table-striped">
                <tbody>
                    @foreach($history as $visit)
                    <tr>
                        <td>{{$visit->id}}</td>
                        <td>{{$visit->clinics->name}}</td>
                        <td>{{$visit->visit_destination}}</td>
                        <td>{{smart_date_time($visit->created_at)}}</td>
                        <td><a class='btn btn-xs'
                               href="{{route('evaluation.evaluate',[$visit->id,$department])}}">
                                <i class="fa fa-wpforms"></i> Review Visit</a>
                            @if($visit->sign_out)
                            <a class="btn btn-xs"
                               href="{{route('evaluation.sign_out',[$visit->id,$department])}}">
                                <i class="fa fa-sign-out"></i> Check out</a>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Clinic</th>
                        <th>Destinations</th>
                        <th>Date/Time</th>
                        <th>Action</th>
                    </tr>
                </thead>
            </table>
            @endif
        </div>
    </div>
</div>
@include('evaluation::routes')
@endsection