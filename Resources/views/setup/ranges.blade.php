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
@section('content_title','Procedure Ranges')
@section('content_description','')

@section('content')
        <!-- SELECT2 EXAMPLE -->
<div class="box box-default">
    <div class="box-header with-border">
        <h3 class="box-title">Reference Ranges</h3>
        <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
        </div>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
        {!! Form::open(['method'=>'post']) !!}
        {!! Form::hidden('id',old('id',$range->id)) !!}
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>Procedure *</label>
                    {!! Form::select('procedure',get_parent_procedures(),$range->procedure?$range->procedure:'', ['id' => 'select','class' => 'form-control procedure_select', 'placeholder' => 'Choose...']) !!}
                    {!! $errors->first('procedure', '<span class="help-block">:message</span>') !!}
                </div>
                <!-- /.form-group -->
                <div class="form-group">
                    <label>Age Group</label>
                    {!! Form::select('age',mconfig('evaluation.options.age_groups'),$range->age?$range->age:'all', ['id' => 'select','class' => 'form-control', 'placeholder' => 'Choose...']) !!}
                    {!! $errors->first('age', '<span class="help-block">:message</span>') !!}
                </div>
                <!-- /.form-group -->
            </div>
            <!-- /.col -->
            <div class="col-md-6">
                <div class="form-group">
                    <label>Gender (Optional)</label>
                    {!! Form::select('gender',mconfig('evaluation.options.sex'),$range->procedure?$range->procedure:'', ['id' => 'select','class' => 'form-control', 'placeholder' => 'Choose...']) !!}
                    {!! $errors->first('gender', '<span class="help-block">:message</span>') !!}
                </div>
                <!-- /.form-group -->
                <div class="form-group">
                    <label>Type (Range or Greater/Less Than)</label>
                    {!! Form::select('type',mconfig('evaluation.options.range_types'),$range->type?$range->type:'range', ['id' => 'type','class' => 'form-control', 'placeholder' => 'Choose...']) !!}
                    {!! $errors->first('type', '<span class="help-block">:message</span>') !!}
                </div>
                <!-- /.form-group -->

                <div class="row" id="range">
                    <p style="text-align: center">Lower and Upper Range Values</p>
                    <div class="col-xs-6">
                        <input type="text" name="lower" class="form-control" placeholder="Lower Value">
                        {!! $errors->first('lower', '<span class="help-block">:message</span>') !!}
                    </div>
                    <div class="col-xs-6">
                        <input type="text" name="upper" class="form-control" placeholder="Upper Value">
                        {!! $errors->first('upper', '<span class="help-block">:message</span>') !!}
                    </div>
                </div>
                <br/>
                <div class="row" id="lg">
                    <p style="text-align: center">Less/Greater Than Value</p>
                    <div class="col-xs-6">
                        {!! Form::select('lg_type',mconfig('evaluation.options.lg_type'),$range->less_greater?$range->less_greater:'both', ['id' => 'select','class' => 'form-control', 'placeholder' => 'Choose...']) !!}
                        {!! $errors->first('lg_type', '<span class="help-block">:message</span>') !!}
                    </div>
                    <div class="col-xs-6">
                        <input type="text" name="lg_value" class="form-control" placeholder="Value">
                        {!! $errors->first('lg_value', '<span class="help-block">:message</span>') !!}
                    </div>
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
            <h3 class="box-title">ranges Templates</h3>
        </div>
        <div class="box-body">
            <table class="table table-responsive table-condensed table-borderless table-striped">
                <tbody>
                @foreach($ranges as $item)
                    <tr id="row_id{{$item->id}}">
                        <td>{{$loop->iteration}}</td>
                        <td>{{$item->procedures?$item->procedures->name:''}}</td>
                        <td>
                            @if(!empty($item->lower) && !empty($item->upper)&&!($item->type=='less_greater'))
                                {{$item->lower}}-{{$item->upper}}
                            @elseif($item->type=='less_greater')
                                {{$item->lg_type}} {{$item->lg_value}}
                            @endif
                        </td>
                        <td>{{$item->age}}</td>
                        <td>{{$item->gender}}</td>
                        <td>
                            <a class="btn btn-primary btn-xs"
                               href="{{route('evaluation.setup.ranges',$item->id)}}" >
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
                    <th>Reference Range</th>
                    <th>Age Group</th>
                    <th>Gender</th>
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
            $("table").DataTable();
            $('#lg').hide();
            $('#range').hide();
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
