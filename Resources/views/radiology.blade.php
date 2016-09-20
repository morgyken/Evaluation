<?php
/*
 * Collabmed Solutions Ltd
 * Project: iClinic
 *  Author: Samuel Okoth <sodhiambo@collabmed.com>
 */
$patient = $data['visits']->patients;
$data['section'] = 'radiology';
?>
@extends('layouts.app')
@section('content_title','Patient Evaluation | Radiology')
@section('content_description','Patient evaluation | Radiology')

@section('content')
<div class="box box-info">
    <div class="box-body">
        @include('reception::partials.patient_details')
        <div class="form-horizontal">
            <div class="col-md-12">
                @if(!empty($data['visit']->investigations))
                <div class="accordion">
                    @foreach($data['visit']->investigations as $item)
                    <h4>{{$item->procedures->name}}</h4>
                    <div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Results</label>
                                <textarea name="" class="form-control"></textarea>
                            </div>
                        </div>
                        <div class="col-md-4 col-md-offset-2">
                            <div class="form-group">
                                <label>File</label>
                                <input type="file" class="form-control"/>
                            </div>
                        </div>
                        <div class="pull-right">
                            <button>Cancel</button>
                            <button type="submit">Save</button>
                        </div>
                    </div>
                    @endforeach
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    var visit = "{{ $data['visit'] }}";
    $(document).ready(function () {
        $('.accordion').accordion({heightStyle: "content"});
    });
</script>

@endsection