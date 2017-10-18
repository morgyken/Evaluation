<?php
/*
 * =============================================================================
 *
 * Collabmed Solutions Ltd
 * Project: iClinic
 * Author: Samuel Okoth <sodhiambo@collabmed.com>
 *
 * =============================================================================
 */

?>
@extends('layouts.app')
@section('content_title','Point of sale')
@section('content_description','Add items to cart')

@section('content')
    <div class="box box-info">
        <div class="box-header with-border">
        </div>
        <div class="box-body">
            <div class="row">

                <div class="col-md-12">
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs" role="tablist">
                        <li role="presentation" class="active">
                            <a href="#direct" aria-controls="home" role="tab" data-toggle="tab">
                                Direct Payment
                            </a>
                        </li>
                    <!--
                    <li role="presentation">
                        <a href="{{route('inventory.shopfront.credit')}}">
                            Insurance (Credit)
                        </a>
                    </li>
                    -->
                    </ul>
                    <br>
                    <!-- Tab panes -->
                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane active" id="direct">
                            {!! Form::open(['class'=>'form-horizontal','route'=>'evaluation.shopfront.post']) !!}

                            <div class="col-md-4 col-lg-6">
                                <div class="form-group {{ $errors->has('patient') ? ' has-error' : '' }}">
                                    {!! Form::label('patient', 'Patient',['class'=>'control-label col-md-4']) !!}
                                    <div class="col-md-8">
                                        <select name="patient" id="patient_select" class="form-control"
                                                style="width:100%;"
                                                data-placeholder="Search Patient Name"
                                                required></select>
                                        {!! $errors->first('patient', '<span class="help-block">:message</span>') !!}
                                    </div>
                                </div>
                            </div>
                            <table class="items table  table-striped table-condensed" id="tab_logic">
                                <thead>
                                <tr>
                                    <th style="width: 20%;">Item</th>
                                    <th class="text-center" style="width: 10%;">Units</th>
                                    <th class="text-center" style="width: 10%;">Initial Price</th>
                                    <th class="text-center" style="width: 20%;">Selling Price</th>
                                    <th style="width: 12%;">Total</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr id='addr0'>
                                    <td><select name="item0" id="item_0" class="select2-single" style="width: 100%"
                                                required=""></select></td>
                                    <td>
                                        <input type="text" id="item_qty_0" autocomplete="off" name='qty0'
                                               placeholder='Units' value="0"
                                               class="quantities"/>
                                    </td>
                                    <td><span id="original0">-</span></td>
                                    <td><input type="text" id="item_price_0" name='price0' placeholder='Price'/></td>
                                    <td><span id="total0">0.00</span></td>
                                    <td>
                                        <button class="btn btn-xs btn-danger remove"><i class="fa fa-trash-o"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr id='addr1'>
                                    <td><select name="item1" id="item_1" class=" select2-single"
                                                style="width: 100%"></select></td>
                                    <td>
                                        <input type="text" name='qty1' id="item_qty_1" autocomplete="off"
                                               placeholder='Quantity' value="0"
                                               class="quantities"/>
                                    </td>
                                    <td><span id="original1">-</span></td>
                                    <td><input type="text" name='price1' placeholder='Price'/></td>
                                    <td><span id="total1">0.00</span></td>
                                    <td>
                                        <button class="btn btn-xs btn-danger remove"><i class="fa fa-trash-o"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr id='addr2'>
                                    <td><select name="item2" id="item_2" class=" select2-single"
                                                style="width: 100%"></select></td>
                                    <td>
                                        <input type="text" name='qty2' id="item_qty_2" autocomplete="off"
                                               placeholder='Quantity' value="0" class="quantities"/>
                                    </td>
                                    <td><span id="original2">-</span></td>
                                    <td><input type="text" name='price2' placeholder='Price'/></td>
                                    <td><span id="total2">0.00</span></td>
                                    <td>
                                        <button class="btn btn-xs btn-danger remove"><i class="fa fa-trash-o"></i>
                                        </button>
                                    </td>

                                </tr>
                                <tr id='addr3'></tr>
                                </tbody>
                                <tfoot>
                                <tr>
                                    <td>
                                        <a id="add_row" class="btn btn-primary btn-sm pull-left">
                                            <i class="fa fa-plus"></i>
                                            Add</a>
                                    </td>
                                    <td colspan="4"></td>
                                    <td><strong id="total">0.00</strong></td>
                                    <td></td>
                                </tr>
                                </tfoot>
                            </table>
                            <table class="table" id="customer">
                                <tr>
                                    <td>
                                    </td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td>
                                        <dt>Total Cost</dt>
                                        <dd><strong id="sum"></strong></dd>
                                    </td>
                                    <td>
                                        <dt>Discount</dt>
                                        <dd><strong id="discount"></strong></dd>
                                    </td>
                                    <td>
                                        <dt>Net amount</dt>
                                        <dd><strong id="net" class="text-success"></strong></dd>
                                    </td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td><label class="control-label col-md-4">Amount</label></td>
                                    <td>
                                        <input name="amount" type="text" id="amnt" class="form-control" required/>
                                    </td>
                                </tr>
                            </table>

                            <div class="pull-right">
                                <button type="submit" id="save" class="btn btn-success">
                                    <i class="fa fa-send"></i>
                                    Request Services
                                </button>
                            </div>
                            {!! Form::close() !!}
                        </div><!--End of Direct-->
                    </div><!--End of tab content -->

                </div>
            </div>

        </div>
    </div>
    </div>

    <script>
        // AJAX call for autocomplete
        $(document).ready(function () {
            var scheme_id = 0;
            $('#scheme').change(function () {
                scheme_id = $(this).val();
            });
        });

        $('#patient_select').keyup(function () {
            get_patient_suggestions(this.value)
        });
        var INSURANCE = false;
        var PROCEDURES_URL = "{{route('api.evaluation.get.procedures')}}";
        var SCHEMES_URL = "{{route('api.settings.get_schemes')}}";
        var PHONE_URL = "{{route('api.inventory.cust.get')}}";
        var PATIENTS_URL = "{{route('api.reception.suggest_patients')}}";
        var CREDIT_URL = "{{route('api.inventory.credit.rate')}}";

        function get_patient_suggestions(term) {
            $.ajax({
                url: PROCEDURES_URL,
                data: {'term': term},
                success: function (data) {
                    $('.results').html(data);
                }
            });
        }
    </script>
    <script src="{!! m_asset('evaluation:js/shopfront.js') !!}"></script>
@endsection