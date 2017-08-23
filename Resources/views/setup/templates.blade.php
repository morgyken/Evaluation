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
<div class="box box-info">
    <div class="box-header">
        <h3 class="box-title">Create or Edit Procedure Template</h3>
    </div>
    <div class="box-body">
        <div class="row show-grid">
            <div class="col-md-7">
                {!! Form::open() !!}
                {!! Form::hidden('procedure',$procedure->id) !!}
                @if($procedure->templates)
                {!! Form::hidden('template_id',$procedure->templates->id) !!}
                @endif
                <div class="form-group {{ $errors->has('procedure') ? ' has-error' : '' }}">
                    {!! Form::label('name', 'Procedure',['class'=>'control-label col-md-4']) !!}
                    <div class="col-md-8">
                        <p>{{$procedure->name}}</p>
                    </div>
                </div>
                @if($procedure->templates_lab)
                <?php
                $saved = get_lab_templates($procedure->id)
                ?>
                <div class="form-group {{ $errors->has('existing') ? ' has-error' : '' }}">
                    {!! Form::label('template', 'Tests',['class'=>'control-label col-md-4']) !!}
                    <div class="col-md-8">
                        <p id="feedback" class="label label-primary"></p>
                        <table class="table table-striped table-condensed">
                            <tr>
                                <th>#</th>
                                <th>Test</th>
                                <th>Title</th>
                                <th></th>
                            </tr>
                            @foreach($saved as $s)
                            <tr id="row{{$s->id}}">
                                <td>{{$loop->iteration}}</td>
                                <td>{{$s->subtests->name}} {{($s->subtests->id)}}</td>
                                <td>{{$s->titles?$s->titles->name:''}}</td>
                                <td>
                                    <a href="#" onclick="delete_test(<?php echo $s->id ?>)"style="color: red"><i class="fa fa-trash"></i></a>
                                </td>
                            </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
                @endif
                <div class="form-group {{ $errors->has('template') ? ' has-error' : '' }}">
                    {!! Form::label('template', 'Template',['class'=>'control-label col-md-4']) !!}
                    <div class="col-md-8">
                        @if($procedure->categories->name !== 'Lab')
                        <textarea rows="5" name="template" class="form-control">
                                    {{$procedure->templates?$procedure->templates->template:''}}
                        </textarea>
                        {!! $errors->first('template', '<span class="help-block">:message</span>') !!}
                        @else
                        @include('evaluation::partials.labs.more_blueprints')
                        @endif
                    </div>
                </div>
                </br>
                <div class="box-footer">
                    <div class="pull-right">
                        <button type="submit" class="btn btn-primary btn-xs">
                            <i class="fa fa-save"></i> Save Template
                        </button>
                    </div>
                </div>
                {!! Form::close() !!}
            </div>

            <div class="col-md-4">
                <p>
                    Templates created here apply to tests with children/subtests such as CBC.
                </p>
                <p>Appropriate input fields (based on the saved result type) will be picked for tests with with no sub-tests</p>
            </div>
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
                        <td>{{$p->id}}</td>
                        <td>{{$p->categories->name}}</td>
                        <td>
                            @if($p->templates || $p->templates_lab)
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
                        <th>Procedure ID</th>
                        <th>Category</th>
                        <th>Manage Template</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
    <script type="text/javascript">
        var DELETE_URL = "{{route('api.evaluation.delete_lab_template_test')}}";
        $(function () {
            CKEDITOR.replaceAll();
            $('#data').DataTable({});
        });

        function delete_test(id) {
            $.ajax({
                url: DELETE_URL,
                data: {'id': id},
                success: function () {
                    //$('#feedback').html(data);
                    $("#row" + id).remove();
                }});
        }
    </script>
    @endsection
