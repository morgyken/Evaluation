<?php
/**
 * Created by PhpStorm.
 * User: bravoh
 * Date: 10/31/17
 * Time: 10:13 PM
 */
?>
{!! Form::open(['id'=>'procedures_dental_form'])!!}
{!! Form::hidden('visit',$visit->id) !!}
<table class="table table-condensed table-borderless table-responsive dental" id="procedures">
    @include('evaluation::partials.doctor.procedure_table',['_list'=>'dental','_type'=>'dental'])
</table>
{!! Form::close()!!}
<style>
    #procedures_dental_form {
        height: 400px;
        overflow-y: scroll;
    }
</style>
<script>
    $(document).ready(function() {
        try {
            $('.dental').DataTable( {
                paging:false
            } );
        }catch (e){

        }
    } );
</script>
