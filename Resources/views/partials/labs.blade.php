<?php
/*
 * Collabmed Solutions Ltd
 * Project: iClinic
 *  Author: Samuel Okoth <sodhiambo@collabmed.com>
 *///$diagnosis=

$labs = get_procedures_for('laboratory');
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
        <tr id="row{{$procedure->id}}">
            <td>
                <input type="checkbox" name="procedure[]" value="{{$procedure->id}}" class="check"/>
            </td>
            <td>
                <span id="name{{$procedure->id}}"> {{$procedure->name}}</span><br/>
                <span class="instructions"><textarea placeholder="Instructions" name="instructions[]" disabled cols="50"></textarea></span>
            </td>
            <td>
                <input type="hidden" name="price[]" value="{{(int)$procedure->cash_charge}}" size="5" id="price{{$procedure->id}}" disabled />
                <input type="text" name="cost[]" value="{{(int)$procedure->cash_charge}}" id="cost{{$procedure->id}}" size="5" disabled/>
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