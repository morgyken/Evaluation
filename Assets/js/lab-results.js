/* global SAVE_URL, alertify */
$(function () {
    $('.accordion').accordion({heightStyle: "content"});

    $('#results_form').submit(function (e) {
        e.preventDefault();
        save_results();
    });

    $('#results_form input').blur(function () {
        save_results();
    });

    $('#results_form textarea').blur(function () {
        save_results();
    });

    function save_results() {
        $.ajax({
            url: SAVE_URL,
            type: 'post',
            //dataType: "JSON",
            data: new FormData(this),
            processData: false,
            contentType: false,
            success: function (data, status) {
                alertify.success('<i class="fa fa-check"></i> Result posted');
                location.reload();
            },
            error: function (xhr, desc, err) {
                alertify.error('<i class="fa fa-warning"></i> ' + err);
            }
        });
    }

});