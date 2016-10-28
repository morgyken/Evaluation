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

$diagnoses = $visit->investigations->where('type', 'diagnosis');
?>
@if(!$diagnoses->isEmpty())
{!! Form::open(['id'=>'diagnosis_form','files'=>true]) !!}
{!! Form::hidden('visit',$visit->id)!!}
<div class="accordion">
    @foreach($diagnoses as $item)
    <h4>{{$item->procedures->name}}</h4>
    <div>
        <div class="col-md-6">
            <div class="form-group">
                <label>Results</label>
                <textarea name="result{{$item->id}}" class="form-control"></textarea>
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
<p>No diagnostics tests ordered for this patient</p>
@endif