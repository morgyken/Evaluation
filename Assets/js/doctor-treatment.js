/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


/*
 * =========================================================================
 * Treatment URL
 * =========================================================================
 */
/* global TREAT_URL, VISIT_ID, USER_ID, DIAGNOSIS_URL */

$(function () {
    $('#treatment_form input').blur(function () {
        show_selection();
    });
    $('#treatment_form .check').change(function () {
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
        $('#selected_treatment').hide();
        $('#treatment > tbody > tr').remove();
        var total = 0;
        $("#treatment_form input:checkbox:checked").each(function () {
            var procedure_id = $(this).val();
            var name = $('#name' + procedure_id).html();
            var cost = $('#cost' + procedure_id).val();
            total += parseInt(cost);
            $('#treatment > tbody').append('<tr><td>' + name + '</td><td>' + cost + '</td></tr>');
        });
        if (total) {
            $('#treatment > tbody').append('<tr><td>Total</td><td><strong>' + total + '</strong></td></tr>');
        }
        $('#selected_treatment').show();
        //  save_treatment();
    }
    $('#saveTreatment').click(function (e) {
        e.preventDefault();
        save_treatment();
    });
    function save_treatment() {
        $.ajax({type: "POST", url: DIAGNOSIS_URL, data: $('#treatment_form').serialize()});
        $('#selected_treatment').hide();
        location.reload();
    }
    $('#treatment_form').find('input:radio, input:checkbox').prop('checked', false);
    $('#selected_treatment').hide();

});