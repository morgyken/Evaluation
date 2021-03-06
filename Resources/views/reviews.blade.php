<?php
/*
 * Collabmed Solutions Ltd
 * Project: iClinic
 *  Author: Samuel Okoth <sodhiambo@collabmed.com>
 */
extract($data);
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
                    <th>#</th>
                    <th>Patient No</th>
                    <th>Name</th>
                    <th>ID No</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach($patients as $patient)
                    <tr>
                        <td>{{$loop->iteration}}</td>
                        <td>{{$patient->number}}</td>
                        <td>{{$patient->fullname}}</td>
                        <td>{{$patient->id_no}}</td>
                        <td>
                            <a href="{{route('evaluation.review_patient',$patient->id)}}" class="btn btn-xs">
                                <i class="fa fa-deafness"></i> Review</a>
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
                $('table').DataTable({pageLength: 100});
            } catch (e) {
            }
        });
    </script>
@endsection