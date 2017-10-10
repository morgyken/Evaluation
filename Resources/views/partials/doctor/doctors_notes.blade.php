<?php
/*
 * Collabmed Solutions Ltd
 * Project: iClinic
 *  Author: Samuel Okoth <sodhiambo@collabmed.com>
 */
?>
<div class="row">

    <div class="col-md-12">
        <div class="col-md-5">
            @include('evaluation::partials.doctor.notes')
            @include('evaluation::partials.doctor.sick_off')
        </div>
        <div class="col-md-6 col-md-offset-1">
            @include('evaluation::partials.doctor.prescription')
            {{--include('evaluation::partials.doctor.visit_date')--}}
            {{--include('evaluation::partials.doctor.next_visit')--}}
            @include('evaluation::partials.doctor.next_steps')
        </div>
        <div class="clearfix"></div>
        <p class="text-success">Any changes are saved automatically <i class="fa fa-check-square-o"></i></p>
    </div>

</div>