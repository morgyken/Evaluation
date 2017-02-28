<?php
/*
 * Collabmed Solutions Ltd
 * Project: iClinic
 *  Author: Samuel Okoth <sodhiambo@collabmed.com>
 */
$notes = get_patient_doctor_notes($visit);
?>
{!! Form::open(['id'=>'notes_form']) !!}
{!! Form::hidden('visit',$visit->id) !!}
<div>
    <div class="form-group req">
        <label>Presenting Complaints</label>
        <textarea name='presenting_complaints' class="form-control"
                  rows='3'>{{$notes->presenting_complaints}}</textarea>
    </div>
    <div class="form-group">
        <label>Past Medical History</label>
        <textarea name='past_medical_history' class="form-control" rows='3'>{{$notes->past_medical_history}}</textarea>
    </div>
    <div class="form-group">
        <label>Examination</label>
        <textarea name='examination' class="form-control" rows='3'>{{$notes->examination}}</textarea>
    </div>
    @if(m_setting('evaluation.eye_exam'))
    @include('evaluation::partials.eye_diagnosis')
    @endif
    <div class="form-group req">
        <label>Investigations</label>
        <textarea name='investigations' class="form-control" rows='3'>{{$notes->examination}}</textarea>
    </div>
    <div class="form-group req">
        <label>Diagnosis</label><br/>
        <select multiple class="diagnosis_auto form-control" name="diagnosis[]" id="diagnosis_auto">s</select>
        {{$notes->codes}}
    </div>
    <div class="form-group req">
        <label>Plan of Treatment / Management</label>
        <textarea name='treatment_plan' class="form-control" rows='3'>{{$notes->treatment_plan}}</textarea>
    </div>
    <div class="pull-right">
        <button type="submit" class="btn btn-primary">Save Doctor's Notes</button>
    </div>
</div>
{!! Form::close() !!}
<script>
    $(document).ready(function () {
        $('.diagnosis_auto').select2({
            "theme": "classic",
            "placeholder": 'Please select an item',
            "formatNoMatches": function () {
                return "No matches found";
            },
            "formatInputTooShort": function (input, min) {
                return "Please enter " + (min - input.length) + " more characters";
            },
            "formatInputTooLong": function (input, max) {
                return "Please enter " + (input.length - max) + " less characters";
            },
            "formatSelectionTooBig": function (limit) {
                return "You can only select " + limit + " items";
            },
            "formatLoadMore": function (pageNumber) {
                return "Loading more results...";
            },
            "formatSearching": function () {
                return "Searching...";
            },
            "minimumInputLength": 2,
            "allowClear": true,
            "ajax": {
                "url": "{{route('api.evaluation.diagnosis_auto')}}",
                "dataType": "json",
                "cache": true,
                "data": function (term, page) {
                    return {
                        term: term
                    };
                },
                "results": function (data, page) {
                    return {results: data};
                }
            }
        });
    });
</script>

