/*
 * =========================================================================
 * OP NOTES
 * =========================================================================
 */
/* global OPNOTES_URL */

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
        $.ajax({type: "POST", url: OPNOTES_URL, data: $('#opnotes').serialize()});
    }
});