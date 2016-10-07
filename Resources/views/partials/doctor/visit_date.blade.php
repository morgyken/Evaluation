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
                {!! Form::open(['id'=>'visit_date_form'])!!}
                <div class="box-body">
                    <input type="hidden" name="patient" value="{{$visit->patient}}"/>
                    <div class="form-group">
                        <label class="col-md-4 control-label">Set Visit Date: </label>
                        <div class="col-md-8">
                            <input type="text" id="visit_date" value="{{(new Date($visit->created_at))->format('Y-m-d')}}" name="visit_date" class="form-control"/>
                            <div class="help-block"> <span class="text-success" id="visitdate"></span></div>
                        </div>
                    </div>
                </div>
                {!! Form::close()!!}
            </div>
        </div>
    </div>
</div>