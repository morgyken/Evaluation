/*
 * Collabmed Solutions Ltd
 * Project: iClinic
 *  Author: Samuel Okoth <sodhiambo@collabmed.com>
 */

/* global NOTES_URL, alertify */

$(function () {
    /*
     * =========================================================================
     * Doctor notes
     * =========================================================================
     */

    /* start of doctor's notes*/
    $('#notes_form').submit(function (e) {
        e.preventDefault();
        save_notes();
    });
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
        // alertify.theme("bootstrap");
        $.ajax({
            type: "POST",
            url: NOTES_URL,
            data: $('#notes_form').serialize(),
            success: function () {
                alertify.success('Your notes saved');
            },
            error: function () {
                alertify.error('Something wrong happened, Retry');
            }
        });
        var diagnoses = $('#notes_form').find('[name=diagnosis]').val();
        if (!diagnoses) {
            // alertify.logPosition("bottom right");
            alertify.log("Please enter diagnoses");
            // alertify.reset();
        }
    }


});