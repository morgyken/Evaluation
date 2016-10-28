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
<div class="row">
    <div class="col-md-12">
        @foreach($diagnoses as $item)
        <div class="row">
            <div class="col-md-12">
                <strong>{{$item->procedures->name}}</strong>
                <p>{{empty($item->results)?'Pending result':$item->results->results}}</p>
            </div>
        </div>
        @endforeach
    </div>
</div>