<?php
/*
 * Collabmed Solutions Ltd
 * Project: iClinic
 *  Author: Samuel Okoth <sodhiambo@collabmed.com>
 */
$form = vitals_for_visit($visit);
$first_vital = vitals_for_patient($visit->patient);
?>
<div class="row">
    {!! Form::open(['id'=>'vitals_form']) !!}
    {!! Form::hidden('visit',$visit->id) !!}
    <div class="col-md-12">
        <div class="col-md-3">
            <div class="form-group req">
                <label class="col-md-6 control-label">Weight</label>
                <div class="col-md-6 input-group">
                    <input name="weight" class="form-control input-sm bmi" type="text" value="{{$form->weight}}"
                           id="weight"/>
                    <span class="input-group-addon">Kgs</span>
                </div>
            </div>
            <div class="form-group req">
                <label class="col-md-6 control-label">Height</label>
                <div class="col-md-6 input-group">
                    <input name="height" class="form-control input-sm bmi" type="text" value="{{$form->height}}"
                           id="height"/>
                    <span class="input-group-addon">metres</span>
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-6 control-label">BP Systolic</label>
                <div class="col-md-6 input-group">
                    <input name="bp_systolic" class="form-control input-sm" value="{{$form->bp_systolic}}" type="text"/>
                    <span class="input-group-addon">mm/hg</span>
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-6 control-label">BP Diastolic</label>
                <div class="col-md-6 input-group">
                    <input name="bp_diastolic" class="form-control input-sm" value="{{$form->bp_diastolic}}"
                           type="text"/>
                    <span class="input-group-addon">mm/hg</span>
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-6 control-label">Pulse</label>
                <div class="col-md-6 input-group">
                    <input name="pulse" class="form-control input-sm" type="text" value="{{$form->pulse}}"/>
                    <span class="input-group-addon">per min</span>
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-6 control-label">Respiration</label>
                <div class="col-md-6 input-group">
                    <input name="respiration" class="form-control input-sm" value="{{$form->respiration}}" type="text"/>
                    <span class="input-group-addon">per min</span>
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-6 control-label">Temperature</label>
                <div class="col-md-6 input-group">
                    <input name="temperature" class="form-control input-sm" value="{{$form->temperature}}" type="text"/>
                    <span class="input-group-addon">&deg;C</span>
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-6 control-label">Temperature Location</label>
                <div class="col-md-6">
                    {!! Form::select('temperature_location',mconfig('evaluation.options.temperature_location'),$form->temperature_location ,[ 'class'=>"form-control",'placeholder'=>'Choose..'])!!}
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label class="col-md-6 control-label">Oxygen</label>
                <div class="col-md-6 input-group">
                    <input name="oxygen" class="form-control input-sm" type="text" value="{{$form->oxygen}}"
                           placeholder="Oxygen Saturation (%)"/>
                    <span class="input-group-addon">%</span>
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-6 control-label">Waist</label>
                <div class="col-md-6 input-group">
                    <input name="waist" class="form-control input-sm wh" type="text" value="{{$form->waist}}" id="waist"
                           placeholder="Waist Circumference"/>
                    <span class="input-group-addon">cm</span>
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-6 control-label">Hip</label>
                <div class="col-md-6 input-group">
                    <input name="hip" class="form-control input-sm wh" type="text" value="{{$form->hip}}" id="hip"
                           placeholder="Hip Circumference"/>
                    <span class="input-group-addon">cm</span>
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-6 control-label">Blood Sugar</label>
                <div class="col-md-6">
                    <input name="blood_sugar" value="{{$form->blood_sugar}}" class="form-control input-sm" type="text"/>

                </div>
            </div>
            <div class="form-group">
                <label class="col-md-6 control-label">Blood sugar unit</label>
                <div class="col-md-6">
                    <label class="radio-inline"><input type='radio' name='blood_sugar_units' value='mmol/L' checked>
                        mmol/L</label>
                    <label class="radio-inline"><input type='radio' name='blood_sugar_units' value='mg/dL'>
                        mg/dL</label>
                </div>
            </div>
            <hr/>
            <div id="analysis">
                <div class="form-group">
                    <label class="col-md-4 control-label">BMI</label>
                    <div class="col-md-8">
                        <p class="form-control-static"><span id="bmi">N/A</span></p>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-4 control-label">BMI Status</label>
                    <div class="col-md-8">
                        <p class="form-control-static"><span id="bmi_status">N/A</span></p>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-4 control-label">Waist/Hip ratio</label>
                    <div class="col-md-8">
                        <p class="form-control-static"><span id="ratio">N/A</span></p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-md-offset-1">
            @if($first_vital !== null)
                <div class="form-group">
                    <label>Allergies</label>
                    <textarea name='allergies' rows='3' placeholder="Alergies"
                              class="form-control">{{$first_vital->allergies}}</textarea>
                </div>
                <div class="form-group">
                    <label>Chronic Illnesses</label>
                    <textarea name='chronic_illnesses' rows='3' placeholder="Chronic Illnesses"
                              class="form-control">{{$first_vital->chronic_illnesses}}</textarea>
                </div>
            @else
                <div class="form-group">
                    <label>Allergies</label>
                    <textarea name='allergies' rows='3' placeholder="Alergies"
                              class="form-control">{{$form->allergies}}</textarea>
                </div>
                <div class="form-group">
                    <label>Chronic Illnesses</label>
                    <textarea name='chronic_illnesses' rows='3' placeholder="Chronic Illnesses"
                              class="form-control">{{$form->chronic_illnesses}}</textarea>
                </div>
            @endif

            <div class="form-group">
                <label>Notes</label>
                <textarea name='nurse_notes' rows='3' placeholder="Nurses' Notes"
                          class="form-control">{{$form->nurse_notes}}</textarea>
            </div>
        </div>
    </div>
    <div class="col-md-12">
        <div class="pull-right">
            <button type="button" class="btn btn-primary"><i class="fa fa-save"></i> Save</button>
        </div>
        <div class="clearfix"></div>
        <p class="text-success">Any changes are saved automatically <i class="fa fa-check-square-o"></i></p>
    </div>
    {!! Form::close() !!}
</div>