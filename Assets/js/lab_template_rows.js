/*
 * Collabmed Solutions Ltd
 * Project: iClinic
 * Author: Samuel Okoth <sodhiambo@collabmed.com>
 */

/* global SCHEMES_URL, IMAGE_SRC, URL */

$(document).ready(function () {
    function toggle_templates() {
        if ($("#templates").hasClass("hidden")) {
            $("#templates").removeClass("hidden");
        }
    }
    toggle_templates();

    function apply_templates(that) {
        //initialize
        $("#" + id + " .scheme").empty();
        var options = "";
        var id = $(that).parent().parent().parent().parent().attr('id');
        var val = $(that).val();
        if (!val) {
            return;
        }

        $.ajax({
            url: SCHEMES_URL,
            data: {'id': val},
            success: function (data) {
                $.each(data, function (key, value) {
                    options += '<option value="' + key + '">' + value + '</option>';
                });
                $("#" + id + " .scheme").html(options);
            }});
    }
    $(".company").change(function () {
        apply_templates(this);
    });
    //new fields
    var max_fields = 5; //maximum input boxes allowed
    var wrapper = $(".templates"); //Fields wrapper
    var add_button = $(".add_button"); //Add button ID

    var x = 1; //initlal text box count
    var html_template = $('#wrapper1').html();
    $(add_button).click(function (e) { //on add input button click
        e.preventDefault();
        if (x < max_fields) { //max input box allowed
            x++;
            var ids = 'wrapper' + x;
            var title = 'Subtest ' + x;
            $(wrapper).append("<h5>" + title + "</h5><div id='" + ids + "'>" + html_template + "</div>");
            $(".date").datepicker({
                dateFormat: 'yy-mm-dd', changeYear: true, changeMonth: true, defaultDate: '-20y', yearRange: "1900:+0"}
            );
            $(".company").change(function () {
                apply_templates(this);
            });
            $('#wrapper' + x + ' select').select2();
        }

    });
    $(".test_select").select2();
    $("#title_select").select2();

});