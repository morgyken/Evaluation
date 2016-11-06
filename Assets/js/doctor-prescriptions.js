/* global PRESCRIPTION_URL */

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
        var drug = $('#prescription input[name=drug]').val();
        var duration = $('#prescription input[name=duration]').val();
        var dose = $('#prescription input[name=take]').val();
        $('#prescribed > tbody').append('<tr><td>' + drug + '</td><td>' + dose + '</td><td>' + duration + '</td></tr>');
        $.ajax({type: "POST", url: PRESCRIPTION_URL, data: $('#prescription').serialize()});
        $("#prescription").find("input[type=text]").val("");
    }
});