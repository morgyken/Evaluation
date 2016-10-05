<?php
/*
 * Collabmed Solutions Ltd
 * Project: iClinic
 *  Author: Samuel Okoth <sodhiambo@collabmed.com>
 */
?>
<div class="row">

    <div class="col-md-12">
        <div class="col-md-6">
            {!! Form::open(['id'=>'notes_form']) !!}
            @include('evaluation::partials.notes')
            {!! Form::close() !!}
        </div>
        <div class="col-md-6">
            @include('evaluation::partials.prescription')
            @include('evaluation::partials.sickoff')
            <!--include('evaluation::partials.visit_date')-->
            @include('evaluation::partials.next_visit')
            @include('evaluation::partials.next_steps')
        </div>
        <div class="clearfix"></div>
        <p class="text-success">Any changes are saved automatically <i class="fa fa-check-square-o"></i></p>
    </div>

</div>
<script type="text/javascript">
    $(document).ready(function () {
        var availableTags = <?php echo json_encode(get_diagnosis_codes()); ?>;
        $(".diag").autocomplete({source: availableTags, minLength: 4});
    });
</script>