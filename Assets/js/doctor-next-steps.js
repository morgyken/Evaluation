/* global VISIT_METAS_URL, alertify */

$(function () {
    //next steps
    $('#next_steps input').click(function () {
        save_metas();
    });
    function save_metas() {
        $.ajax({
            type: "POST",
            url: VISIT_METAS_URL,
            data: $('#next_steps').serialize(),
            success: function () {
                alertify.success('<i class="fa fa-check-circle"></i> Next steps saved');
            },
            error: function () {
                alertify.error('<i class="fa fa-check-warning"></i> Something wrong happened, Retry');
            }
        });
    }
});