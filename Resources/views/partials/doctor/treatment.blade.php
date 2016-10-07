<?php
/*
 * Collabmed Solutions Ltd
 * Project: iClinic
 *  Author: Samuel Okoth <sodhiambo@collabmed.com>
 */

$procedures =get_procedures_for('doctor');
$performed = get_treatments($visit);
?>
<div class="row">
    <div class="col-md-12">

        <div class="col-md-8">
            @if($procedures->isEmpty())
            <div class="alert alert-info">
                <i class="fa fa-info-circle"></i> There are no procedures. Please go to setup and add some.

            </div>
            @else
            {!! Form::open(['id'=>'treatment_form'])!!}
            <table class="table table-condensed table-borderless table-responsive" id="procedures">
                <tbody>
                    @foreach($procedures as $procedure)
                    <tr id="row{{$procedure->id}}">
                        <td>
                            <input type="checkbox" name="procedure[]" value="{{$procedure->id}}" class="check"/>
                        </td>
                        <td>
                            <span id="name{{$procedure->id}}"> {{$procedure->name}}</span>
                        </td>
                        <td>
                            <input type="hidden" name="price[]" value="{{(int)$procedure->cash_charge}}" size="5" id="price{{$procedure->id}}" disabled/>
                            <input type="text" name="cost[]" value="{{(int)$procedure->cash_charge}}" id="cost{{$procedure->id}}" size="5" disabled/></td>
                        <td><input type="text" name="no_performed[]" value="1" size="3" id="no{{$procedure->id}}" disabled/></td>
                    </tr>
                    @endforeach
                </tbody>
                <thead>
                    <tr>
                        <th></th>
                        <th>Procedure</th>
                        <th>Price</th>
                        <th>No. performed</th>
                    </tr>
                </thead>
            </table>
            {!! Form::close()!!}
            @endif
        </div>
        <div class="col-md-4">
            <div class="row">
                <div class="col-md-12">
                    <div class="box box-primary">
                        <div class="box-header">
                            <h4 class="box-title">Selected procedures</h4>
                        </div>
                        <div class="box-body">
                            <div class="alert alert-success alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                <i class="fa fa-check-circle-o"></i> New selected procedures will appear here
                            </div>
                            <div id="tableHolder">
                                <table id="treatment" class=" table table-condensed">
                                    <thead>
                                        <tr>
                                            <th>Procedure</th>
                                            <th>Cost</th>
                                            <th>No</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                                <div class="pull-right">
                                    <button class="btn btn-success" id="saveTreatment"><i class="fa fa-save"></i> Save</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    @if(!empty($performed))
                    <div class="box box-success">
                        <div class="box-header">
                            <h4 class="box-title">Previously administered procedures</h4>
                        </div>
                        <div class="box-body">
                            <table class="table table-condensed">
                                <thead>
                                    <tr>
                                        <th>Procedure</th>
                                        <th>Cost</th>
                                        <th>No.</th>
                                        <th>Payment</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($performed as $item)
                                    <tr>
                                        <td>{{str_limit($item->procedures->name,20,'...')}}</td>
                                        <td>{{$item->price}}</td>
                                        <td>{{$item->no_performed}}</td>
                                        <td>{{$item->is_paid?'Paid':'Not Paid'}}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>

    </div>
</div>
<style>
    #tableHolder{
        display: none;
    }
</style>