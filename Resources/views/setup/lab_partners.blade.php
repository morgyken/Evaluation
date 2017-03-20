<?php
/*
 * =============================================================================
 *
 * Collabmed Solutions Ltd
 * Project: iClinic
 * Author: Samuel Okoth <sodhiambo@collabmed.com>
 *
 * =============================================================================
 */
?>

@extends('layouts.app')

@section('content_title','View Partner Institutions')
@section('content_description','Manage Partner Institutions')

@section('content')
<div class="box box-info">
    <div class="box-header with-border">
        <h3 class="box-title">
            <a class="btn btn-primary btn-xs" href="{{route('evaluation.setup.manage_partners')}}">
                <i class="fa fa-plus-square"></i> Create Partner Institution
            </a> </h3>
    </div>
    <div class="box-body">
        <div class="row">
            <div class="col-md-12">
                @if(!$data['partners']->isEmpty())
                <table class="table table-responsive table-striped">
                    <tbody>
                        @foreach($data['partners'] as $partner)
                        <tr id="partner{{$partner->id}}">
                            <td>{{$partner->id}}</td>
                            <td>{{$partner->name}}</td>
                            <td>{{$partner->telephone}}</td>
                            <td>{{$partner->email}}</td>
                            <td>{{$partner->address}} {{$partner->post_code}} {{$partner->town}}</td>
                            <td>
                                <a href="{{route('evaluation.setup.manage_partners',$partner->id)}}"
                                   class="btn btn-primary btn-xs">
                                    <i class="fa fa-edit"></i> Edit</a> <!--|
                                <button class="btn btn-danger btn-xs delete" value="{{$partner->id}}">
                                    <i class="fa fa-trash-o"></i> Delete
                                </button>-->
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Institution</th>
                            <th>Mobile</th>
                            <th>Email</th>
                            <th>Address</th>
                            <th></th>
                        </tr>
                    </thead>
                </table>
                @else
                <div class="alert alert-info">
                    <p>No partner institutions added</p>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection