<?php
/*
 * Collabmed Solutions Ltd
 * Project: iClinic
 *  Author: Samuel Okoth <sodhiambo@collabmed.com>
 */

$procedures = get_procedures_for('dental');
$performed = get_investigations($visit, ['dental']);
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
                    @foreach($procedures as $procedure)
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
                            <input type="checkbox" id="checked_{{$procedure->id}}" name="item{{$procedure->id}}" value="{{$procedure->id}}"class="check"/>
                        </td>
                        <td>
                            <span id="name{{$procedure->id}}"> {{$procedure->name}}</span>
                        </td>
                        <td>
                            <input class="quantity" size="5" value="1" id="quantity{{$procedure->id}}" type="text" name="quantity{{$procedure->id}}"/>
                        </td>
                        <td>
                            @if(is_array($discount_allowed) &&  in_array('doctor', $discount_allowed))
                            <input class="discount" size="5" value="0" id="discount{{$procedure->id}}" type="text" name="discount{{$procedure->id}}"/>
                            @else
                            <input style="color:red" class="discount" size="5" value="0" id="discount{{$procedure->id}}" type="text" name="discount{{$procedure->id}}" readonly=""/>
                            @endif
                        </td>
                        <td>
                            <input type="hidden" name="type{{$procedure->id}}" value="dental" disabled/>
                            <input disabled="" type="text" name="price{{$procedure->id}}" value="{{$price}}"
                                   id="cost{{$procedure->id}}" size="5" readonly=""/>
                        </td>
                        <td>
                            <input size="5" id="amount{{$procedure->id}}" type="text" name="amount{{$procedure->id}}"/>
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
                                        <th>Amount</th>
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
                            <th>Price</th>
                            <th>Number Performed</th>
                            <th>Discount(%)</th>
                            <th>Amount</th>
                            <th>Payment</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php try { ?>
                            @foreach($performed as $item)
                            <?php try { ?>
                                <tr>
                                    <td>{{str_limit($item->procedures->name,40,'...')}}</td>
                                    <td>{{$item->price}}</td>
                                    <td>{{$item->quantity}}</td>
                                    <td>{{$item->discount}}</td>
                                    <td>
                                        <?php try { ?>
                                            @if($item->amount>0)
                                            {{$item->amount}}
                                            @else
                                            {{$item->price}}
                                            @endif
                                        <?php } catch (Exception $ex) { ?>

                                        <?php } ?>
                                    </td>
                                    <td>{!! payment_label($item->is_paid) !!}</td>
                                </tr>
                                <?php
                            } catch (Exception $ex) {

                            }
                            ?>
                            @endforeach
                            <?php
                        } catch (Exception $ex) {

                        }
                        ?>
                    </tbody>
                </table>
                @else
                <p class="text-info"><i class="fa fa-info"></i> No previous treatment</p>
                @endif
            </div>
        </div>
    </div>
</div>
<!-- -->
<style>
    #treatment_form {
        height: 400px;
        overflow-y: scroll;
    }
</style>
<script type="text/javascript">
    function siri_get_discount_given_amount(i) {
        /*
         var prc = $("#cost" + i).val();
         var qty = $("#quantity" + i).val();
         var amount = $("#amount" + i).val();

         var total = prc * qty;
         var dis = ((total - amount) / 100) * 100;

         $('input[name=discount' + i + ']').val(dis);
         */
    }
</script>
