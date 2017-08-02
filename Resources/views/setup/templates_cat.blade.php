<?php
$category = $data['category'];
?>

@extends('layouts.app')
@section('content_title','Manage Procedure Category Templates')

@section('content')

@if($category->id)
<div class="form-horizontal">
    <div class="box box-info">
        <div class="box-header">
            <h3 class="box-title"></h3>
        </div>
        {!! Form::open() !!}
        {!! Form::hidden('category',$category->id) !!}
        @if($category->templates)
        {!! Form::hidden('template_id',$category->templates->id) !!}
        @endif
        <div class="box-body">
            <div class="col-md-10">

                <div class="form-group {{ $errors->has('category') ? ' has-error' : '' }}">
                    {!! Form::label('name', 'Procedure Category',['class'=>'control-label col-md-4']) !!}
                    <div class="col-md-8">
                        <p>
                            {{$category->name}}
                        </p>
                    </div>
                </div>

                <div class="form-group {{ $errors->has('template') ? ' has-error' : '' }} req">
                    {!! Form::label('template', 'Template',['class'=>'control-label col-md-4']) !!}
                    <div class="col-md-8">
                        <textarea rows="5" name="template" class="form-control">{{$category->templates?$category->templates->template:''}}</textarea>
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
        <h3 class="box-title">Added Templates</h3>
    </div>
    <div class="box-body">
        <table id="data" class="table table-responsive table-condensed table-striped">
            <tbody>
                @foreach($data['categories'] as $c)
                <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>{{$c->name}}</td>
                    <td>
                        @if($c->templates)
                        <a class="btn btn-success btn-xs"
                           href="{{route('evaluation.setup.procedure_cat.template',$c->id)}}">
                            <i class="fa fa-pencil"></i> Edit</a>
                        @else
                        <a class="btn btn-primary btn-xs"
                           href="{{route('evaluation.setup.procedure_cat.template',$c->id)}}">
                            <i class="fa fa-plus"></i> Create</a>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
            <thead>
                <tr>
                    <th>#</th>
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
