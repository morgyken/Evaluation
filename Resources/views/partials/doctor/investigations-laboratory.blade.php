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
    <thead>
    <tr>
        <th>#</th>
        <th>Procedure</th>
        <th>Number Performed</th>
        <th>Price</th>
    </tr>
    </thead>
    <tbody></tbody>
    {{--include('evaluation::partials.doctor.procedure_table',['_list'=>'laboratory','_type'=>'laboratory'])--}}
</table>
{!! Form::close()!!}
<script>
    var CREEPY_LAB = "{{ route('api.evaluation.get_procedures_for',['lab',$visit->id]) }}";
    $(function () {
        $('table#lab').dataTable({
            scrollY: "300px",
            paging: false,
            ajax: CREEPY_LAB,
//            deferRender: true,
////            scroller: true,
        });
    });
</script>