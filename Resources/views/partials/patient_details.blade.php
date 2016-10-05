<?php
/*
 * Collabmed Solutions Ltd
 * Project: iClinic
 *  Author: Samuel Okoth <sodhiambo@collabmed.com>
 */
$checkout = '';
if (!empty($data['section'])) {
    $checkout = route('evaluation.sign_out', [$data['visit']->id, $data['section']]);
}
?>
<div class="box box-default">
    <div class="box-body">
        <div class="col-md-5">
            <dt>Name:</dt><dd>{{$patient->full_name}} <strong>({{(new Date($patient->dob))->age}} years)</strong></dd>
        </div>
        <div class="col-md-4">
            <dt>Payment Mode:</dt>
            <dd>{{$data['visit']->mode}}</dd>
        </div>
        <div class="col-md-3">
            @if(!$data['visit']->sign_out)
            <a class="btn btn-primary" href="{{$checkout}}">
                <i class="fa fa-sign-out"></i> Check out</a>
            @else
            <p>Patient signed out for this visit</p>
            @endif
        </div>
    </div>
</div>