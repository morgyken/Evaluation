<?php
/*
 * Collabmed Solutions Ltd
 * Project: iClinic
 *  Author: Samuel Okoth <sodhiambo@collabmed.com>
 */

extract($data);
$department = 'doctor';
?>
@extends('layouts.app')
@section('content_title',$patient->full_name)
@section('content_description','Viewing all visits for '.$patient->full_name)

@section('content')
    <div class="box box-info">
        <div class="box-body">
            <table class="table table-condensed">
                <thead>
                <tr>
                    <th>Visit ID</th>
                    <th>Facility</th>
                    <th>Destinations</th>
                    <th>Date</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @foreach($visits as $visit)
                    <tr>
                        <td>{{$visit->id}}</td>
                        <td>{{$visit->clinics->name}}</td>
                        <td>{!! translate_destination($visit)!!}</td>
                        <td>{{smart_date_time($visit->created_at)}}</td>
                        <td><a href="{{route('evaluation.evaluate',[$visit->id,$department])}}"
                               class="btn btn-xs btn-success">Review</a></td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection