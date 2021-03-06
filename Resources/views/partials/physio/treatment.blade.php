<?php
/*
 * Collabmed Solutions Ltd
 * Project: iClinic
 *  Author: Samuel Okoth <sodhiambo@collabmed.com>
 */

$procedures = get_procedures_for('physio');
$performed = get_investigations($visit, ['physiotherapy']);
$discount_allowed = json_decode(m_setting('evaluation.discount'));
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
                            <br/>
                            <input type="hidden" name="type{{$procedure->id}}" value="physiotherapy" disabled/>
                            <span class="_instructions">
                                <textarea placeholder="Comments/Instructions" name="instructions{{$procedure->id}}" cols="50"></textarea>
                            </span>
                        </td>
                        <td><input class="quantity" size="5" value="1" id="quantity{{$procedure->id}}" type="text" name="quantity{{$procedure->id}}"/></td>
                        <td>
                            @if(is_array($discount_allowed) && in_array('physio', $discount_allowed))
                            <input class="discount" size="5" value="0" id="discount{{$procedure->id}}" type="text" name="discount{{$procedure->id}}"/>
                            @else
                            <input style="background-color:#EBEBE4;border:1px solid #ABADB3;padding:2px 1px;" class="discount" size="5" value="0" id="discount{{$procedure->id}}" type="text" name="discount{{$procedure->id}}" readonly=""/>
                            @endif
                        </td>
                        <td>
                            <input type="hidden" name="type{{$procedure->id}}" value="physiotherapy" disabled/>
                            <input type="text" name="price{{$procedure->id}}" value="{{$procedure->price}}"
                                   id="cost{{$procedure->id}}" size="5" disabled/>
                        </td>
                        <td>
                            <input size="5" id="amount{{$procedure->id}}" type="text" name="amount{{$procedure->id}}" readonly=""/>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                <thead>
                    <tr>
                        <th></th>
                        <th>Procedure</th>
                        <th>Number Performed</th>
                        <th>Discount</th>
                        <th>Price</th>
                        <th>Amount</th>
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
                            <th>#</th>
                            <th>Procedure</th>
                            <th>Comments/Instructions</th>
                            <th>Price</th>
                            <th>Discount</th>
                            <th>Amount</th>
                            <th>Payment</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($performed as $item)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{str_limit($item->procedures->name,20,'...')}}</td>
                            <td>{{$item->instructions}}</td>
                            <td>{{$item->quantity}} x {{$item->price}}</td>
                            <td>{{$item->discount}}</td>
                            <td>{{$item->amount>0?$item->amount:$item->price}}</td>
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