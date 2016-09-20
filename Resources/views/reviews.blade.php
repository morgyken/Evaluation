<?php
/*
 * Collabmed Solutions Ltd
 * Project: iClinic
 *  Author: Samuel Okoth <sodhiambo@collabmed.com>
 */
?>
@extends('layouts.app')
@section('content_title','Review Patient Visits')
@section('content_description','Review previous visits')

@section('content')
<div class="box box-info">
    <div class="box-body">

        <table class="table">
            <thead>
                <tr>
                    <th>ID No</th>
                    <th>Name</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data['patients'] as $patient)
                <tr>
                    <td>{{$patient->id_no}}</td>
                    <td>{{$patient->fullname}}</td>
                    <td>
                        <a href="{{route('evaluation.patient_visits',[$patient->patient_id,1])}}" class="btn btn-xs"><i class="fa fa-deafness"></i> Review</a>
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