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

    $('form input,form textarea').blur(function () {
        show_selection_investigation();
    });

    $('form input:text').keyup(function () {
        show_selection_investigation();
    });

    $('form .check').click(function () {
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
        $('#show_selection').hide();
        $('#diagnosisInfo > tbody > tr').remove();
        var total = 0;

        $("form input:checkbox:checked").each(function () {
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
        /*
         save_diagnosis();
         save_lab_tests();
         */
    }
    $('#saveOrder').click(function (e) {
        e.preventDefault();
        $.ajax({type: "POST",
            url: EXTERNAL_ORDER_URL,
            data: $('#radiology_form,#diagnosis_form, #laboratory_form').serialize(),
            success: function () {
                alertify.success('<i class="fa fa-check-circle"></i> Order for procedure(s) placed');
                location.reload();
            },
            error: function () {
                alertify.error('<i class="fa fa-check-warning"></i> Error: Could not save order');
            }
        });
        //location.reload();
    });
    //sick of this
    $('form').find('input:radio, input:checkbox').prop('checked', false);
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