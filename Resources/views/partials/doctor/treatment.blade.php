<?php
/*
 * Collabmed Solutions Ltd
 * Project: iClinic
 *  Author: Samuel Okoth <sodhiambo@collabmed.com>
 */

$procedures = get_procedures_for('doctor');
$performed = get_investigations($visit, ['treatment']);
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
            {!! Form::hidden('visit',$visit->id) !!}
            <table class="table table-condensed table-borderless table-responsive" id="procedures">
                <tbody>
                    @foreach($procedures as $procedure)
                    <tr id="row{{$procedure->id}}">
                        <td>
                            <input type="checkbox" name="item{{$procedure->id}}" value="{{$procedure->id}}"
                                   class="check"/>
                        </td>
                        <td>
                            <span id="name{{$procedure->id}}"> {{$procedure->name}}</span>
                        </td>
                        <td> <input type="hidden" name="type{{$procedure->id}}" value="treatment" disabled/>
                            <input type="text" name="price{{$procedure->id}}" value="{{$procedure->price}}"
                                   id="cost{{$procedure->id}}" size="5" disabled/>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                <thead>
                    <tr>
                        <th></th>
                        <th>Procedure</th>
                        <th>Price</th>
                    </tr>
                </thead>
            </table>
            {!! Form::close()!!}
            @endif
        </div>
        <div class="col-md-4">
            <div class="row">
                <div class="col-md-12" id="selected_treatment">
                    <div class="box box-primary">
                        <div class="box-header">
                            <h4 class="box-title">Selected procedures</h4>
                        </div>
                        <div class="box-body">
                            <table id="treatment" class=" table table-condensed">
                                <thead>
                                    <tr>
                                        <th>Procedure</th>
                                        <th>Cost</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                            <div class="pull-right">
                                <button class="btn btn-success" id="saveTreatment"><i class="fa fa-save"></i> Save
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <br/>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="box box-success">
            <div class="box-header">
                <h4 class="box-title">Previously administered procedures</h4>
            </div>
            <div class="box-body">
                @if(!$performed->isEmpty())
                <table class="table table-condensed">
                    <thead>
                        <tr>
                            <th>Procedure</th>
                            <th>Cost</th>
                            <th>Payment</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($performed as $item)
                        <tr>
                            <td>{{str_limit($item->procedures->name,20,'...')}}</td>
                            <td>{{$item->price}}</td>
                            <td>{!! payment_label($item->is_paid) !!}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @else
                <p class="text-info"><i class="fa fa-info"></i> No previous treatment</p>
                @endif
            </div>
        </div>
    </div>
</div>
<style>
    #treatment_form {
        height: 400px;
        overflow-y: scroll;
    }
</style>