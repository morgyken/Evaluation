<?php
/*
 * Collabmed Solutions Ltd
 * Project: iClinic
 *  Author: Samuel Okoth <sodhiambo@collabmed.com>
 */
?>
@extends('layouts.app')
@section('content_title','Review Patient Visits')
@section('content_description','Review all visits')

@section('content')
<div class="box box-info">
    <div class="box-body">

        <table class="table">
            <thead>
                <tr>
                    <th>Visit ID</th>
                    <th>Clinic</th>
                    <th>Checkin Time</th>
                    <th>Destination</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data['visits'] as $visit)
                <tr>
                    <td>{{$visit->id}}</td>
                    <td>{{$visit->clinics->name}}</td>
                    <td>{{(new Date($visit->created_at))->format('dS M g:i a')}}</td>
                    <td>{{$visit->visit_destination}}</td>
                    <td>
                        <a href="{{route('evaluation.patient_visits',$visit->id)}}" class="btn btn-xs"><i class="fa fa-deafness"></i> Review</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        try {
            $('table').DataTable();
        } catch (e) {
        }
    });
</script>
@endsection