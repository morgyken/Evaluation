<?php
/*
 * Collabmed Solutions Ltd
 * Project: iClinic
 *  Author: Samuel Okoth <sodhiambo@collabmed.com>
 */
extract($data);
?>
@extends('layouts.app')
@section('content_title','Patient Evaluation | Laboratory')
@section('content_description','Patient evaluation | Laboratory')

@section('content')
@include('evaluation::partials.common.patient_details')
<div class="box box-default">
    <div class="box-body">
        <div class="form-horizontal">
            <div class="col-md-12">
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#ordered" data-toggle="tab">Ordered Tests</a></li>
                        <li><a href="#new" data-toggle="tab">New Tests</a> </li>
                        <li><a href="#results" data-toggle="tab">Results</a> </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active " id="ordered">
                            @include('evaluation::partials.labs.ordered')
                        </div>
                        <div class="tab-pane" id="new">
                            @include('evaluation::partials.labs.new')
                        </div>
                        <div class="tab-pane" id="results">
                            @include('evaluation::partials.labs.results')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    var VISIT_ID = "{{ $visit->id }}";
    var SAVE_URL = "{{route('api.evaluation.investigation_result')}}";
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