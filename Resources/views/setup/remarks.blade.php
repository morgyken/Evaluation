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
@section('content_title','Procedure Remarks Templates')
@section('content_description','')

@section('content')
    <div class="box box-info">
        <div class="form-horizontal">
            {!! Form::open(['method'=>'post']) !!}
            {!! Form::hidden('id',old('id',$remark->id)) !!}
            <div class="box-body">
                <div class="col-md-4">
                    <div class="form-group {{ $errors->has('parent') ? ' has-error' : '' }}">
                        {!! Form::label('procedure', 'Procedure',['class'=>'control-label col-md-4']) !!}
                        <div class="col-md-8">
                            {!! Form::select('procedure',get_parent_procedures(),$remark->procedure?$remark->procedure:'', ['id' => 'select','class' => 'form-control procedure_select', 'placeholder' => 'Choose...']) !!}
                            {!! $errors->first('procedure', '<span class="help-block">:message</span>') !!}
                        </div>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="form-group {{ $errors->has('remarks') ? ' has-error' : '' }} req">
                        {!! Form::label('remarks', 'Remarks',['class'=>'control-label col-md-2']) !!}
                        <div class="col-md-10">
                            {!! Form::textarea('remarks', old('remarks',$data['remark']->remarks), ['class' => 'form-control', 'placeholder' => 'Remarks']) !!}
                            {!! $errors->first('remarks', '<span class="help-block">:message</span>') !!}
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
            <h3 class="box-title">Remarks Templates</h3>
        </div>
        <div class="box-body">
            <table class="table table-responsive table-condensed table-borderless table-striped">
                <tbody>
                @foreach($remarks as $item)
                    <tr id="row_id{{$item->id}}">
                        <td>{{$loop->iteration}}</td>
                        <td>{{$item->remarks}}</td>
                        <td>{{$item->procedures?$item->procedures->name:''}}</td>
                        <td>
                            <a class="btn btn-primary btn-xs"
                               href="{{route('evaluation.setup.remarks',$item->id)}}" >
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
                    <th>Remarks</th>
                    <th>Procedure</th>
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
                        <h4 class="modal-title">Delete Remarks?</h4>
                    </div>
                    <div class="modal-body">
                        <p>Do you want to delete the remarks?</p>
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
        $(function () {
            CKEDITOR.replaceAll();
            $('table').DataTable({});
        });

        $(document).ready(function () {
            $("#select").select2();
            $("table").DataTable();
        });
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
@endsection
