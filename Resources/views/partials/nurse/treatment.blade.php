<?php
/*
 * Collabmed Solutions Ltd
 * Project: iClinic
 *  Author: Samuel Okoth <sodhiambo@collabmed.com>
 */

$procedures = get_procedures_for('nurse');
$performed = get_investigations($visit, ['treatment.nurse', 'nursing']);
$discount_allowed = json_decode(m_setting('evaluation.discount'));

$co = null;
$visit = \Ignite\Evaluation\Entities\Visit::find($visit->id);
if ($visit->payment_mode == 'insurance') {
    $co = $visit->patient_scheme->schemes->companies->id;
}
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
                    @foreach($nursing_procedures as $procedure)
                        <?php
                        $c_price = \Ignite\Settings\Entities\CompanyPrice::whereCompany(intval($co))
                            ->whereProcedure(intval($procedure->id))
                            ->get()
                            ->first();
                        if (isset($c_price)) {
                            if ($c_price->price > 0) {
                                $price = $c_price->price;
                            }
                        } else {
                            $price = $procedure->price;
                        }
                        ?>
                        <tr id="row{{$procedure->id}}">
                            <td>
                                <input type="checkbox" name="item{{$procedure->id}}" value="{{$procedure->id}}"
                                       class="check"/>
                            </td>
                            <td>
                            <span id="name{{$procedure->id}}"> {{$procedure->name}},
                                {{$procedure->categories->name}}
                            </span>
                            </td>
                            <td><input class="quantity" size="5" value="1" id="quantity{{$procedure->id}}" type="text"
                                       name="quantity{{$procedure->id}}"/></td>
                            <td>
                                @if(is_array($discount_allowed) && in_array('nursing', $discount_allowed))
                                    <input class="discount" size="5" value="0" id="discount{{$procedure->id}}"
                                           type="text" name="discount{{$procedure->id}}"/>
                                @else
                                    <input style="background-color:#EBEBE4;border:1px solid #ABADB3;padding:2px 1px;"
                                           class="discount" size="5" value="0" id="discount{{$procedure->id}}"
                                           type="text" name="discount{{$procedure->id}}" readonly=""/>
                                @endif
                            </td>
                            <td><input type="hidden" name="type{{$procedure->id}}" value="nursing" disabled/>
                                <input type="text" name="price{{$procedure->id}}" value="{{$price}}"
                                       id="cost{{$procedure->id}}" size="5" readonly=""/>
                            </td>
                            <td>
                                <input size="5" id="amount{{$procedure->id}}" type="text"
                                       name="amount{{$procedure->id}}"/>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Procedure</th>
                        <th>Units</th>
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
                    <table class="table table-striped table-condensed">
                        <thead>
                        <tr>
                            <th>Procedure</th>
                            <th>Price</th>
                            <th>Units</th>
                            <th>Amount</th>
                            <th>Payment</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($performed as $item)
                            <tr>
                                <td>{{str_limit($item->procedures->name,40,'...')}}</td>
                                <td>{{$item->price}}</td>
                                <td>{{$item->quantity}}</td>
                                <td>{{$item->amount??$item->price}}</td>
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