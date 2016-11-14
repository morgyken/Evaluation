<?php
/*
 * =============================================================================
 *
 * Collabmed Solutions Ltd
 * Project: Collabmed Health Platform
 * Author: Samuel Okoth <sodhiambo@collabmed.com>
 *
 * =============================================================================
 */

$diagnoses = $visit->investigations->where('type', 'laboratory');
?>
<div id="feedback-box"></div>
@if(!$diagnoses->isEmpty())
{!! Form::open(['id'=>'laboratory_form','files'=>true]) !!}
<div class="accordion">
    @foreach($diagnoses as $item)
    <?php $active = $item->has_result ? 'disabled' : ''; ?>
    <h4>{{$item->procedures->name}}</h4>
    <div>
        <div class="col-md-6">
            <div class="form-group">
                <label>Results</label>
                <input type="hidden" name="item{{$item->id}}" value="{{$item->id}}" {{$active}}/>
                <textarea name="results{{$item->id}}" class="form-control" {{$active}}></textarea>
            </div>
        </div>
        <div class="col-md-4 col-md-offset-2">
            <div class="form-group">
                <label>File</label>
                <input type="file" class="form-control" name="file{{$item->id}}" {{$active}}/>
            </div>
        </div>
        <div class="pull-right">
            <button type="submit" class="btn btn-xs btn-success"><i class="fa fa-save"></i> Save</button>
            <button type="reset" class="btn btn-warning btn-xs">Cancel</button>
        </div>
    </div>
    @endforeach
</div>
{!! Form::close()!!}
@else
<p>No procedures ordered for this patient</p>
@endif


@if(!$drug_prescriptions->isEmpty())
{!! Form::open(['route'=>'evaluation.pharmacy.dispense']) !!}
<table class="table table-striped">
    @foreach($drug_prescriptions as $item)
    <?php
    $price = 0;
    $stock = 0;
    foreach ($item->drugs->prices as $p) {
        if ($p->selling > $price) {
            $price = $p->price;
            $cash_price = ceil(($item->drugs->categories->cash_markup ? $item->drugs->categories->cash_markup + 100 : $price) / 100 * $price); //$item->prices->credit_price
            $credit_price = ceil(($item->drugs->categories->credit_markup ? $item->drugs->categories->credit_markup + 100 : $price) / 100 * $price);
        }
    }
    ?>
    <tr id="{{$item->id}}row">
        <td>
            <small>check me</small><br>
            <input type="hidden" name="drug{{$item->id}}" value="{{$item->drugs->id}}">
            <input type="checkbox" id="check{{$item->id}}" onclick="bill(<?php echo $item->id; ?>)" name="item{{$item->id}}">
        </td>
        <td colspan="2">
            <b>{{$item->drugs->name}}</b><br>
            Price: {{$price}}
            Credit: {{$credit_price}}
            Cash: {{$cash_price}}
            <?php if (preg_match('/Insurance/', $visit->mode)) { ?>
                <code>Price:{{number_format($credit_price,2)}}</code><br><br>
            <?php } else { ?>
                <code>Price:{{number_format($cash_price,2)}}</code><br><br>
                <?php
            }
            ?>
            <input type="hidden" value="{{$price}}" name="prc{{$item->id}}" id="prc{{$item->id}}">
            Dispensable Units: {{$item->drugs->stocks?$item->drugs->stocks->quantity:''}}<br>
            Qty Given:<input name="qty{{$item->id}}" onkeyup="bill(<?php echo $item->id; ?>)" class="qty{{$item->id}}" value="1" size="4" type="text" autocomplete="off">
            <br clear="all">
            <p class="sub_total_text{{$item->id}}"></p>
            <input type="hidden" name="item_subtotal{{$item->id}}" class="sub_total{{$item->id}}">
        </td>
        <td>{{$item->take}} {{mconfig('evaluation.options.prescription_whereto.'.$item->whereto)}}
            <p>{{mconfig('evaluation.options.prescription_method.'.$item->method)}} {{$item->duration}} {{mconfig('evaluation.options.prescription_duration.'.$item->time_measure)}}
                <br><b>Date: </b>{{date("F jS, Y", strtotime($item->created_at))}}<br>
                <b>Time: </b>{{date('h:i A', strtotime($item->created_at))}}<br/>
                <b>Prescribed By: </b> {{$item->users->username}} <br>
                <!-- <b>Payment Mode: </b> Cash<br> -->
            </p>
        </td>
        <td>
            <!-- <br clear="all">NOT PAID<br> -->
            <a href="#" onclick="cancelPrescription(<?php echo $item->id; ?>)" class="btn btn-warning btn-xs">Cancel</a>
        </td>
    </tr>
    @endforeach
    <tr>
        <td>
            Total Bill:<input type="text" value="0" name="total_bill" class="total_bill">
            <input type="hidden" name="visit" value="{{$visit->id}}">
        </td>
        <td>
            <button type="submit" class="btn btn-xs btn-info"> <i class="fa fa-hand-o-right"></i>Dispense Selected Drugs</button>
        </td>
        <td>

        </td>
    </tr>
</table>
<script>
    var prescURL = "{{route('evaluation.pharmacy.prescription.cancel')}}";
</script>
{!! Form::close()!!}
@else
<p>No drugs ordered for this patient</p>
@endif