<?php
/*
 * Collabmed Solutions Ltd
 * Project: iClinic
 *  Author: Samuel Okoth <sodhiambo@collabmed.com>
 */
$checkout = '';
try {
    $patient = $visit->patients;
    if (!empty($section)) {
        $checkout = route('evaluation.sign_out', [$visit->id, $section]);
    }
} catch (\Exception $e) {

}
?>
<div class="box box-info">
    <div class="box-body">
        <div class="col-md-5">
            <dt>Name:</dt>
            <dd>{{$patient->full_name}}
                <strong><u>{{$patient->sex?$patient->sex:''}}</u></strong>
            </dd>
            <dt>Age:</dt>
            <?php try { ?>
                <dd>{{(new Date($patient->dob))->diff(Carbon\Carbon::now())->format('%y years, %m months and %d days')}} Old</dd>
                <?php
            } catch (\Exception $e) {

            }
            ?>
        </div>
        <div class="col-md-4">
            <dt>Payment Mode:</dt>
            <dd>{{$visit->mode}}</dd>
        </div>
        <div class="col-md-3">
            @if(!$visit->sign_out)
            <a class="btn btn-primary" href="{{$checkout}}">
                <i class="fa fa-sign-out"></i> Check out</a>
            @else
            <p>Patient signed out for this visit</p>
            @endif
        </div>
        <hr/>
        <div class="col-md-12">
            {{--@include('evaluation::partials.common.fraola')--}}
        </div>
    </div>
</div>