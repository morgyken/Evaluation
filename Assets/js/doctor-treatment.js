/*
 * =========================================================================
 * Treatment URL
 * =========================================================================
 */
/* global TREAT_URL, VISIT_ID, USER_ID, DIAGNOSIS_URL, alertify */

$(function () {
    $('#procedures_doctor_form,#procedures_nurse_form').find('input:text').keyup(function () {
        preview_treatment_selection();
    });

    $('#procedures_doctor_form,#procedures_nurse_form').find('input').blur(function () {
        preview_treatment_selection();
    });

    $('#procedures_doctor_form,#procedures_nurse_form').find('input').on('ifChanged', function () {
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
        preview_treatment_selection();
    });

    function preview_treatment_selection() {
        $('#selected_treatment').hide();
        $('#treatment > tbody > tr').remove();
        var total = 0;

        $("#procedures_doctor_form,#procedures_nurse_form").find("input:checkbox:checked").each(function () {
            var procedure_id = $(this).val();
            var name = $('#name' + procedure_id).html();
            var amount = john_doe(procedure_id);
            total += parseInt(amount);
            $('#treatment > tbody').append('<tr><td>' + name + '</td><td>' + amount + '</td></tr>');
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
        $.ajax({
            type: "POST",
            url: DIAGNOSIS_URL,
            data: $('#procedures_doctor_form,#procedures_nurse_form').serialize(),
            success: function () {
                alertify.success('<i class="fa fa-check-circle"></i> Selected treatment procedures saved');
                $('#in_table').dataTable().api().ajax.reload();
            },
            error: function () {
                alertify.error('<i class="fa fa-check-warning"></i> Something wrong happened, Retry');
            }
        });
        //  $('#selected_treatment').hide();
        //
    }

    function john_doe(procedure_id) {
        var cost = $('#cost' + procedure_id).val();
        var discount = $('#discount' + procedure_id).val();
        var quantity = $('#quantity' + procedure_id).val();
        var amount = get_amount_given(cost, quantity, discount);
        $('#amount' + procedure_id).val(amount);
        return amount;
    }

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

    $('#treatment_form').find('input:radio, input:checkbox').prop('checked', false);
    $('#selected_treatment').hide();

});