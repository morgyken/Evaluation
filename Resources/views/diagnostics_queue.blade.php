<?php
/*
 * Collabmed Solutions Ltd
 * Project: iClinic
 * Author: Samuel Okoth <sodhiambo@collabmed.com>
 */
$count = 0;
?>
@extends('layouts.app')
@section('content_title','Patients Awaiting Diagnostics')
@section('content_description','Diagnostics Queue')

@section('content')
<div class="box box-info">
    <div class="box-body">
        <table class="table table-striped">
            <tbody>
                @foreach($data['visits'] as $visit)
                <tr id="row_id{{$visit->visit_id}}">
                    <td>{{$visit->patients->full_name}}</td>
                    <td>{{$visit->investigations->first()->doctors->full_name}}</td>
                    <td>{{(new Date($visit->investigations->first()->created_at))->format('g:ia')}}</td>
                    <td>
                        <a href="{{route('evaluation.evaluate.radiology',$visit->visit_id)}}" class="btn btn-xs btn-primary">
                            <i class="fa fa-ellipsis-h"></i> Evaluate</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Doctor</th>
                    <th>Date</th>
                    <th>Status</th>
                    <th></th>
                </tr>
            </thead>
        </table>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        try {
            $('table').DataTable();
        } catch (e) {
            //console.error(e);
        }
    });
</script>
@endsection