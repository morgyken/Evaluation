<?php
/*
 * Collabmed Solutions Ltd
 * Project: iClinic
 *  Author: Samuel Okoth <sodhiambo@collabmed.com>
 */
//$diagnosis=

$diagnosis = get_procedures_for('diagnostics');
?>
@if($diagnosis->isEmpty())
<div class="alert alert-info">
    <i class="fa fa-info-circle"></i> There are no procedures. Please go to setup and add some.
</div>
@else
{!! Form::open(['id'=>'diagnosis_form'])!!}
{!! Form::hidden('visit',$visit->id) !!}
<table class="table table-condensed table-borderless table-responsive" id="procedures">
    <tbody>
        @foreach($diagnosis as $procedure)
        <tr id="row{{$procedure->id}}">
            <td>
                <input type="checkbox" name="item{{$procedure->id}}" value="{{$procedure->id}}" class="check"/>
            </td>
            <td>
                <span id="name{{$procedure->id}}"> {{$procedure->name}}</span>
                <br/>
                <input type="hidden" name="type{{$procedure->id}}" value="diagnosis" disabled/>
                <span class="instructions">
                    <textarea placeholder="Instructions" name="instructions{{$procedure->id}}" disabled cols="50"></textarea></span>
            </td>
            <td>
                <input type="hidden" name="price{{$procedure->id}}" value="{{$procedure->price}}" size="5" id="price{{$procedure->id}}" disabled />
                <input type="text" name="cost{{$procedure->id}}" value="{{$procedure->price}}" id="cost{{$procedure->id}}" size="5" disabled/></td>
        </tr>
        @endforeach
    </tbody>
    <thead>
        <tr>
            <th></th>
            <th>Procedure</th>
            <th>Price</th>
            <th></th>
        </tr>
    </thead>
</table>
{!! Form::close()!!}
@endif