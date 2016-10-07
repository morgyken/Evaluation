/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/*
 * =========================================================================
 * Investigation settings
 * =========================================================================
 * */

/* global DIAGNOSIS_URL, USER_ID, VISIT_ID */
$(document).ready(function () {
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
        if (total) {
            $('#diagnosisInfo > tbody').append('<tr><td>Total</td><td><strong>' + total + '</strong></td></tr>');
        }

        /*
         save_diagnosis();
         save_lab_tests();
         */
    }
    $('#saveDiagnosis').click(function (e) {
        e.preventDefault();
        $.ajax({type: "POST", url: DIAGNOSIS_URL, data: $('#diagnosis_form, #laboratory_form').serialize()});
        $('#diagnosis_form input:checkbox').removeAttr('checked');
        $('#diagnosisInfo > tbody > tr').remove();
        location.reload();
    });
    //sick of this
    $('#laboratory_form').find('input:radio, input:checkbox').prop('checked', false);
});