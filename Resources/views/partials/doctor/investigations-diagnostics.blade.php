<?php
/*
 * Collabmed Solutions Ltd
 * Project: iClinic
 *  Author: Samuel Okoth <sodhiambo@collabmed.com>
 */
?>

{!! Form::open(['id'=>'diagnosis_form'])!!}
{!! Form::hidden('visit',$visit->id) !!}
<table class="table table-condensed table-borderless table-responsive" id="di" width="100%">
    @include('evaluation::partials.doctor.procedure_table',['_list'=>'diagnostics','_type'=>'diagnostics'])
</table>
{!! Form::close()!!}