<?php
/*
 * Collabmed Solutions Ltd
 * Project: iClinic
 *  Author: Samuel Okoth <sodhiambo@collabmed.com>
 *///$diagnosis=
?>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css">

{!! Form::open(['id'=>'laboratory_form'])!!}
{!! Form::hidden('visit',$visit->id) !!}
<table id="lab" class="display" cellspacing="0" width="100%">
    @include('evaluation::partials.doctor.procedure_table',['_list'=>'laboratory'])
</table>
{!! Form::close()!!}