<?php
/*
 * Collabmed Solutions Ltd
 * Project: iClinic
 * Author: Samuel Okoth <sodhiambo@collabmed.com>
 */
$procedure = $data['procedure'];
$companies = \Ignite\Settings\Entities\Insurance::all();
?>

@extends('layouts.app')
@section('content_title','Procedures')
@section('content_description','Add procedures')

@section('content')
<div class="form-horizontal">
    <div class="box box-info">
        {!! Form::model($procedure,['id'=>'procedure_form','route'=>'evaluation.setup.procedures.save']) !!}
        {!! Form::hidden('id',$procedure->id) !!}
        <div class="box-body">
            <div class="col-md-6">
                <div class="form-group {{ $errors->has('name') ? ' has-error' : '' }} req">
                    {!! Form::label('name', 'Procedure Name',['class'=>'control-label col-md-4']) !!}
                    <div class="col-md-8">
                        {!! Form::text('name', old('name'), ['class' => 'form-control', 'placeholder' => 'Procedure Name']) !!}
                        {!! $errors->first('name', '<span class="help-block">:message</span>') !!}
                    </div>
                </div>
                <div class="form-group {{ $errors->has('code') ? ' has-error' : '' }} req">
                    {!! Form::label('code', 'Code',['class'=>'control-label col-md-4']) !!}
                    <div class="col-md-8">
                        {!! Form::text('code', old('code'), ['class' => 'form-control', 'placeholder' => 'Code']) !!}
                        {!! $errors->first('code', '<span class="help-block">:message</span>') !!}
                    </div>
                </div>

                <div class="form-group {{ $errors->has('category') ? ' has-error' : '' }} req">
                    {!! Form::label('category', 'Category',['class'=>'control-label col-md-4']) !!}
                    <div class="col-md-8">
                        {!! Form::select('category',get_procedure_categories(),old('category'), ['class' => 'form-control', 'placeholder' => 'Choose...']) !!}
                        {!! $errors->first('category', '<span class="help-block">:message</span>') !!}
                    </div>
                </div>

                @include('evaluation::partials.labs.labtests')

                <div class="form-group {{ $errors->has('description') ? ' has-error' : '' }}">
                    {!! Form::label('description', 'Description',['class'=>'control-label col-md-4']) !!}
                    <div class="col-md-8">
                        {!! Form::textarea('description', old('description'),
                        ['class' => 'form-control', 'placeholder' => 'Description ...','rows'=>3]) !!}
                        {!! $errors->first('description', '<span class="help-block">:message</span>') !!}
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group {{ $errors->has('cash_charge') ? ' has-error' : '' }}">
                    {!! Form::label('cash_charge', 'Cash Charge',['class'=>'control-label col-md-4']) !!}
                    <div class="col-md-8">
                        {!! Form::text('cash_charge', old('cash_charge'), ['class' => 'form-control', 'placeholder' => 'Cash Charge']) !!}
                        {!! $errors->first('cash_charge', '<span class="help-block">:message</span>') !!}
                    </div>
                </div>
                <div class="form-group {{ $errors->has('cash_charge_insurance') ? ' has-error' : '' }}">
                    {!! Form::label('cash_charge_insurance', 'Cash Charge applies to insurance?',['class'=>'control-label col-md-4']) !!}
                    <div class="col-md-8">
                        {!! Form::radio('cash_charge_insurance',1) !!} Yes
                        {!! Form::radio('cash_charge_insurance',0,true) !!} No
                        {!! $errors->first('cash_charge_insurance', '<span class="help-block">:message</span>') !!}
                    </div>
                </div>

                <div class="form-group {{ $errors->has('status') ? ' has-error' : '' }} req">
                    {!! Form::label('status', 'Status',['class'=>'control-label col-md-4']) !!}
                    <div class="col-md-8">
                        {!! Form::radio('status',1,true) !!} Active
                        {!! Form::radio('status',0) !!} Inactive
                        {!! $errors->first('status', '<span class="help-block">:message</span>') !!}
                    </div>
                </div>
                <div class="form-group {{ $errors->has('precharge') ? ' has-error' : '' }}">
                    {!! Form::label('precharge', 'Charge at Reception',['class'=>'control-label col-md-4']) !!}
                    <div class="col-md-8">
                        <input type="checkbox" name="precharge" value="1">
                    </div>
                </div>

                <div class="form-group {{ $errors->has('inventory_items') ? ' has-error' : '' }}">
                    {!! Form::label('inventory_items', 'Consumes Inventory Items?',['class'=>'control-label col-md-4']) !!}
                    <div class="col-md-8">
                        <?php if (!$procedure->items->isEmpty()) { ?>
                            <input type="checkbox" id="has_items" name="has_items" value="1" checked />
                        <?php } else { ?>
                            <input type="checkbox" id="has_items" name="has_items" value="1" />
                        <?php } ?>
                    </div>
                </div>

                <div id="items" class="form-group {{ $errors->has('inventory_items') ? ' has-error' : '' }}">
                    {!! Form::label('inventory_items', 'Select Items Consumed',['class'=>'control-label col-md-4']) !!}
                    <div class="col-md-8">
                        @include('evaluation::setup.partials.inventory_items')
                    </div>
                </div>

                <!--
                                <div class="form-group {{ $errors->has('price_for_company') ? ' has-error' : '' }}">
                                    {!! Form::label('price_for_company', 'Special Price for Insurance Company(s)',['class'=>'control-label col-md-4']) !!}
                                    <div class="col-md-8">
                                        <input type="checkbox" id="special_price_check" name="special_price" value="1">
                                    </div>
                                </div>

                                <div id="_firm_prices" class="form-group {{ $errors->has('price_for_company') ? ' has-error' : '' }}">
                                    {!! Form::label('price_for_company', 'Select Insurance Company(s)',['class'=>'control-label col-md-4']) !!}
                                    <div class="col-md-8">
                                        <select name="companies[]">
                                            <option value="">Select Company</option>
                                            @foreach($companies as $c)
                                            <option value="{{$c->id}}">{{$c->name}}</option>
                                            @endforeach
                                        </select>
                                        <input type="text" name="prices[]" >

                                        <a href="#" onclick="more_firms()">More</a><br/><br>
                                        <div id="_more_firms"></div><br>
                                    </div>
                                </div>
                -->

            </div>
        </div>
        <div class="box-footer">
            <div class="pull-right">
                <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Save Procedure</button>
            </div>
        </div>
        {!! Form::close() !!}
    </div>
