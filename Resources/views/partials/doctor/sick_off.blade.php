<?php
/*
 * Collabmed Solutions Ltd
 * Project: iClinic
 *  Author: Samuel Okoth <sodhiambo@collabmed.com>
 */
?>

<div class="row">
    <div class="form-horizontal">
        <div class="col-md-12">
            <div class="box box-primary">
                {!! Form::open(['id'=>'sickoff','route' => 'evaluation.report.sick_off','target'=>"_blank"])!!}
                {!! Form::hidden('visit',$visit->id) !!}
                <div class="box-header with-border">
                    <h4 class="box-title">Sickoff notes</h4>
                </div>
                <div class="box-body">
                    <input type="hidden" name="patient" value="{{$visit->patient}}"/>
                    <div class="form-group">
                        <label class="col-md-4 control-label">Sick of period</label>
                        <div class="col-md-8">
                            <input type="text" name="period" placeholder="eg. 2 months" required/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-4 control-label">Review On</label>
                        <div class="col-md-8">
                            <input type="text" id="date" name="review_on"/>
                        </div>
                    </div>
                </div>
                <div class="box-footer">
                    <div class="pull-right">
                        <button type="submit" class="btn btn-primary"><i class="fa fa-file-word-o"></i> Save to Word</button>
                    </div>
                </div>
                {!! Form::close()!!}
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        $('#date').datepicker({dateFormat: 'dd/mm/yy'});
    });
</script>