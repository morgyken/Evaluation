/*
 * Collabmed Solutions Ltd
 * Project: iClinic
 *  Author: Samuel Okoth <sodhiambo@collabmed.com>
 */

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
    $('#notes_form input').blur(function () {
        save_notes();
    });
    $('#notes_form textarea').blur(function () {
        save_notes();
    });
    function save_notes() {
        $.ajax({type: "POST", url: NOTES_URL, data: $('#notes_form').serialize()});
    }





});