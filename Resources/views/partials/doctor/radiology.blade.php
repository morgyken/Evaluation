<?php
/*
 * Collabmed Solutions Ltd
 * Project: iClinic
 *  Author: Samuel Okoth <sodhiambo@collabmed.com>
 *///$diagnosis=

?>
{!! Form::open(['id'=>'radiology_form'])!!}
{!! Form::hidden('visit',$visit->id) !!}
<table class="table table-condensed table-borderless table-responsive" id="rad">
    @include('evaluation::partials.doctor.procedure_table',['_list'=>'radiology','_type'=>'radiology'])
</table>
{!! Form::close()!!}