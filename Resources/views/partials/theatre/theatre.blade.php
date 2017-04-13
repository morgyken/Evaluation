<?php
/*
 * Collabmed Solutions Ltd
 * Project: iClinic
 *  Author: Samuel Okoth <sodhiambo@collabmed.com>
 */
?>

<div class="row">
    {!! Form::open(['id'=>'eye_preview']) !!}
    <div class="col-md-12">
        <div class="col-md-5">
            <div class="form-group req">
                <label>IOP Recording</label>
                <textarea name='iop_recording' class="form-control" rows='3'></textarea>
            </div>
            <div class="form-group req">
                <label>Uncorrected Vision</label>
                <textarea name='uncorrected_vision' class="form-control" rows='3'></textarea>
            </div>
            <div class="form-group req">
                <label>Blood Pressure</label>
                <textarea name='blood_pressure' class="form-control" rows='3'></textarea>
            </div>
            <div class="form-group req">
                <label>Dilation</label>
                <textarea name='dilation' class="form-control" rows='3'></textarea>
            </div>
        </div>
        <div class="col-md-5 col-md-offset-2">
            <div class="form-group req">
                <label>Constriction</label>
                <textarea name='constriction' class="form-control" rows='3'></textarea>
            </div>
            <div class="form-group req">
                <label>Blood Sugar</label>
                <textarea name='blood_sugar' class="form-control" rows='3'></textarea>
            </div>
            <div class="form-group req">
                <label>Refraction</label>
                <textarea name='refraction' class="form-control" rows='3'></textarea>
            </div>
            <div class="form-group req">
                <label>Remarks</label>
                <textarea name='remarks' class="form-control" rows='3'></textarea>
            </div>
        </div>
    </div>
    {!! Form::close() !!}
</div>