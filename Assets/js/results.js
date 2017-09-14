$(function () {
    $('.accordion').accordion({heightStyle: "content"});

    $('form input').blur(function () {
        var type = $(this).attr('type');
            var id = $(this).attr('id');
            submit_form(id);
    });

    $('form select').change(function () {
        var id = $(this).attr('id');
        if (isInt(id)) {
            submit_form(id);
        }
    });

    $('form textarea').blur(function () {
        var id = $(this).attr('id');
        CKEDITOR.instances[id].updateElement();
        submit_form(id);
    });

    $('form .save').click(function () {
        var id = $(this).attr('id');
        submit_form(id);
        location.reload();
    });

    function submit_form(id) {
        //if (isInt(id)) {
        $.ajax({
            type: "POST",
            url: SAVE_URL,
            data: $('#results_form' + id + '').serialize(),
            success: function () {
                alertify.success('<i class="fa fa-check-circle"></i> Results Posted');
            },
            error: function () {
                alertify.error('<i class="fa fa-check-warning"></i> Something went wrong, Retry');
            }
        });
        //  }
    }

    function isInt(value) {
        if (isNaN(value)) {
            return false;
        }
        var x = parseFloat(value);
        return (x | 0) === x;
    }
});

