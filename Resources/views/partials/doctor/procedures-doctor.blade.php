<?php
/*
 * Collabmed Solutions Ltd
 * Project: iClinic
 *  Author: Samuel Okoth <sodhiambo@collabmed.com>
 */

?>
{!! Form::open(['id'=>'procedures_doctor_form'])!!}
{!! Form::hidden('visit',$visit->id) !!}
<table class="table table-condensed table-borderless doctor" id="procedures" width="100%">
    @include('evaluation::partials.doctor.procedure_table',['_list'=>'doctor','_type'=>'treatment'])
</table>
{!! Form::close()!!}
<style>
    #procedures_doctor_form {
        height: 400px;
        overflow-y: scroll;
    }
</style>
<script>
    $(document).ready(function() {
        try {
            $('.doctor').DataTable( {
                paging:false
            } );
        }catch (e){

        }
    } );
</script>

