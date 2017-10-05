<?php
/*
 * Collabmed Solutions Ltd
 * Project: iClinic
 *  Author: Samuel Okoth <sodhiambo@collabmed.com>
 */
?>

{!! Form::open(['id'=>'diagnosis_form'])!!}
{!! Form::hidden('visit',$visit->id) !!}
<table class="table table-condensed table-borderless table-responsive" id="di">
    @include('evaluation::partials.doctor.procedure_table',['_list'=>'diagnostics'])
</table>
{!! Form::close()!!}