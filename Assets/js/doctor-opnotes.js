/*
 * =========================================================================
 * OP NOTES
 * =========================================================================
 */
/* global OPNOTES_URL, alertify */

$(function () {
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
        $.ajax({
            type: "POST",
            url: OPNOTES_URL,
            data: $('#opnotes').serialize(),
            success: function () {
                alertify.success('<i class="fa fa-check-circle"></i> Your OP notes saved');
            },
            error: function () {
                alertify.error('<i class="fa fa-check-warning"></i> Something wrong happened, Retry');
            }});
    }
});