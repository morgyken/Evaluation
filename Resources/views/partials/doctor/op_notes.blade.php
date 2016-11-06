<?php
/*
 * Collabmed Solutions Ltd
 * Project: iClinic
 *  Author: Samuel Okoth <sodhiambo@collabmed.com>
 */
$op_notes = get_visit_data($visit, 'op_notes');
?>
<div class="row">
    <div class="col-md-12">
        {!! Form::open(['id'=>'opnotes'])!!}
        {!! Form::hidden('visit',$visit->id) !!}
        <div class="form-horizontal">
            <div class="col-md-6">
                <div class="form-group">
                    <label>Indication of Surgery</label>
                    <textarea name='surgery_indication' class="form-control" rows='3'>{{$op_notes->surgery_indication}}</textarea>
                </div>
                <div class="form-group">
                    <label>Implants</label>
                    <textarea name='implants' class="form-control" rows='3'>{{$op_notes->implants}}</textarea>
                </div>
                <div class="form-group">
                    <label>Post OP</label>
                    <textarea name='postop' class="form-control" rows='3'>{{$op_notes->postop}}</textarea>
                </div>
                <div class="form-group">
                    <label>Indication + Procedure</label>
                    <textarea name='indication' class="form-control" rows='3'>{{$op_notes->indication}}</textarea>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label col-md-4">Date</label>
                    <div class="col-md-8">
                        <input class="form-control date"  name="date" value="{{(new Date($op_notes->date))->format('Y-m-d')}}" />
                    </div>
                </div>
                <div class="form-group req {{ $errors->has('doctor') ? ' has-error' : '' }}">
                    {!! Form::label('doctor', 'Surgeon',['class'=>'control-label col-md-4']) !!}
                    <div class="col-md-8">
                        {!! Form::select('doctor',get_doctors(), old('doctor',$op_notes->doctor), ['class' => 'form-control']) !!}
                        {!! $errors->first('doctor', '<span class="help-block">:message</span>') !!}
                    </div>
                </div>
                <div class="pull-right">
                    <button type="submit" class="btn btn-primary" id="opSave"><i class="fa fa-save"></i> Save</button>
                </div>
            </div>
        </div>
        {!! Form::close()!!}
    </div>
</div>