<?php
/*
 * Collabmed Solutions Ltd
 * Project: iClinic
 *  Author: Samuel Okoth <sodhiambo@collabmed.com>
 */

?>
{!! Form::open(['id'=>'procedures_doctor_form'])!!}
{!! Form::hidden('visit',$visit->id) !!}
<table class="table table-condensed table-borderless" id="procedures" width="100%">
    @include('evaluation::partials.doctor.procedure_table',['_list'=>'doctor'])
</table>
{!! Form::close()!!}

