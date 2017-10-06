<?php
/**
 * Created by PhpStorm.
 * User: bravoh
 * Date: 10/6/17
 * Time: 12:06 PM
 */
$id = null;
extract($data);
?>
@extends('layouts.app')
@section('content_title','Age Groups')
@section('content_description','Patient Age Groups')

@section('content')
    <div class="box box-info">
        <div class="form-horizontal">
            {!! Form::open(['method'=>'post']) !!}
            {!! Form::hidden('id',old('id',$item->id)) !!}
            <div class="col-md-12">
                <!-- /.box-header -->
                <div class="box-body">
                    <!-- text input -->
                    <div class="form-group">
                        <label>Name (Optional)</label>
                        {!! Form::text('name', old('name',$item->name), ['class' => 'form-control', 'placeholder' => 'Name']) !!}
                        {!! $errors->first('name', '<span class="help-block">:message</span>') !!}
                    </div>
                    <div class="form-group">
                        <label>Age group type (Range, <> or General)</label>
                        {!! Form::select('type',mconfig('evaluation.options.age_group_types'),null, ['id' => 'type','class' => 'form-control', 'placeholder' => 'Choose...']) !!}
                        {!! $errors->first('type', '<span class="help-block">:message</span>') !!}
                    </div>

                    <table class="table table-striped" id="range">
                        <tr>
                            <th colspan="2"><label>Lower and Upper Range Limits</label></th>
                            <th><label>Age in</label></th>
                        </tr>
                        <tr>
                            <td>
                                <input type="text" value="" name="lower" class="form-control" placeholder="lower limit">
                                {!! $errors->first('lower', '<span class="help-block">:message</span>') !!}
                            </td>
                            <td>
                                <input type="text" value="" name="upper" class="form-control" placeholder="upper limit">
                                {!! $errors->first('upper', '<span class="help-block">:message</span>') !!}
                            </td>
                            <td>

                                {!! Form::select('age_in',mconfig('evaluation.options.age_in'),null, ['id' => 'select','class' => 'form-control', 'placeholder' => 'Choose...']) !!}
                                {!! $errors->first('age_in', '<span class="help-block">:message</span>') !!}
                            </td>
                        </tr>
                    </table>

                    <table class="table table-striped" id="lg">
                        <tr>
                            <th colspan="2"><label>Less-than or Greater-than value</label></th>
                            <th><label>Age in</label></th>
                        </tr>
                        <tr>
                            <td>
                                {!! Form::select('lg_type',mconfig('evaluation.options.lg_type'),null, ['id' => 'select','class' => 'form-control', 'placeholder' => 'Choose...']) !!}
                                {!! $errors->first('lg_type', '<span class="help-block">:message</span>') !!}
                            </td>
                            <td>
                                <input type="text" name="lg_value" value="" class="form-control" placeholder="Value">
                                {!! $errors->first('lg_value', '<span class="help-block">:message</span>') !!}
                            </td>
                            <td>
                                {!! Form::select('age_in',mconfig('evaluation.options.age_in'),null, ['id' => 'select','class' => 'form-control', 'placeholder' => 'Choose...']) !!}
                                {!! $errors->first('age_in', '<span class="help-block">:message</span>') !!}
                            </td>
                        </tr>
                    </table>

                    <table class="table table-striped" id="general">
                        <tr>
                            <th><label>General Age Group ie Adult, Child etc</label></th>
                        </tr>
                        <tr>
                            <td>
                                <input type="text" name="general" value="" class="form-control" placeholder="">
                                {!! $errors->first('other', '<span class="help-block">:message</span>') !!}
                            </td>
                        </tr>
                    </table>
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
                    <table class="table table-striped" id="data">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Code</th>
                            <th>Name</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($groups as $item)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>{{$item->code}}</td>
                                <td>{{$item->name}}</td>
                                <td>
                                    <a class="btn btn-success btn-xs"
                                       href="{{route('evaluation.setup.age_groups',$item->id)}}" >
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
            $('#data').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    'excel', 'pdf', 'print'
                ]
            });

            $('#lg').hide();
            $('#range').hide();
            $('#general').hide();
            var ref = $('#type').val();
            toggle_type(ref);


            $('#type').change(function () {
                var type = $(this).val();
                toggle_type(type)
            });

            $('#type').click(function () {
                var type = $(this).val();
                toggle_type(type)
            });

            function toggle_type(type){
                if(type==='general'){
                    $('#range').hide();
                    $('#lg').hide();
                    $('#general').show();
                }else{
                    $('#general').hide();
                    if((type==='range')){
                        $('#range').show();
                        $('#lg').hide();
                        $('#other').hide();
                    }if(type==='less_greater'){
                        $('#range').hide();
                        $('#lg').show();
                        $('#other').hide();
                    }
                }
            }
        });
    </script>
@endsection
