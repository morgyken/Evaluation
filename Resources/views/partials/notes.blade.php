<?php
/*
 * Collabmed Solutions Ltd
 * Project: iClinic
 *  Author: Samuel Okoth <sodhiambo@collabmed.com>
 */
$notes = get_patient_doctor_notes($data['visit']);


$diagnosis_p[0] = $diagnosis_p[1] = $diagnosis_p[2] = null;/*
$diagnosis_p = unserialize($notes->diagnosis);*/
?>
<div>
    <div class="form-group req">
        <label>Presenting Complaints</label>
        <textarea name='presenting_complaints' class="form-control" rows='3'>{{$notes->presenting_complaints}}</textarea>
    </div>
    <div class="form-group">
        <label>Past Medical History</label>
        <textarea name='past_medical_history' class="form-control" rows='3'>{{$notes->past_medical_history}}</textarea>
    </div>
    <div class="form-group">
        <label>Examination</label>
        <textarea name='examination' class="form-control" rows='3'>{{$notes->examination}}</textarea>
    </div>
    @include('evaluation::partials.eye_diagnosis')
    <div class="form-group req">
        <label>Investigations</label>
        <textarea name='investigations' class="form-control" rows='3'>{{$notes->examination}}</textarea>
    </div>
    <div class="form-group req">
        <label>Diagnosis</label><br/>
        <input type='text' name='diagnosis[]' id='d1'  class="form-control input-sm diag" placeholder="Diagnosis 1" value="{{ $diagnosis_p[0]}}"/>
        <input type='text' name='diagnosis[]' id='d2'  class="form-control input-sm diag" placeholder="Diagnosis 2" value="{{$diagnosis_p[1]}}"/>
        <input type='text' name='diagnosis[]' id='d3'  class="form-control input-sm diag" placeholder="Diagnosis 3" value="{{$diagnosis_p[2]}}"/>
    </div>
    <div class="form-group req">
        <label>Plan of Treatment / Management</label>
        <textarea name='treatment_plan' class="form-control" rows='3'>{{$notes->treatment_plan}}</textarea>
    </div>
    <div class="pull-right">
        <button type="submit" class="btn btn-primary">Save Doctor's Notes</button>
    </div>
</div>

