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
$data['section'] = 'laboratory';
?>
@if(!$diagnoses->isEmpty())
{!! Form::open(['id'=>'laboratory_form','files'=>true]) !!}
<div class="accordion">
    @foreach($diagnoses as $item)
    <h4>{{$item->procedures->name}}</h4>
    <div>
        <input type="hidden" name="investigation[]" value="{{$item->test}}"/>
        <div class="col-md-6">
            <div class="form-group">
                <label>Results</label>
                <textarea name="result[{{$item->test}}]" class="form-control"></textarea>
                <input type="hidden" name="type[{{$item->test}}]" value="laboratory"/>
                <input type="hidden" name="visit[{{$item->test}}]" value="{{$visit}}"/>
            </div>
        </div>
        <div class="col-md-4 col-md-offset-2">
            <div class="form-group">
                <label>File</label>
                <input type="file" class="form-control" name="file[{{$item->test}}]"/>
            </div>
        </div>
        <div class="pull-right">
            <button>Cancel</button>
            <button type="submit">Save</button>
        </div>
    </div>
    @endforeach
</div>
{!! Form::close()!!}
@else
<p>No laboratory tests ordered for this patient</p>
@endif