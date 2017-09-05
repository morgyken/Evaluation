/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


/* global PRODUCTS_URL */

//$('table').hide();
$(document).ready(function () {

    var i = 1;
    $("#add_row").click(function () {
        var to_add = "" +
            "<td><select name=\"drug" + i + "\" class=\"select2-single\" style=\"width: 100%\"></select></td>" +
            "<td><input style='margin-left: 40%' type=\"checkbox\" class=\"radio\" name='rs"+i+"' value='reactive'/></td>" +
            "<td><input style='margin-left: 40%' type=\"checkbox\" class=\"radio\" name='rs"+i+"' value='sensitive'/></td>" +
            "<td><button style='float: right' class=\"btn btn-xs btn-danger remove\"><i class=\"fa fa-trash-o\"></i></button></td>";
        $('#row' + i).html(to_add);
        $('#sense_logic').append('<tr id="row' + (i + 1) + '"></tr>');
        map_select2(i);
        i++;
    });

    function map_select2(i) {
        $('#row' + i + ' select').select2({
            "theme": "classic",
            "placeholder": 'Please select an drug',
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

        $(".remove").click(function (e) {
            e.preventDefault();
            $(this).closest('tr').remove();
        });

        $("input:checkbox").on('click', function() {
            var $box = $(this);
            if ($box.is(":checked")) {
                var group = "input:checkbox[name='" + $box.attr("name") + "']";
                $(group).prop("checked", false);
                $box.prop("checked", true);
            } else {
                $box.prop("checked", false);
            }
        });
    }
    map_select2(0);
    //$('table').show();
});