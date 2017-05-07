<?php
/*
 * Collabmed Solutions Ltd
 * Project: iClinic
 * Author: Samuel Okoth <sodhiambo@collabmed.com>
 */
$procedure = $data['procedure'];
?>

@extends('layouts.app')
@section('content_title','Templates')
@section('content_description','Add templates')

@section('content')

@if($procedure->id)
<div class="form-horizontal">
    <div class="box box-info">
        <div class="box-header">
            <h3 class="box-title">Create/Edit Template</h3>
        </div>
        {!! Form::open() !!}
        {!! Form::hidden('procedure',$procedure->id) !!}
        @if($procedure->templates)
        {!! Form::hidden('template_id',$procedure->templates->id) !!}
        @endif
        <div class="box-body">
            <div class="col-md-10">

                <div class="form-group {{ $errors->has('procedure') ? ' has-error' : '' }}">
                    {!! Form::label('name', 'Procedure',['class'=>'control-label col-md-4']) !!}
                    <div class="col-md-8">
                        <p>
                            {{$procedure->name}}
                        </p>
                    </div>
                </div>

                <div class="form-group {{ $errors->has('template') ? ' has-error' : '' }} req">
                    {!! Form::label('template', 'Template',['class'=>'control-label col-md-4']) !!}
                    <div class="col-md-8">
                        <textarea rows="5" name="template" class="form-control">{{$procedure->templates?$procedure->templates->template:''}}</textarea>
                        {!! $errors->first('template', '<span class="help-block">:message</span>') !!}
                    </div>
                </div>
            </div>
        </div>
        <div class="box-footer">
            <div class="pull-right">
                <button type="submit" class="btn btn-primary">
                    <i class="fa fa-save"></i> Save Template
                </button>
            </div>
        </div>
        {!! Form::close() !!}
    </div>
</div>
@endif

<div class="box box-info">
    <div class="box-header">
        <h3 class="box-title">Manage Procedure Templates</h3>
    </div>
    <div class="box-body">
        <table id="data" class="table table-responsive table-condensed table-striped">
            <tbody>
                @foreach($data['procedures'] as $p)
                <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>{{$p->name}}</td>
                    <td>{{$p->categories->name}}</td>
                    <td>
                        @if($p->templates)
                        <a class="btn btn-success btn-xs"
                           href="{{route('evaluation.setup.template',$p->id)}}">
                            <i class="fa fa-pencil"></i> Edit</a>
                        @else
                        <a class="btn btn-primary btn-xs"
                           href="{{route('evaluation.setup.template',$p->id)}}">
                            <i class="fa fa-plus"></i> Create</a>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Procedure</th>
                    <th>Category</th>
                    <th>Manage Template</th>
                </tr>
            </thead>
        </table>
    </div>
</div>
<script type="text/javascript">
    $(function () {
        CKEDITOR.replaceAll();

        $('table').DataTable({});
    });
</script>
@endsection
