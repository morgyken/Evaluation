<?php
/*
 * Collabmed Solutions Ltd
 * Project: iClinic
 * Author: Bravo
 */
$id = null;
extract($data);
?>
@extends('layouts.app')
@section('content_title','Test Formulae')
@section('content_description','')

@section('content')
<!-- SELECT2 EXAMPLE -->
<div class="box box-default">
    <div class="box-header with-border">
        <h3 class="box-title">Test Formulae</h3>
        <div class="box-tools pull-right">
            <a class="btn btn-primary btn-sm" href="{{route('evaluation.setup.formulae')}}"><i class="fa fa-plus"></i> Create New</a>
        </div>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
        {!! Form::open(['method'=>'post']) !!}
        {!! Form::hidden('id',old('id',$item->id)) !!}
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>Procedure *</label>
                    {!! Form::select('procedure_id',get_parent_procedures(),$item->procedure?$item->procedure_id:'', ['id' => 'select','class' => 'form-control procedure_select', 'placeholder' => 'Choose...']) !!}
                    {!! $errors->first('procedure_id', '<span class="help-block">:message</span>') !!}
                </div>
                <!-- /.form-group -->
                <div class="form-group">
                    <label>Test</label>
                    {!! Form::select('test_id',get_parent_procedures(),$item->test_id?$item->test_id:'', ['id' => 'tests','class' => 'form-control procedure_select', 'placeholder' => 'Choose...']) !!}
                    {!! $errors->first('test_id', '<span class="help-block">:message</span>') !!}
                </div>
                <!-- /.form-group -->
            </div>
            <!-- /.col -->
            <div class="col-md-6">
                <div class="form-group">
                    <label>Formula</label>
                    <input type="text" name="formula" value="{{$item->formula}}" class="form-control" placeholder="Formula i.e P1+P2">
                    {!! $errors->first('formula', '<span class="help-block">:message</span>') !!}
                </div>
                <!-- /.form-group -->
                <div class="form-group">
                    <label>Tip: Formulae follow Excel format (C is replaced with P for Procedure)</label>
                    <p>
                        <span class="help-block">
                            Use procedure id's to represent procedures in formulae. Search Procedure id's here, indicated in brackets.
                            <select id="ids">
                                <?php foreach (get_parent_procedures() as $key => $value) { ?>
                                    <option>{{$value}}<strong> ({{$key}})</strong></option>
                                <?php } ?>
                            </select>
                        </span>
                    </p>
                </div>
                <!-- /.form-group -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </div>
    <!-- /.box-body -->
    <div class="box-footer">
        <div class="pull-right">
            <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Save</button>
        </div>
    </div>
    {!! Form::close() !!}
</div>
<!-- /.box -->
<div class="box box-info">
    <div class="box-header">
        <h3 class="box-title">Saved Formula</h3>
    </div>
    <div class="box-body">
        <table class="table table-responsive table-condensed table-borderless table-striped">
            <tbody>
                @foreach($items as $item)
                <tr id="row_id{{$item->id}}">
                    <td>{{$loop->iteration}}</td>
                    <td>{{$item->procedure?$item->procedure->name:''}}</td>
                    <td>{{$item->test?$item->test->name:''}}</td>
                    <td>{{$item->formula}}</td>
                    <td>
                        <a class="btn btn-primary btn-xs"
                           href="{{route('evaluation.setup.formulae',$item->id)}}" >
                            <i class="fa fa-pencil-square-o"></i></a>
                        <!--|
                        <button class="btn btn-danger btn-xs delete" value="{{$item->id}}">
                            <i class="fa fa-trash-o"></i></button>
                        -->
                    </td>
                </tr>
                @endforeach
            </tbody>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Procedure</th>
                    <th>Test</th>
                    <th>Formula</th>
                    <th>Actions</th>
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
                    <h4 class="modal-title">Delete ranges?</h4>
                </div>
                <div class="modal-body">
                    <p>Do you want to delete the ranges?</p>
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
    $(document).ready(function () {
        $("#select").select2();
        $("#tests").select2();
        $("#ids").select2();
        $("table").DataTable();
        $('#lg').hide();
        $('#range').hide();
        var ref = $('#type').val();
        toggle_type(ref);
    });

    $('#type').change(function () {
        var type = $(this).val();
        toggle_type(type)
    });

    $('#type').click(function () {
        var type = $(this).val();
        toggle_type(type)
    });


    function toggle_type(type) {
        if (!(type === 'range')) {
            $('#lg').show();
            $('#range').hide();
        } else {
            $('#range').show();
            $('#lg').hide();
        }
    }


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
            url: "{{route('api.evaluation.del.title')}}",
            data: {'id': id},
            success: function () {
                $("#row_id" + id).remove();
            },
            error: function () {
                alert('Could not delete. Please contact admin');
            }
        });
        $("#myModal").modal('hide');
    });
</script>
<script src="{!! m_asset('evaluation:js/mentions/jquery.mentionsInput.js') !!}" type='text/javascript'></script>
@endsection
