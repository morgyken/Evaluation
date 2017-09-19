<?php
/**
 * Created by PhpStorm.
 * User: bravo
 * Date: 8/25/17
 * Time: 4:26 PM
 */
extract($data);
?>
@extends('layouts.app')
@section('content_title','Test Critical Values')
@section('content_description','')

@section('content')
    <!-- SELECT2 EXAMPLE -->
    <div class="box box-default">
        <div class="box-header with-border">
            <h3 class="box-title">Critical Values</h3>
            <div class="box-tools pull-right">
                <a class="btn btn-primary btn-sm" href="{{route('evaluation.setup.critical_values')}}"><i class="fa fa-plus"></i> Create New</a>
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
                        {!! Form::select('procedure',get_parent_procedures(),$item->procedure?$item->procedure:'', ['id' => 'select','class' => 'form-control procedure_select', 'placeholder' => 'Choose...']) !!}
                        {!! $errors->first('procedure', '<span class="help-block">:message</span>') !!}
                    </div>
                    <!-- /.form-group -->
                    <div class="form-group">
                        <label>Critical When</label>
                        {!! Form::select('type',mconfig('evaluation.options.critical_value_types'),$item->type?$item->type:'', ['id' => 'select','class' => 'form-control', 'placeholder' => 'Choose...']) !!}
                        {!! $errors->first('type', '<span class="help-block">:message</span>') !!}
                    </div>
                    <!-- /.form-group -->
                </div>
                <!-- /.col -->
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Critical Value</label>
                        <input type="text" value="{{$item->critical_value}}" name="critical_value" class="form-control" placeholder="Critical Value">
                        {!! $errors->first('critical_value', '<span class="help-block">:message</span>') !!}
                    </div>
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
            <h3 class="box-title">Saved Records</h3>
        </div>
        <div class="box-body">
            <table class="table table-responsive table-condensed table-borderless table-striped">
                <tbody>
                <?php
                $types = mconfig('evaluation.options.critical_value_types');
                ?>
                @if(!empty($items))
                @foreach($items as $item)
                    <tr id="row_id{{$item->id}}">
                        <td>{{$loop->iteration}}</td>
                        <td>{{$item->procedures?$item->procedures->name:''}}</td>
                        <td>{{$item->critical_value}}</td>
                        <td>{{$item->type?$types[$item->type]:''}}</td>
                        <td>
                            <a class="btn btn-primary btn-xs"
                               href="{{route('evaluation.setup.ranges',$item->id)}}" >
                                <i class="fa fa-pencil-square-o"></i></a>|
                            <button class="btn btn-danger btn-xs delete" value="{{$item->id}}">
                                <i class="fa fa-trash-o"></i></button>
                        </td>
                    </tr>
                @endforeach
                @endif
                </tbody>
                <thead>
                <tr>
                    <th>#</th>
                    <th>Procedure</th>
                    <th>Critical Value</th>
                    <th>Type (Critical When?)</th>
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
                        <h4 class="modal-title">Delete Item?</h4>
                    </div>
                    <div class="modal-body">
                        <p>Do you want to delete this item?</p>
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


        function toggle_type(type){
            if(!(type==='range')){
                $('#lg').show();
                $('#range').hide();
            }else{
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
                url: "{{route('api.evaluation.del_critical_value')}}",
                data: {'id': id,'type': 'CriticalValues'},
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

