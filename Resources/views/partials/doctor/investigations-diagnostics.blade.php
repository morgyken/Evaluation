<?php
/*
 * Collabmed Solutions Ltd
 * Project: iClinic
 *  Author: Samuel Okoth <sodhiambo@collabmed.com>
 */
//$diagnosis=

$diagnosis = get_procedures_for('diagnostics');
$discount_allowed = json_decode(m_setting('evaluation.discount'));
$co = null;
$visit = \Ignite\Evaluation\Entities\Visit::find($visit->id);
if ($visit->payment_mode == 'insurance') {
    $co = $visit->patient_scheme->schemes->companies->id;
}
?>
@if($diagnosis->isEmpty())
    <div class="alert alert-info">
        <i class="fa fa-info-circle"></i> There are no procedures. Please go to setup and add some.
    </div>
@else
    {!! Form::open(['id'=>'diagnosis_form'])!!}
    {!! Form::hidden('visit',$visit->id) !!}
    <table class="table table-condensed table-borderless table-responsive" id="di">
        <tbody>
        @foreach($diagnosis as $procedure)
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
                    <input type="checkbox" name="item{{$procedure->id}}" value="{{$procedure->id}}" class="check"/>
                </td>
                <td>
                    <span id="name{{$procedure->id}}"> {{$procedure->name}}</span>
                    <br/>
                    <input type="hidden" name="type{{$procedure->id}}" value="diagnostics" />
                    <span class="instructions">
                    <textarea placeholder="Instructions" name="instructions{{$procedure->id}}" disabled cols="50"></textarea></span>
                </td>
                @if(!m_setting('evaluation.hide_procedure_prices'))
                <td>
                    <input type="text" name="price{{$procedure->id}}" value="{{$price}}" id="cost{{$procedure->id}}" size="5" readonly=""/>
                </td>
                <td><input class="quantity" size="5" value="1" id="quantity{{$procedure->id}}" type="text" name="quantity{{$procedure->id}}"/></td>
                <td>
                    @if(is_array($discount_allowed) && in_array('diagnostics', $discount_allowed))
                        <input class="discount" size="5" value="0" id="discount{{$procedure->id}}" type="text" name="discount{{$procedure->id}}"/>
                    @else
                        <input style="color:red" class="discount" size="5" value="0" id="discount{{$procedure->id}}" type="text" name="discount{{$procedure->id}}" readonly=""/>
                    @endif
                </td>
                <td><input size="5" id="amount{{$procedure->id}}" type="text" name="amount{{$procedure->id}}" readonly=""/></td>
                <td></td>
                @else
                    <td>
                        <input type="hidden" name="price{{$procedure->id}}" value="{{$price}}" id="cost{{$procedure->id}}" size="5" readonly=""/>
                    </td>
                    <td><input class="quantity" size="5" value="1" id="quantity{{$procedure->id}}" type="text" name="quantity{{$procedure->id}}"/></td>
                    <td>
                        @if(is_array($discount_allowed) && in_array('diagnostics', $discount_allowed))
                            <input class="discount" size="5" value="0" id="discount{{$procedure->id}}" type="hidden" name="discount{{$procedure->id}}"/>
                        @else
                            <input style="color:red" class="discount" size="5" value="0" id="discount{{$procedure->id}}" type="hidden" name="discount{{$procedure->id}}" readonly=""/>
                        @endif
                    </td>
                    <td><input size="5" id="amount{{$procedure->id}}" type="hidden" name="amount{{$procedure->id}}" readonly=""/></td>
                    <td></td>
                @endif
            </tr>
        @endforeach
        </tbody>
        <thead>
        <tr>
            <th></th>
            <th>Procedure</th>
            @if(!m_setting('evaluation.hide_procedure_prices'))
                <th>Price</th>
                <th>Number Performed</th>
                <th>Discount</th>
                <th>Amount</th>
                @else
                <th></th>
                <th>Number Performed</th>
                <th></th>
                <th></th>
            @endif
            <th></th>
        </tr>
        </thead>
    </table>
    {!! Form::close()!!}
    <style>
        #diagnosis_form {
            height: 400px;
            overflow-y: scroll;
        }
    </style>
    <script>
        $(document).ready(function() {
            try {
                $('#di').DataTable( {
                    paging:false
                } );
            }
            catch(err) {

            }
        } );
    </script>
@endif