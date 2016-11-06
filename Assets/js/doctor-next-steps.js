/* global VISIT_METAS_URL */

$(function () {
    //next steps
    $('#next_steps input').click(function () {
        save_metas();
    });
    function save_metas() {
        var result = $('#next_steps_result');
        result.hide();
        $.ajax({
            type: "POST",
            url: VISIT_METAS_URL,
            data: $('#next_steps').serialize(),
            success: function (data) {
                if (data) {
                    result.html('<br/><i class="fa fa-check-circle"></i> Next steps saved');
                    result.show();
                }
            }
        });
    }
});