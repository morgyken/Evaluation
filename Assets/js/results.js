/* global SAVE_URL, alertify */
$(function () {
    $('.accordion').accordion({heightStyle: "content"});

    $('form').on('submit', function (e) {
        var id = $(this).attr('id');
        if (id == 'results_form') {
            e.preventDefault();
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
});