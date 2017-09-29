<?php
/*
 * Collabmed Solutions Ltd
 * Project: iClinic
 * Author: Samuel Okoth <sodhiambo@collabmed.com>
 */
?>

@extends('layouts.app')
@section('content_title','Procedure Categories')
@section('content_description','Add procedure categories')

@section('content')
<div class="box box-info">
    <div class="form-horizontal">
        {!! Form::open(['route'=>'evaluation.setup.procedure_cat.save']) !!}
        {!! Form::hidden('id',$data['model']->id) !!}
        <div class="box-body">
            <div class="col-md-6">
                <div class="form-group {{ $errors->has('name') ? ' has-error' : '' }} req">
                    {!! Form::label('name', 'Category Name',['class'=>'control-label col-md-4']) !!}
                    <div class="col-md-8">
                        {!! Form::text('name', old('name',$data['model']->name), ['class' => 'form-control', 'placeholder' => 'Category Name']) !!}
                        {!! $errors->first('name', '<span class="help-block">:message</span>') !!}
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group {{ $errors->has('applies_to') ? ' has-error' : '' }} req">
                    {!! Form::label('applies_to', 'Applies To',['class'=>'control-label col-md-4']) !!}
                    <div class="col-md-8">
                        {!! Form::select('applies_to',mconfig('evaluation.options.applies_to'), old('applies_to',$data['model']->applies_to), ['class' => 'form-control',]) !!}
                        {!! $errors->first('applies_to', '<span class="help-block">:message</span>') !!}
                    </div>
                </div>
            </div>
        </div>
        <div class="box-footer">
            <div class="pull-right">
                <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Save</button>
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
        <table class="table table-responsive table-condensed table-borderless table-striped">
            <tbody>
                @foreach($data['categories'] as $category)
                <tr id="row_id{{$category->id}}">
                    <td>{{$loop->iteration}}</td>
                    <td>{{$category->name}}</td>
                    <td>{{$category->applied_to}}</td>
                    <td>
                        <a class="btn btn-primary btn-xs"
                           href="{{route('evaluation.setup.procedure_cat',$category->id)}}" >
                            <i class="fa fa-pencil-square-o"></i></a> |
                        <button class="btn btn-danger btn-xs delete" value="{{$category->id}}">
                            <i class="fa fa-trash-o"></i></button>
                    </td>
                    <td>
                        @if($category->templates)
                        <a class="btn btn-success btn-xs"
                           href="{{route('evaluation.setup.procedure_cat.template',$category->id)}}" >
                            <i class="fa fa-pencil"></i> Edit</a>
                        @else
                        <a class="btn btn-primary btn-xs"
                           href="{{route('evaluation.setup.procedure_cat.template',$category->id)}}" >
                            <i class="fa fa-plus"></i> Create</a>
                        @endif
                    </td>
                    </td>
                </tr>
                @endforeach
            </tbody>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Category Name</th>
                    <th>Applies To</th>
                    <th>Actions</th>
                    <th>Result Template</th>
                </tr>
            </thead>
        </table>
    </div>
</div>

<div class="modal fade"  id="myModal" role="dialog">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Delete procedure category?</h4>
                </div>
                <div class="modal-body">
                    <p>Do you want to delete the procedure category</p>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-danger" id="delete" >Yes, I am sure</button>
                    <button class="btn btn-primary" data-dismiss="modal">No, ignore</button>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    var to_delete = null;
    $('.delete').click(function () {
        to_delete = $(this).val();
        $('#myModal').modal('show');
    });
    $('#delete').click(function () {
        if (!to_delete) {
            return;
        }
        id = to_delete;
        $.ajax({
            type: 'GET',
            //url: "route('ajax.delete_procedure_cat')",
            data: {'id': id},
            success: function () {
                $("#row_id" + id).remove();
            },
            error: function () {
                alert('Could not delete category. Please contact admin');
            }
        });
        $("#myModal").modal('hide');
    });
</script>
@endsection