</div>
<div class="box box-info">
    <div class="box-header">
        <h3 class="box-title">Procedures</h3>
    </div>
    <div class="box-body">
        <table id="data" class="table table-responsive table-condensed">
            <tbody>
                @foreach($data['procedures'] as $procedure)
                <tr>
                    <td>{{$procedure->name}}</td>
                    <td>{{$procedure->categories->name}}</td>
                    <td>{{$procedure->code?$procedure->code:''}}</td>
                    <td>{{$procedure->cash_charge}}</td>
                    <td>
                        <a class="btn btn-primary btn-xs"
                           href="{{route('evaluation.setup.procedures',$procedure->id)}}">
                            <i class="fa fa-pencil-square-o"></i></a> |
                        <button class="btn btn-danger btn-xs delete" value="">
                            <i class="fa fa-trash-o"></i></button>
                    </td>
                </tr>
                @endforeach
            </tbody>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Category</th>
                    <th>Code</th>
                    <th>Cash Charge</th>
                    <th>Actions</th>
                </tr>
            </thead>
        </table>
    </div>
</div>

<script>
    var n = 1;
    var more_firms = function () {
        if (n >= 10)
            return;
        $('#_more_firms').append("\<div>\n\<select name='companies[]'><option value=''>Select Company</option>\n\<?php
                        foreach ($companies as $c) {
                            echo '<option value=' . $c->id . '>' . $c->name . '</option>';
                        }
                        ?>< /select>\n\<input type='text' name='prices[]' >\n\<a href='#' onclick ='del(this)' > Delete </a></div><br/>");
        n++;
    };
    var del = function (btn) {
        $(btn).parent().remove();
    };
</script>

<script type="text/javascript">
    var PRODUCTS_URL = "{{route('api.inventory.get_products')}}";
</script>
<script src="{!! m_asset('evaluation:js/procedures.js') !!}"></script>
<script src="{!! m_asset('evaluation:js/inventory_items.js') !!}"></script>
@endsection
