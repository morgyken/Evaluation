<?php
/**
 * Created by PhpStorm.
 * User: bravoh
 * Date: 9/17/17
 * Time: 10:42 AM
 */
?>
@extends('layouts.app')
@section('content_title','Review Patient Visits')
@section('content_description','Review previous visits')

@section('content')

    <div class="box box-info">
        <div class="box-header">
            <h3 class="box-title">Select a patient to proceed</h3>
            <a href="{{route('reception.add_patient')}}" class="btn btn-xs btn-primary pull-right">New Patient</a>
        </div>
        <div class="box-body">
            @if($data['patients'])
                <table class="table table-striped table-condensed">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Patient</th>
                        <th>ID No</th>
                        <th>Mobile</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($data['patients'] as $patient)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{$patient->fullname}}</td>
                            <td>{{$patient->mobile}}</td>
                            <td>{{$patient->id_no}}</td>
                            <td>
                                <a href="{{route('evaluation.exdoctor.order.make',$patient->id)}}" class="btn btn-xs btn-primary">
                                    <i class="fa fa-deafness"></i> Order Procedure</a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            @else
                <p>Nothing to show</p>
            @endif
        </div>
        <div class="box-footer">
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
