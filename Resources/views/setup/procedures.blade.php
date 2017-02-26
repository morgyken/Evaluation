<?php
/*
 * Collabmed Solutions Ltd
 * Project: iClinic
 * Author: Samuel Okoth <sodhiambo@collabmed.com>
 */
$procedure = $data['procedure'];
?>

@extends('layouts.app')
@section('content_title','Procedures')
@section('content_description','Add procedures')

@section('content')
<div class="form-horizontal">
    <div class="box box-info">
        {!! Form::model($procedure,['route'=>'evaluation.setup.procedures.save']) !!}
        {!! Form::hidden('id',$procedure->id) !!}
        <div class="box-body">
            <div class="col-md-6">
                <div class="form-group {{ $errors->has('name') ? ' has-error' : '' }} req">
                    {!! Form::label('name', 'Procedure Name',['class'=>'control-label col-md-4']) !!}
                    <div class="col-md-8">
                        {!! Form::text('name', old('name'), ['class' => 'form-control', 'placeholder' => 'Procedure Name']) !!}
                        {!! $errors->first('name', '<span class="help-block">:message</span>') !!}
                    </div>
                </div>
                <div class="form-group {{ $errors->has('code') ? ' has-error' : '' }} req">
                    {!! Form::label('code', 'Code',['class'=>'control-label col-md-4']) !!}
                    <div class="col-md-8">
                        {!! Form::text('code', old('code'), ['class' => 'form-control', 'placeholder' => 'Code']) !!}
                        {!! $errors->first('code', '<span class="help-block">:message</span>') !!}
                    </div>
                </div>

                <div class="form-group {{ $errors->has('category') ? ' has-error' : '' }} req">
                    {!! Form::label('category', 'Category',['class'=>'control-label col-md-4']) !!}
                    <div class="col-md-8">
                        {!! Form::select('category',get_procedure_categories(),old('category'), ['class' => 'form-control', 'placeholder' => 'Choose...']) !!}
                        {!! $errors->first('category', '<span class="help-block">:message</span>') !!}
                    </div>
                </div>
                <div class="form-group {{ $errors->has('description') ? ' has-error' : '' }}">
                    {!! Form::label('description', 'Description',['class'=>'control-label col-md-4']) !!}
                    <div class="col-md-8">
                        {!! Form::textarea('description', old('description'),
                        ['class' => 'form-control', 'placeholder' => 'Description ...','rows'=>3]) !!}
                        {!! $errors->first('description', '<span class="help-block">:message</span>') !!}
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group {{ $errors->has('cash_charge') ? ' has-error' : '' }}">
                    {!! Form::label('cash_charge', 'Cash Charge',['class'=>'control-label col-md-4']) !!}
                    <div class="col-md-8">
                        {!! Form::text('cash_charge', old('cash_charge'), ['class' => 'form-control', 'placeholder' => 'Cash Charge']) !!}
                        {!! $errors->first('cash_charge', '<span class="help-block">:message</span>') !!}
                    </div>
                </div>
                <div class="form-group {{ $errors->has('cash_charge_insurance') ? ' has-error' : '' }}">
                    {!! Form::label('cash_charge_insurance', 'Cash Charge applies to insurance?',['class'=>'control-label col-md-4']) !!}
                    <div class="col-md-8">
                        {!! Form::radio('cash_charge_insurance',1) !!} Yes
                        {!! Form::radio('cash_charge_insurance',0,true) !!} No
                        {!! $errors->first('cash_charge_insurance', '<span class="help-block">:message</span>') !!}
                    </div>
                </div>

                <div class="form-group {{ $errors->has('status') ? ' has-error' : '' }} req">
                    {!! Form::label('status', 'Status',['class'=>'control-label col-md-4']) !!}
                    <div class="col-md-8">
                        {!! Form::radio('status',1,true) !!} Active
                        {!! Form::radio('status',0) !!} Inactive
                        {!! $errors->first('status', '<span class="help-block">:message</span>') !!}
                    </div>
                </div>
                <div class="form-group {{ $errors->has('status') ? ' has-error' : '' }}">
                    {!! Form::label('precharge', 'Charge at Reception',['class'=>'control-label col-md-4']) !!}
                    <div class="col-md-8">
                        <input type="checkbox" name="precharge" value="1">
                    </div>
                </div>
            </div>
        </div>
        <div class="box-footer">
            <div class="pull-right">
                <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Save Procedure</button>
            </div>
        </div>
        {!! Form::close() !!}
    </div>
</div>
<div class="box box-info">
    <div class="box-header">
        <h3 class="box-title">Procedure Categories</h3>
    </div>
    <div class="box-body">
        <table class="table table-responsive table-condensed">
            <tbody>
                @foreach($data['procedures'] as $procedure)
                <tr>
                    <td>{{$procedure->name}}</td>
                    <td>{{$procedure->categories->name}}</td>
                    <td>{{$procedure->code}}</td>
                    <td>{{$procedure->cash_charge}}</td>
                    <td>
                        <a class="btn btn-primary btn-xs"
                           href="{{route('evaluation.setup.procedures',$procedure->id)}}">
                            <i class="fa fa-pencil-square-o"></i></a> |
                        <button class="btn btn-danger btn-xs delete" value="">
                            <i class="fa fa-trash-o"></i></button>
                    </td>
                </tr>
                @endforeach
            </tbody>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Category</th>
                    <th>Code</th>
                    <th>Cash Charge</th>
                    <th>Actions</th>
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

        }
    });
</script>
@endsection
