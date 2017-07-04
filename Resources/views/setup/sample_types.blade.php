<?php
/**
 * Created by PhpStorm.
 * User: bravo
 * Date: 7/4/17
 * Time: 1:45 PM
 */
?>


@extends('layouts.app')
@section('content_title','Samples')
@section('content_description','')

@section('content')
    <div class="box box-info">
        <div class="form-horizontal">
            {!! Form::open(['route'=>'']) !!}
            {!! Form::hidden('id',$data['type']->id) !!}
            <div class="col-md-12">
                <!-- /.box-header -->
                <div class="box-body">
                    <form role="form">
                        <!-- text input -->
                        <div class="form-group req">
                            <label>Name</label>
                            {!! Form::text('name', old('name',$data['tit']->name), ['class' => 'form-control', 'placeholder' => 'Name']) !!}
                            {!! $errors->first('name', '<span class="help-block">:message</span>') !!}
                        </div>
                        <div class="form-group">
                            <label>Procedure</label>
                            {!! Form::select('type',get_parent_procedures(),$data['tit']->procedure, ['id' => 'select','class' => 'form-control procedure_select', 'placeholder' => 'Choose...']) !!}
                            {!! $errors->first('type', '<span class="help-block">:message</span>') !!}
                        </div>
                        <!-- textarea -->
                        <div class="form-group">
                            <label>Details</label>
                            <textarea class="form-control" name="details" rows="3" placeholder="Enter ..."></textarea>
                            {!! $errors->first('details', '<span class="help-block">:message</span>') !!}
                        </div>
                    </form>
                </div>
                <!-- /.box-body -->
            </div>

            <div class="box-footer">
                <div class="pull-right">
                    <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Save</button>
                </div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
@endsection
