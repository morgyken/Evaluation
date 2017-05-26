<?php
/*
 * Collabmed Solutions Ltd
 * Project: iClinic
 *  Author: Samuel Okoth <sodhiambo@collabmed.com>
 */
extract($data);
?>
@extends('layouts.app')
@section('content_title','Patient Evaluation')
@section('content_description','Patient evaluation and Treatment')

@section('content')
<div class="box box-default">
    <div class="box-body">
        <div class="form-horizontal">
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#investigations" data-toggle="tab">Investigations</a></li>
                    <li ><a href="#ordered" data-toggle="tab">Ordered<span class="badge alert-success">{{$orders->count()}}</span></a></li>
                    <li ><a href="#results" data-toggle="tab">Results<span class="badge alert-success">{{$orders->count()}}</span></a></li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="investigations">
                        <div>
                            @include('evaluation::partials.external.investigations')
                        </div>
                    </div>

                    <div class="tab-pane" id="ordered">
                        <div>
                            @include('evaluation::partials.external.ordered')
                        </div>
                    </div>

                    <div class="tab-pane" id="results">
                        <div>
                            @include('evaluation::partials.external.res')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        $('.accordion').accordion({heightStyle: "content"});
    });
</script>
@endsection