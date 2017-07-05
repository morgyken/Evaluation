<?php
/**
 * Created by PhpStorm.
 * User: bravo
 * Date: 7/4/17
 * Time: 1:45 PM
 */
$id = null;
extract($data);
?>
@extends('layouts.app')
@section('content_typele','Samples')
@section('content_description','Sample Type')

@section('content')
    <div class="box box-info">
        <div class="form-horizontal">
            {!! Form::open(['method'=>'post']) !!}
            {!! Form::hidden('id',$id) !!}
            <div class="col-md-12">
                <!-- /.box-header -->
                <div class="box-body">
                        <!-- text input -->
                        <div class="form-group req">
                            <label>Name</label>
                            {!! Form::text('name', old('name',$data['type']->name), ['class' => 'form-control', 'placeholder' => 'Name']) !!}
                            {!! $errors->first('name', '<span class="help-block">:message</span>') !!}
                        </div>
                        <div class="form-group">
                            <label>Procedure</label>
                            {!! Form::select('procedure',get_parent_procedures(),$data['type']->procedure, ['id' => 'select','class' => 'form-control procedure_select', 'placeholder' => 'Choose...']) !!}
                            {!! $errors->first('type', '<span class="help-block">:message</span>') !!}
                        </div>
                        <!-- textarea -->
                        <div class="form-group">
                            <label>Details</label>
                            <textarea class="form-control" name="details" rows="3" placeholder="Enter ..."></textarea>
                            {!! $errors->first('details', '<span class="help-block">:message</span>') !!}
                        </div>
                </div>
                <!-- /.box-body -->
            </div>
            <div class="box-footer">
                <div class="pull-right">
                    <input class="btn btn-primary" type="submit" value="Save">
                </div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>

    <div class="box box-success">
        <div class="form-horizontal">
            <div class="col-md-12">
                <!-- /.box-header -->
                <div class="box-body">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Sample Type</th>
                            <th>Procedure</th>
                            <th>Details</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($types as $item)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{$item->name}}</td>
                            <td>{{$item->procedure}}</td>
                            <td>{{$item->details}}</td>
                            <td></td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- /.box-body -->
            </div>
            <div class="box-footer">
            </div>
        </div>
    </div>
    <script type="text/javascript">
        $(document).ready(function () {
            $('table').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    'excel', 'pdf', 'print'
                ]
            });
        });
    </script>
@endsection
