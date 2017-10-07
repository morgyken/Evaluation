/* global PRESCRIPTION_URL, alertify */

$(function () {
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
        $.ajax({
            type: "POST",
            url: PRESCRIPTION_URL,
            data: $('#prescription_form').serialize(),
            success: function () {
                var drug = $('#prescription_form').find('input[name=drug]').val();
                if (!drug) {
                    drug = $("#prescription_form").find("select[name=drug] option:selected").text();
                    // drug = $('#prescription_form select[name=drug]').val();
                }
                var duration = $('#prescription_form input[name=duration]').val();
                var units = $('#prescription_form input[name=quantity]').val();
                var dose = $('#prescription_form input[name=take]').val();
                var whereto = $("#prescription_form select[name=whereto] option:selected").text();
                var method = $("#prescription_form select[name=method] option:selected").text();
                var measure = $("#prescription_form select[name=time_measure] option:selected").text();
                var shower = dose + ' ' + whereto + ' ' + method;
                $('#prescribed_drugs > tbody').append('<tr><td>' + drug + '</td><td>' + shower + '</td><td>' + units + '</td><td>' + duration + ' ' + measure + '</td></tr>');
                alertify.success('<i class="fa fa-check-circle"></i> Prescription added');
                $('#hide-this').hide();
                $('#prescription_form').trigger("reset");
            },
            error: function () {
                alertify.error('<i class="fa fa-check-warning"></i> An error occured prescribing drug');
            }
        });
    }
});