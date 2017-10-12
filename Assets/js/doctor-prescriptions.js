/* global PRESCRIPTION_URL, alertify */

$(function () {
    /*
     * =========================================================================
     * Prescriptions management
     * =========================================================================
     * */
    $('#prescription_form').submit(function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();
        save_prescription();
    });

    function auto_calculate() {

    }

    function map_select2(i) {
        //$('#addr' + i + ' select').select2({
        $('#item_' + i).select2({
            "theme": "classic",
            "placeholder": 'Please select an item',
            "formatNoMatches": function () {
                return "No matches found";
            },
            "formatInputTooShort": function (input, min) {
                return "Please enter " + (min - input.length) + " more characters";
            },
            "formatInputTooLong": function (input, max) {
                return "Please enter " + (input.length - max) + " less characters";
            },
            "formatSelectionTooBig": function (limit) {
                return "You can only select " + limit + " items";
            },
            "formatLoadMore": function (pageNumber) {
                return "Loading more results...";
            },
            "formatSearching": function () {
                return "Searching...";
            },
            "minimumInputLength": 2,
            "allowClear": true,
            "ajax": {
                "url": PRODUCTS_URL,
                "dataType": "json",
                "cache": true,
                "data": function (term, page) {
                    return {
                        term: term
                    };
                },
                "results": function (data, page) {
                    return {results: data};
                }
            }
        });
    }

    map_select2(0);

    function save_prescription() {
        $.ajax({
            type: "POST",
            url: PRESCRIPTION_URL,
            data: $('#prescription_form').serialize(),
            success: function () {
                $('table#prescribed_drugs').dataTable().api().ajax.reload();
                $('#prescription_form').trigger("reset");
            },
            error: function () {
                alertify.error('<i class="fa fa-check-warning"></i> An error occured prescribing drug');
            }
        });
    }
});