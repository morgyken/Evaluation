<?php
/*
 * Collabmed Solutions Ltd
 * Project: iClinic
 *  Author: Samuel Okoth <sodhiambo@collabmed.com>
 */

$doctor_procedures = get_procedures_for('doctor');
$performed = get_investigations($visit, ['treatment']);
$discount_allowed = json_decode(m_setting('evaluation.discount'));

$co = null;
$visit = \Ignite\Evaluation\Entities\Visit::find($visit->id);
if ($visit->payment_mode == 'insurance') {
    $co = $visit->patient_scheme->schemes->companies->id;
}
?>     @if($doctor_procedures->isEmpty())
    <div class="alert alert-info">
        <i class="fa fa-info-circle"></i> There are no procedures. Please go to setup and add some.
    </div>
@else
    {!! Form::open(['id'=>'procedures_doctor_form'])!!}
    {!! Form::hidden('visit',$visit->id) !!}
    <table class="table table-condensed table-borderless table-responsive" id="procedures">
        <tbody>
        @foreach($doctor_procedures as $procedure)
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
                    <input type="checkbox" id="checked_{{$procedure->id}}" name="item{{$procedure->id}}"
                           value="{{$procedure->id}}" class="check"/>
                </td>
                <td>
                    <span id="name{{$procedure->id}}"> {{$procedure->name}}</span>
                </td>
                <td>
                    <input class="quantity" size="5" value="1" id="quantity{{$procedure->id}}"
                           type="text"
                           name="quantity{{$procedure->id}}"/>
                </td>
                <td>
                    @if(is_array($discount_allowed) &&  in_array('doctor', $discount_allowed))
                        <input class="discount" size="5" value="0" id="discount{{$procedure->id}}"
                               type="text" name="discount{{$procedure->id}}"/>
                    @else
                        <input style="color:red" class="discount" size="5" value="0"
                               id="discount{{$procedure->id}}" type="text"
                               name="discount{{$procedure->id}}"
                               readonly=""/>
                    @endif
                </td>
                <td>
                    <input type="hidden" name="type{{$procedure->id}}" value="treatment" disabled/>
                    <input disabled="" type="text" name="price{{$procedure->id}}" value="{{$price}}"
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
            <th>Number Performed</th>
            <th>Discount</th>
            <th>Price</th>
            <th>Amount</th>
        </tr>
        </thead>
    </table>
    {!! Form::close()!!}
@endif
