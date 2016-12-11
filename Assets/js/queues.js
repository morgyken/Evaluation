/* global SIGN_OUT, FROM, alertify */
$(function () {
    var to_checkout = null;
    $('.checkout').click(function () {
        to_checkout = $(this).val();
        $('#myModal').modal('show');
    });
    $('#checkout').click(function () {
        if (!to_checkout) {
            return;
        }
        id = to_checkout;
        $.ajax({
            type: 'GET',
            url: SIGN_OUT,
            data: {'id': id, 'from': FROM},
            success: function () {
                $("#row_id" + id).remove();
                alertify.success('Patient is now checked out');
            },
            error: function (data) {
                alertify.error('Aw. Could not checkout patient');
            }
        });
        $("#myModal").modal('hide');
    });
    $('table').DataTable();
});