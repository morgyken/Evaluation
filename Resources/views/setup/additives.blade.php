<?php
/**
 * Created by PhpStorm.
 * User: bravo
 * Date: 8/2/17
 * Time: 10:23 AM
 */
$id = null;
extract($data);
?>
@extends('layouts.app')
@section('content_title','Additives/Container')
@section('content_description','')

@section('content')
    <div class="box box-info">
        <div class="form-horizontal">
            {!! Form::open(['method'=>'post']) !!}
            <div class="col-md-12">
                <!-- /.box-header -->
                <div class="box-body">
                    <!-- text input -->
                    <div class="form-group req">
                        <label>Name</label>
                        {!! Form::text('name', old('name',$data['additive']->name), ['class' => 'form-control', 'placeholder' => 'Name']) !!}
                        {!! Form::hidden('id', old('id',$data['additive']->id)) !!}
                        {!! $errors->first('name', '<span class="help-block">:message</span>') !!}
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
                            <th>Name</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($additives as $item)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>{{$item->name}}</td>
                                <td>
                                    <a class="btn btn-success btn-xs"
                                       href="{{route('evaluation.setup.additives',$item->id)}}" >
                                        <i class="fa fa-pencil"></i> Edit</a>
                                </td>
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
