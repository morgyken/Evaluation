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

/* global DIAGNOSIS_URL, USER_ID, VISIT_ID, alertify */
$(function () {
    //mock hide this
    $('.instructions').hide();
    $('.investigation_item').find('table').DataTable({
        "scrollY": "300px",
        "paging": false
    });
    $('#previousInvestigations').dataTable({
        ajax: PERFOMED_INVESTIGATION_URL
    });
    $('#radiology_form input,#radiology_form textarea, #diagnosis_form input,#diagnosis_form textarea,#laboratory_form input,#laboratory_form textarea').blur(function () {
        show_selection_investigation();
    });

    $('#diagnosis_form,#laboratory_form,#radiology_form ').find('input:text').keyup(function () {
        show_selection_investigation();
    });
    $('#radiology_form,#laboratory_form,#diagnosis_form').find('input').on('ifChanged', function () {
        var elements = $(this).parents('tr').find('input');
        var texts = $(this).parents('tr').find('textarea');
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
        $('#show_selection').hide();
        $('#diagnosisInfo > tbody > tr').remove();
        var total = 0;
        $("#diagnosis_form,#laboratory_form,#radiology_form").find("input:checkbox:checked").each(function () {
            var procedure_id = $(this).val();
            var name = $('#name' + procedure_id).html();
            var amount = john_doe(procedure_id);
            total += parseInt(amount);
            $('#diagnosisInfo > tbody').append('<tr><td>' + name + '</td><td>' + amount + '</td></tr>');
        });
        if (total) {
            $('#diagnosisInfo > tbody').append('<tr><td>Total</td><td><strong>' + total + '</strong></td></tr>');
        }
        $('#show_selection').show();
    }

    var procedureInvestigations = [], arrIndex = {};

    function addOrReplaceInvestigation(object) {
        var index = arrIndex[object.id];
        if (index === undefined) {
            index = procedureInvestigations.length;
            arrIndex[object.id] = index;
        }
        procedureInvestigations[index] = object;
    }

    $('#saveDiagnosis').click(function (e) {
        e.preventDefault();
        $.ajax({
            type: "POST",
            url: DIAGNOSIS_URL,
            data: $('#radiology_form,#diagnosis_form, #laboratory_form').serialize(),
            success: function () {
                alertify.success('<i class="fa fa-check-circle"></i> Patient evaluation updated');
                $('.investigation_item').find('input').iCheck('uncheck');
                $('#previousInvestigations').dataTable().api().ajax.reload();
            },
            error: function () {
                alertify.error('<i class="fa fa-check-warning"></i> Could not save evalaution');
            }
        });
        //location.reload();
    });
    $('.investigation_item').find('input').iCheck('uncheck');
    $('#show_selection').hide();

    function get_amount_given(price, qty, discount) {
        try {
            var total = price * qty;
            var d = total * (discount / 100);
            var discounted = total - d;
            return discounted;
        } catch (e) {
            return price;
        }
    }

    function john_doe(procedure_id) {
        var cost = $('#cost' + procedure_id).val();
        var discount = $('#discount' + procedure_id).val();
        var quantity = $('#quantity' + procedure_id).val();
        var amount = get_amount_given(cost, quantity, discount);
        $('#amount' + procedure_id).val(amount);
        return amount;
    }
});