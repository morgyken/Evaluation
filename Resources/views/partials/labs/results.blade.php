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
?>
<div class="row">
    <div class="col-md-12">
        @foreach($results as $item)
        <div class="row">
            <div class="col-md-12">
                <strong>{{$item->procedures->name}}</strong>
                <p>{{$item->results->results}}</p>
                @if($item->results->documents)
                <a href="{{route('reception.view_document',$item->results->documents->id)}}" target="_blank">
                    {{$item->results->documents->filename}}</a>
                @endif
            </div>
        </div>
        @endforeach
    </div>
</div>