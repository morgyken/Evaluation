<?php
/*
 * Collabmed Solutions Ltd
 * Project: iClinic
 *  Author: Samuel Okoth <sodhiambo@collabmed.com>
 */
extract($data)
?>
@extends('layouts.app')
@section('content_title','Order Procedures')
@section('content_description','Review previous visits')

@section('content')

<div class="box box-info">
    <div class="box-header">
        <h3 class="box-title">Order procedures for {{$patient->full_name}}</h3>
    </div>
    <div class="box-body">
        <div class="nav-tabs-custom">
            <ul id="tabs" class="nav nav-tabs">
                <li class="active">
                    <a href="#new" data-toggle="tab">
                        Order New
                        <span class="badge alert-info">new</span>
                    </a>
                </li>
                <li>
                    <a href="#ordered" data-toggle="tab">
                        Ordered<span class="badge alert-success">{{$orders->count()}}</span>
                    </a>
                </li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane active " id="new">
                    {!! Form::open(['id'=>'external_order_form'])!!}
                    {!! Form::hidden('patient_id',$patient->id) !!}
                    {!! Form::hidden('institution',$institution) !!}
                    @include('evaluation::external.procedures')
                    {!! Form::close()!!}
                </div>
                <div class="tab-pane" id="ordered">
                    @if($orders->count()>0)
                    <table class="table table-striped table-condensed" id="data">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Order Id</th>
                                <th>By</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($data['orders'] as $order)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>00{{$order->id}}</td>
                                <td>{{$order->users->profile->full_name}}</td>
                                <td>{{$order->created_at}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @else
                    Nothing to show.
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="box-footer">
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        try {
            $('#data').DataTable();
        } catch (e) {
        }
    });
</script>
@endsection