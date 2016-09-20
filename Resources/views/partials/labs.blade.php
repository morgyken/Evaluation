<?php
/*
 * Collabmed Solutions Ltd
 * Project: iClinic
 *  Author: Samuel Okoth <sodhiambo@collabmed.com>
 *///$diagnosis=

$labs = \Dervis\Modules\Setup\Entities\Procedures::whereHas('categories', function ($query) {
            $query->where('applies_to', 3);
        })->get();
//$performed = Dervis\Model\Evaluation\PatientTreatment::whereVisit($data['visit'])->get();
?>
@if($labs->isEmpty())
<div class="alert alert-info">
    <i class="fa fa-info-circle"></i> There are no procedures. Please go to setup and add some.
</div>
@else
{!! Form::open(['id'=>'laboratory_form'])!!}
<table class="table table-condensed table-borderless table-responsive" id="procedures">
    <tbody>
        @foreach($labs as $procedure)
        <tr id="row{{$procedure->procedure_id}}">
            <td>
                <input type="checkbox" name="procedure[]" value="{{$procedure->procedure_id}}" class="check"/>
            </td>
            <td>
                <span id="name{{$procedure->procedure_id}}"> {{$procedure->name}}</span><br/>
                <span class="instructions"><textarea placeholder="Instructions" name="instructions[]" disabled cols="50"></textarea></span>
            </td>
            <td>
                <input type="hidden" name="price[]" value="{{(int)$procedure->cash_charge}}" size="5" id="price{{$procedure->procedure_id}}" disabled />
                <input type="text" name="cost[]" value="{{(int)$procedure->cash_charge}}" id="cost{{$procedure->procedure_id}}" size="5" disabled/>
            </td>
        </tr>
        @endforeach
    </tbody>
    <thead>
        <tr>
            <th></th>
            <th>Test</th>
            <th>Price</th>
            <th></th>
        </tr>
    </thead>
</table>
{!! Form::close()!!}
@endif