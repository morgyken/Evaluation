/* global SET_DATE_URL */

$(function () {
    /*
     * =========================================================================
     * Visit date
     * =========================================================================
     */
    $('#visit_date').datepicker({"dateFormat": 'yy-mm-dd', "minDate": '-100y', onSelect: function () {
            set_visit_date();
        }, "constrainInput": false});
    $("#visit_date_form").submit(function (e) {
        e.preventDefault();
        set_visit_date();
    });
    function set_visit_date() {
        $.ajax({type: "POST", url: SET_DATE_URL, data: $('#visit_date_form').serialize(), success: function () {
                $('#visitdate').html("<i class='fa fa-check-circle'></i> Visit date set");
            }
        });
    }
});