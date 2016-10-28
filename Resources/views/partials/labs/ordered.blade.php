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
@if(!$diagnoses->isEmpty())
{!! Form::open(['id'=>'laboratory_form','files'=>true]) !!}
<div class="accordion">
    @foreach($diagnoses as $item)
    <h4>{{$item->procedures->name}}</h4>
    <div>
        <div class="col-md-6">
            <div class="form-group">
                <label>Results</label>
                <input type="hidden" name="item{{$item->id}}" value="{{$item->id}}"/>
                <textarea name="results{{$item->id}}" class="form-control"></textarea>
            </div>
        </div>
        <div class="col-md-4 col-md-offset-2">
            <div class="form-group">
                <label>File</label>
                <input type="file" class="form-control" name="file{{$item->id}}"/>
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
<p>No laboratory tests ordered for this patient</p>
@endif