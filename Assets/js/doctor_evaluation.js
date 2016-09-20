/*
 * Collabmed Solutions Ltd
 * Project: iClinic
 *  Author: Samuel Okoth <sodhiambo@collabmed.com>
 */

/* global DIAGNOSIS_URL, USER_ID, VISIT_ID, OPNOTES_URL, TREAT_URL, SET_DATE_URL, PRESCRIPTION_URL, NOTES_URL, VITALS_URL, VISIT_METAS_URL, PRELIMINARY_EXAMINATION */

$(document).ready(function () {
    /*
     * =========================================================================
     * Doctor notes
     * =========================================================================
     */
    $('.wh').keyup(function () {
        calculateRatio();
    });
    $('.bmi').keyup(function () {
        calculateBMI();
    });
    /*
     * Calculate the BMI
     * @returns {undefined}
     */
    function calculateBMI()
    {
        var weight = $('#weight').val();
        var height = $('#height').val();
        var bmi = 'N/A';
        var status = 'N/A';
        if (height && weight) {
            bmi = (weight / (height * height)).toFixed(4);
            if (bmi > 29.9)
            {
                status = "Obese"
            } else if (bmi < 30 && bmi > 24.9)
            {
                status = "Overweight"
            } else if (bmi < 24.8 && bmi > 18.5)
            {
                status = "Normal"
            } else if (bmi < 18.5)
            {
                status = "Underweight"
            }
        }
        $('#bmi').html(bmi);
        $('#bmi_status').html(status);
    }
    /**
     * Calculate waist -hip ration
     * @returns {undefined}
     */
    function calculateRatio()
    {
        var Hip = $('#hip').val();
        var Waist = $('#waist').val();
        var ration = 'N/A';
        if (Hip && Waist) {
            ration = (Waist / Hip).toFixed(4);
        }
        $('#ratio').html(ration);
    }
    $('#vitals_form').submit(function (e) {
        e.preventDefault();
        save_vitals();
    });
    $('#vitals_form input').blur(function () {
        save_vitals();
    });
    $('#vitals_form textarea').blur(function () {
        save_vitals();
    });
    function save_vitals() {
        var form_data = $('#vitals_form').append('<input type="hidden" name="visit" value="' + VISIT_ID + '" /> ');
        form_data = $('#vitals_form').append('<input type="hidden" name="user" value="' + USER_ID + '" /> ');
        $.ajax({type: "POST", url: VITALS_URL, data: form_data.serialize()});
    }

    /* start of doctor's notes*/
    $('#notes_form').submit(function (e) {
        e.preventDefault();
        save_notes();
    });
    $('#notes_form input').blur(function () {
        save_notes();
    });
    $('#notes_form textarea').blur(function () {
        save_notes();
    });
    function save_notes() {
        var form_data = $('#notes_form').append('<input type="hidden" name="visit" value="' + VISIT_ID + '" /> ');
        form_data = $('#notes_form').append('<input type="hidden" name="user" value="' + USER_ID + '" /> ');
        $.ajax({type: "POST", url: NOTES_URL, data: form_data.serialize()});
    }

    /*
     * =========================================================================
     * Prescriptions management
     * =========================================================================
     * */
    $('#prescription_form').submit(function (e) {
        e.preventDefault();
        save_prescription();
    });
    function save_prescription() {
        var drug = $('#prescription input[name=drug]').val();
        var duration = $('#prescription input[name=duration]').val();
        var dose = $('#prescription input[name=take]').val();
        $('#prescribed > tbody').append('<tr><td>' + drug + '</td><td>' + dose + '</td><td>' + duration + '</td></tr>');

        var form_data = $('#prescription').append('<input type="hidden" name="visit" value="' + VISIT_ID + '" /> ');
        form_data = $('#prescription').append('<input type="hidden" name="user" value="' + USER_ID + '" /> ');
        $.ajax({type: "POST", url: PRESCRIPTION_URL, data: form_data.serialize()});
        $("#prescription").find("input[type=text]").val("");
    }
    /*
     * =========================================================================
     * eye preview
     * =========================================================================
     */
    $('#eye_preview_form input').blur(function (e) {
        save_eye_preview();
    });
    $('#eye_preview_form').submit(function (e) {
        e.preventDefault();
        save_eye_preview();
    });
    function save_eye_preview() {
        var form_data = $('#eye_preview_form').append('<input type="hidden" name="visit" value="' + VISIT_ID + '" /> ');
        form_data = $('#eye_preview_form').append('<input type="hidden" name="user" value="' + USER_ID + '" /> ');
        $.ajax({type: "POST", url: PRELIMINARY_EXAMINATION, data: form_data.serialize()});
    }
    /*
     * =========================================================================
     * Visit date
     * =========================================================================
     */
    $('#visit_date').datepicker({"dateFormat": 'yy-mm-dd', "minDate": '-100y', onSelect: function () {
            set_visit_date();
        }, "constrainInput": false});
    $("#visit_date_form").submit(function (e) {
        e.preventDefault();
        set_visit_date();
    });
    function set_visit_date() {
        var form_data = $('#visit_date_form').append('<input type="hidden" name="visit" value="' + VISIT_ID + '" /> ');
        form_data = $('#visit_date_form').append('<input type="hidden" name="user" value="' + USER_ID + '" /> ');
        $.ajax({type: "POST", url: SET_DATE_URL, data: form_data.serialize(), success: function () {
                $('#visitdate').html("<i class='fa fa-check-circle'></i> Visit date set");
            }
        });
    }
    /*
     * All accodions
     */
    $('.accordion').accordion({heightStyle: "content"});

    //mock hide this
    $('.instructions').hide();
    /*
     * =========================================================================
     * Investigation settings
     * =========================================================================
     * */

    $('#diagnosis_form input,#diagnosis_form textarea,#laboratory_form input,#laboratory_form textarea').blur(function () {
        show_selection_investigation();
    });
    $('#laboratory_form .check,#diagnosis_form .check').click(function () {
        var elements = $(this).parent().parent().find('input');
        var texts = $(this).parent().parent().find('textarea');
        if ($(this).is(':checked')) {
            elements.prop('disabled', false);
            texts.prop('disabled', false);
            $(texts).parent().show();
        } else {
            elements.prop('disabled', true);
            texts.prop('disabled', true);
            $(texts).parent().hide();
        }
        $(this).prop('disabled', false);
        show_selection_investigation();
    });
    function show_selection_investigation() {
        $('#diagnosisTable').css('display', 'block');
        $('#diagnosisInfo > tbody > tr').remove();
        var total = 0;
        $("#diagnosis_form input:checkbox:checked").each(function () {
            var procedure_id = $(this).val();
            var name = $('#name' + procedure_id).html();
            var cost = $('#cost' + procedure_id).val();
            total += parseInt(cost);
            $('#diagnosisInfo > tbody').append('<tr><td>' + name + '</td><td>' + cost + '</td></tr>');
        });
        //for labs
        $("#laboratory_form input:checkbox:checked").each(function () {
            var procedure_id = $(this).val();
            var name = $('#name' + procedure_id).html();
            var cost = $('#cost' + procedure_id).val();
            total += parseInt(cost);
            $('#diagnosisInfo > tbody').append('<tr><td>' + name + '</td><td>' + cost + '</td></tr>');
        });
        console.log(total);
        if (total) {
            $('#diagnosisInfo > tbody').append('<tr><td>Total</td><td><strong>' + total + '</strong></td></tr>');
        }
        save_diagnosis();
        save_lab_tests();
    }
    $('#saveDiagnosis').click(function () {
        save_diagnosis();
        save_lab_tests();
    });
    function save_diagnosis() {
        var form_data = $('#diagnosis_form').append('<input type="hidden" name="visit" value="' + VISIT_ID + '" /> ');
        form_data = form_data.append('<input type="hidden" name="user" value="' + USER_ID + '" /> ');
        form_data = form_data.append('<input type="hidden" name="type" value="diagnosis" /> ');
        $.ajax({type: "POST", url: DIAGNOSIS_URL, data: form_data.serialize()});
    }
    function save_lab_tests() {
        var form_data = $('#laboratory_form').append('<input type="hidden" name="visit" value="' + VISIT_ID + '" /> ');
        form_data = form_data.append('<input type="hidden" name="user" value="' + USER_ID + '" /> ');
        form_data = form_data.append('<input type="hidden" name="type" value="laboratory" /> ');
        $.ajax({type: "POST", url: DIAGNOSIS_URL, data: form_data.serialize()});
    }

    /*
     * =========================================================================
     * Treatment URL
     * =========================================================================
     */
    $('#treatment_form input').blur(function () {
        show_selection();
    });
    $('#treatment_form .check').click(function () {
        var elements = $(this).parent().parent().find('input');
        if ($(this).is(':checked')) {
            elements.prop('disabled', false);
        } else {
            elements.prop('disabled', true);
        }
        $(this).prop('disabled', false);
        show_selection();
    });
    function show_selection() {
        $('#tableHolder').css('display', 'block');
        $('#treatment > tbody > tr').remove();
        var total = 0;
        $("#treatment_form input:checkbox:checked").each(function () {
            var procedure_id = $(this).val();
            var name = $('#name' + procedure_id).html();
            var cost = $('#cost' + procedure_id).val();
            var no = $('#no' + procedure_id).val();
            total += (cost * no);
            $('#treatment > tbody').append('<tr><td>' + name + '</td><td>' + cost + '</td><td>' + no + '</td></tr>');
        });
        if (total) {
            $('#treatment > tbody').append('<tr><td>Total</td><td><strong>' + total + '</strong></td><td></td></tr>');
        }
        save_treatment();
    }
    $('#saveTreatment').click(function () {
        save_treatment();
    });
    function save_treatment() {
        var form_data = $('#treatment_form').append('<input type="hidden" name="visit" value="' + VISIT_ID + '" /> ');
        form_data = $('#treatment_form').append('<input type="hidden" name="user" value="' + USER_ID + '" /> ');
        $.ajax({type: "POST", url: TREAT_URL, data: form_data.serialize()});
    }
    /*
     * =========================================================================
     * OP NOTES
     * =========================================================================
     */
    $('.date').datepicker({dateFormat: 'yy-mm-dd', minDate: 0});
    $('.time').timeAutocomplete({increment: 10, auto_value: false});
    $('#opnotes').submit(function (e) {
        e.preventDefault();
        save_opnotes();
    });
    $('#opnotes textarea').blur(function () {
        save_opnotes();
    });
    function save_opnotes() {
        var form_data = $('#opnotes').append('<input type="hidden" name="visit" value="' + VISIT_ID + '" /> ');
        form_data = $('#opnotes').append('<input type="hidden" name="user" value="' + USER_ID + '" /> ');
        $.ajax({type: "POST", url: OPNOTES_URL, data: form_data.serialize()});
    }


    //next steps
    $('#next_steps input').click(function () {
        save_metas();
    });
    function save_metas() {
        var result = $('#next_steps_result');
        result.hide();
        var form_data = $('#next_steps').append('<input type="hidden" name="visit" value="' + VISIT_ID + '" /> ');
        form_data = form_data.append('<input type="hidden" name="user" value="' + USER_ID + '" /> ');
        $.ajax({
            type: "POST",
            url: VISIT_METAS_URL,
            data: form_data.serialize(),
            success: function (data) {
                if (data) {
                    result.html('<br/><i class="fa fa-check-circle"></i> Next steps saved');
                    result.show();
                }
            }
        });
    }
});