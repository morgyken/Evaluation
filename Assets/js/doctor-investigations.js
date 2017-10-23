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
    get_performed_investigation();
    try{
        $('#in_table').dataTable({ajax: PERFOMED_URL});
    }catch(e) {}
    //mock hide this
    $('.instructions').hide();

    $('#ultrasound_form input, #radiology_form input,#ultrasound_form textarea,#radilogy_form textarea, #diagnosis_form input,#diagnosis_form textarea,#laboratory_form input,#laboratory_form textarea').blur(function () {
        show_selection_investigation();
    });

    $('#diagnosis_form input:text').keyup(function () {
        show_selection_investigation();
    });

    $('#ultrasound_form input:text').keyup(function () {
        show_selection_investigation();
    });

    $('#laboratory_form input:text').keyup(function () {
        show_selection_investigation();
    });

    $('#radiology_form input:text').keyup(function () {
        show_selection_investigation();
    });

    $('#ultrasound_form .check, #radiology_form .check,#laboratory_form .check,#diagnosis_form .check').click(function () {
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
        $("#diagnosis_form input:checkbox:checked").each(function () {
            var procedure_id = $(this).val();
            var name = $('#name' + procedure_id).html();
            var amount = john_doe(procedure_id);
            total += parseInt(amount);
            if(!HIDE_PRICES){
                $('#diagnosisInfo > tbody').append('<tr><td>' + name + '</td><td>' + amount + '</td></tr>');
            }else {
                $('#diagnosisInfo > tbody').append('<tr><td>' + name + '</td></tr>');
            }
        });

        //for labs
        $("#laboratory_form input:checkbox:checked").each(function () {
            var procedure_id = $(this).val();
            var name = $('#name' + procedure_id).html();
            var amount = john_doe(procedure_id);
            total += parseInt(amount);
            if(!HIDE_PRICES){
                $('#diagnosisInfo > tbody').append('<tr><td>' + name + '</td><td>' + amount + '</td></tr>');
            }else {
                $('#diagnosisInfo > tbody').append('<tr><td>' + name + '</td></tr>');
            }
        });

        //for radiology
        $("#radiology_form input:checkbox:checked").each(function () {
            var procedure_id = $(this).val();
            var name = $('#name' + procedure_id).html();
            var amount = john_doe(procedure_id);
            total += parseInt(amount);
            if(!HIDE_PRICES){
                $('#diagnosisInfo > tbody').append('<tr><td>' + name + '</td><td>' + amount + '</td></tr>');
            }else {
                $('#diagnosisInfo > tbody').append('<tr><td>' + name + '</td></tr>');
            }
        });

        //for radiology
        $("#ultrasound_form input:checkbox:checked").each(function () {
            var procedure_id = $(this).val();
            var name = $('#name' + procedure_id).html();
            var amount = john_doe(procedure_id);
            total += parseInt(amount);
            if(!HIDE_PRICES){
                $('#diagnosisInfo > tbody').append('<tr><td>' + name + '</td><td>' + amount + '</td></tr>');
            }else {
                $('#diagnosisInfo > tbody').append('<tr><td>' + name + '</td></tr>');
            }
        });

        if (total) {
            if(!HIDE_PRICES){
                $('#diagnosisInfo > tbody').append('<tr><td>Total</td><td><strong>' + total + '</strong></td></tr>');
            }
        }
        $('#show_selection').show();
        /*
         save_diagnosis();
         save_lab_tests();
         */
    }


    $('#saveDiagnosis').click(function (e) {
        e.preventDefault();
        $.ajax({type: "POST",
            url: DIAGNOSIS_URL,
            data: $('#ultrasound_form,#radiology_form,#diagnosis_form, #laboratory_form').serialize(),
            success: function () {
                alertify.success('<i class="fa fa-check-circle"></i> Patient evaluation updated');
                get_performed_investigation();
                //location.reload();
            },
            error: function () {
                alertify.error('<i class="fa fa-check-warning"></i> Could not save evalaution');
            }
        });
        //location.reload();
    });

    // $('#saveDiagnosis').click(function (e) {
    //     e.preventDefault();
    //     $.ajax({type: "POST",
    //         url: DIAGNOSIS_URL,
    //         data: $('#radiology_form,#diagnosis_form, #laboratory_form').serialize(),
    //         success: function () {
    //             alertify.success('<i class="fa fa-check-circle"></i> Patient evaluation updated');
    //             location.reload();
    //         },
    //         error: function () {
    //             alertify.error('<i class="fa fa-check-warning"></i> Could not save evalaution');
    //         }
    //     });
    //     //location.reload();
    // });
    //sick of this http://www.right-to-education.org/issue-page/marginalised-groups/girls-women

    $('#laboratory_form').find('input:radio, input:checkbox').prop('checked', false);
    $('#diagnosis_form').find('input:radio, input:checkbox').prop('checked', false);
    $('#radiology_form').find('input:radio, input:checkbox').prop('checked', false);
    $('#ultrasound_form').find('input:radio, input:checkbox').prop('checked', false);
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
    
    function get_performed_investigation() {
        $.ajax({
            type: "GET",
            url: DONE_IVESTIGATION_URL,
            success: function (data) {
                $('.done_investigation').html(data);
            },
            error: function () {
                alertify.error('<i class="fa fa-check-warning"></i> Unable to refresh performed treatment table');
            }
        });
    }
});