<?php
/*
 * Collabmed Solutions Ltd
 * Project: iClinic
 *  Author: Samuel Okoth <sodhiambo@collabmed.com>
 *///$diagnosis=

$radiology = get_procedures_for('radiology');
?>
@if($radiology->isEmpty())
<div class="alert alert-info">
    <i class="fa fa-info-circle"></i> There are no procedures. Please go to setup and add some.
</div>
@else
{!! Form::open(['id'=>'radiology_form'])!!}
{!! Form::hidden('visit',$visit->id) !!}
<table class="table table-condensed table-borderless table-responsive" id="procedures">
    <tbody>
        @foreach($radiology as $procedure)
        <tr id="row{{$procedure->id}}">
            <td>
                <input type="checkbox" name="item{{$procedure->id}}" value="{{$procedure->id}}" class="check"/>
            </td>
            <td>
                <span id="name{{$procedure->id}}"> {{$procedure->name}}</span><br/>
                <span class="instructions">
                    <textarea placeholder="Instructions" name="instructions{{$procedure->id}}" disabled cols="50">
                    </textarea>
                    <!--
                    @if(!$procedure->items->isEmpty())
                    <hr>
                    <h5>Inventory Item(s) Consumed</h5>
                    <table class="table">
                        <tr>
                            <th>Item</th>
                            <th>Units Consumed</th>
                        </tr>
                        @foreach($procedure->items as $item)
                        <tr>
                            <td>{{$item->inventory->name}}</td>
                            <td><input type="text" name="units" class="form-control" ></td>
                        </tr>
                        @endforeach
                    </table>
                    @endif
                    -->
                </span>
                <input type="hidden" name="type{{$procedure->id}}" value="radiology" disabled />
            </td>
            <td>
                <input type="text" name="price{{$procedure->id}}" value="{{$procedure->price}}" id="cost{{$procedure->id}}" size="5" disabled/>
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