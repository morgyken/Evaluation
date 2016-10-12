<?php
/*
 * Collabmed Solutions Ltd
 * Project: iClinic
 *  Author: Samuel Okoth <sodhiambo@collabmed.com>
 */
extract($data);
$__visits = $patient->visits;
?>
@extends('layouts.app')
@section('content_title','Receive Payments')
@section('content_description','Receive payments from patients')

@section('content')
{!! Form::open(['id'=>'payForm','route'=>'evaluation.finance.pay.save'])!!}
<div class="box box-info">
    <div class="box-body">
        <div class="col-md-6">
            Patient Name: <strong>{{$patient->full_name}}</strong>
            <hr/>
            <h4>Select procedures for payment<span class="pull-right" id="total"></span></h4>
            @if(!empty($__visits))
            <div id="accordion">
                @foreach($__visits as $visit)
                <h3>{{(new Date($visit->created_at))->format('dS M y g:i a')}} -
                    Clinic {{$visit->clinics->name}}</h3>
                <div id="visit{{$visit->id}}">
                    <table class="table table-condensed" id="paymentsTable">
                        <tbody>
                            @foreach($visit->treatments as $item)
                            <tr>
                                @if($item->is_paid)
                                <td><input type="checkbox" disabled/></td>
                                <td>
                                    <div class="label label-success">Paid</div>
                                    {{$item->procedures->name}} <i class="small">(Treatment)</i> -
                                    Ksh {{$item->price}}
                                </td>
                                @else
                                <td><input type="checkbox" value="{{$item->procedure}}"
                                           name="pay{{$item->procedure}}" class="group"/>
                                    <input type="hidden" name="payVisit{{$item->procedure}}"
                                           value="{{$visit->id}}"></td>
                                <td>{{$item->procedures->name}} <i class="small">(Treatment)</i>- Ksh <span
                                        class="topay">{{$item->price}}</span>
                                </td>
                                @endif
                            </tr>
                            @endforeach
                            @foreach($visit->investigations as $item)
                            <tr>
                                @if($item->is_paid)
                                <td><input type="checkbox" disabled/></td>
                                <td>
                                    <div class="label label-success">Paid</div>
                                    {{$item->procedures->name}} <i class="small">({{ucwords($item->type)}})</i> -
                                    Ksh {{$item->price}}
                                </td>
                                @else
                                <td><input type="checkbox" value="{{$item->test}}"
                                           name="pay{{$item->test}}" class="group"/>
                                    <input type="hidden" name="payVisit{{$item->test}}"
                                           value="{{$visit->id}}"></td>
                                <td>{{$item->procedures->name}} <i class="small">({{ucwords($item->type)}})</i> -
                                    Ksh <span class="topay">{{$item->price}}</span></td>
                                @endif
                            </tr>

                            @endforeach
                        </tbody>

                    </table>
                </div>
                @endforeach
            </div>
            @else
            <div class="alert alert-info">
                <i class="fa fa-info"></i> This patient has not been billed.
                Click <a href="{{route('finance.receive_payments')}}">here </a> for a list of patient with
                pending bills.
            </div>
            @endif
        </div>
        <div class="col-md-6">
            @include('evaluation::finance.form')
        </div>
    </div>
    <div class="box-footer">
        <div class="pull-left">
            <button class="btn btn-primary" type="submit"><i class="fa fa-save"></i> Save</button>
        </div>
    </div>
</div>
{!! Form::close()!!}
<script src="{{m_asset('evaluation:js/payments.min.js')}}"></script>
<style type="text/css">
    #visits tbody tr.highlight {
        background-color: #B0BED9;
    }
</style>
@endsection