/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$(function () {
    /*
     * =========================================================================
     * eye preview
     * =========================================================================
     */
    /* global PRELIMINARY_EXAMINATION, USER_ID, VISIT_ID */

    $('#eye_preview_form input').blur(function (e) {
        save_eye_preview();
    });
    $('#eye_preview_form').submit(function (e) {
        e.preventDefault();
        save_eye_preview();
    });
    function save_eye_preview() {
        $.ajax({
            type: "POST",
            url: PRELIMINARY_EXAMINATION,
            data: $('#eye_preview_form').serialize(),
            success: function () {
                alertify.success('<i class="fa fa-check-circle"></i> Eye preliminary information saved');
            },
            error: function () {
                alertify.error('<i class="fa fa-check-warning"></i> Something wrong happened, Retry');
            }
        });
    }
}
);