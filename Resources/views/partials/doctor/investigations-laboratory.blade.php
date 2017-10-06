<?php
/*
 * Collabmed Solutions Ltd
 * Project: iClinic
 *  Author: Samuel Okoth <sodhiambo@collabmed.com>
 *///$diagnosis=
?>
{!! Form::open(['id'=>'laboratory_form'])!!}
{!! Form::hidden('visit',$visit->id) !!}
<table id="lab" class="display" cellspacing="0" width="100%">
    @include('evaluation::partials.doctor.procedure_table',['_list'=>'laboratory','_type'=>'laboratory'])
</table>
{!! Form::close()!!}