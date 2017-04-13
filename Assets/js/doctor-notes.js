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
    });    $('#notes_form').submit(function (e) {
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
        $.ajax({
            type: "POST",
            url: NOTES_URL,
            data: $('#notes_form').serialize(),
            success: function () {
                alertify.success('<i class="fa fa-check-circle"></i> Your notes saved');
            },
            error: function () {
                alertify.error('<i class="fa fa-check-warning"></i> Something wrong happened, Retry');
            }
        });
    }





});