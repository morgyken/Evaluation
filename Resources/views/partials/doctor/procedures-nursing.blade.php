<?php
/*
 * Collabmed Solutions Ltd
 * Project: iClinic
 *  Author: Samuel Okoth <sodhiambo@collabmed.com>
 */
?>

{!! Form::open(['id'=>'procedures_nurse_form'])!!}
{!! Form::hidden('visit',$visit->id) !!}
<table class="table table-condensed table-borderless table-responsive" id="procedures">
    @include('evaluation::partials.doctor.procedure_table',['_list'=>'nurse'])
</table>
{!! Form::close()!!}

