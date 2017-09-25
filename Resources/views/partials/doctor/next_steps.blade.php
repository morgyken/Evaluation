<?php
/*
 * Collabmed Solutions Ltd
 * Project: iClinic
 *  Author: Samuel Okoth <sodhiambo@collabmed.com>
 * @todo Initial check states
 */
$meta = get_visit_meta($visit);
?>
<div class="row">
    <div class="col-md-12">
        <div class="box box-info">
            <div class="box-header">
                <h4 class="box-title">Follow-up plan *</h4>
            </div>
            {!! Form::open(['id'=>'next_steps'])!!}
            {!! Form::hidden('visit',$visit->id) !!}
            <div class="box-body">
                <div class="checkbox">
                    <label><input type="checkbox" value="1" name="call" /> Call patient for follow up</label>
                </div>
                <div class="checkbox">
                    <label><input type="checkbox" value="1" name="pre_authorization"/> Get pre-authorization</label>
                </div>
                <div class="checkbox">
                    <label><input type="checkbox" value="1" name="book_theatre"/> Book for theatre</label>
                </div>
                <div class="checkbox">
                    <label><input type="checkbox" value="1" name="refer_specialist"/> Refer to specialist</label>
                </div>
                <div class="text-success"> <strong id="next_steps_result"></strong></div>
            </div>
            {!! Form::close()!!}
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        //
    });
</script>