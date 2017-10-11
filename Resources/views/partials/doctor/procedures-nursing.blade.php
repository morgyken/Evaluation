<?php
/*
 * Collabmed Solutions Ltd
 * Project: iClinic
 *  Author: Samuel Okoth <sodhiambo@collabmed.com>
 */
?>

{!! Form::open(['id'=>'procedures_nurse_form'])!!}
{!! Form::hidden('visit',$visit->id) !!}
<table class="table table-condensed table-borderless table-responsive nurse" id="procedures">
    @include('evaluation::partials.doctor.procedure_table',['_list'=>'nurse','_type'=>'treatment.nurse'])
</table>
{!! Form::close()!!}
<style>
    #procedures_nurse_form {
        height: 400px;
        overflow-y: scroll;
    }
</style>
<script>
    $(document).ready(function() {
        $('.nurse').DataTable( {
            paging:false
        } );
    } );
</script>

