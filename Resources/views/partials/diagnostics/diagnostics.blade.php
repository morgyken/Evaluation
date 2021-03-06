<?php
/*
 * Collabmed Solutions Ltd
 * Project: iClinic
 *  Author: Samuel Okoth <sodhiambo@collabmed.com>
 */
$patient = $data['visits']->patients;
$diagnoses = $data['visits']->investigations->where('type', 'diagnosis');
$data['section'] = 'diagnostics';
?>
@extends('layouts.app')
@section('content_title','Patient Evaluation | Diagnostics')
@section('content_description','Patient evaluation | Diagnostics')

@section('content')
<div class="box box-info">
    <div class="box-body">
        @include('evaluation::partials.patient_details')
        <div class="form-horizontal">
            <div class="col-md-12">
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#diagnostics" data-toggle="tab">Diagnostics</a></li>
                        <li><a href="#neworder" data-toggle="tab">New order</a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="vitals">
                            <div>
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
                                                <input type="hidden" name="type[{{$item->test}}]" value="diagnosis"/>
                                                <input type="hidden" name="visit[{{$item->test}}]" value="{{$data['visit']}}"/>
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
                                <p>No diagnosis ordered for this patient</p>
                                @endif
                            </div>
                        </div>
                        <div class="tab-pane" id="neworder">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    var VISIT_ID = "{{ $data['visit'] }}";
    var SAVE_URL = "{{route('api.evaluation.save_diagnosis')}}";
    $(document).ready(function () {
        $('.accordion').accordion({heightStyle: "content"});
        $('#laboratory_form').submit(function (e) {
            e.preventDefault();
            $.ajax({
                url: SAVE_URL,
                type: $(this).attr("method"),
                //dataType: "JSON",
                data: new FormData(this),
                processData: false,
                contentType: false,
                success: function (data, status)
                { },
                error: function (xhr, desc, err)
                {
                    alert(err);
                }
            });
        });
    });
</script>

@endsection