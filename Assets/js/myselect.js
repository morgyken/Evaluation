/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
/* global PROCEDURE_URL */

$(function () {
    $('#evaluation_order .check').click(function () {
        var elements = $(this).parent().parent().find('input');
        var texts = $(this).parent().parent().find('textarea');
        if ($(this).is(':checked')) {
            elements.prop('disabled', false);
            texts.prop('disabled', false);
            $(texts).parent().show();
        } else {
            elements.prop('disabled', true);
            texts.prop('disabled', true);
            $(texts).parent().hide();
        }
        $(this).prop('disabled', false);
    });
    var i = 0;
    map_select2(i);
    i++;
    function add_row() {
        var to_add = "<td><select name=\"item" + i + "\" id=\"item_" + i + "\" class=\"select2-single\" style=\"width: 100%\"></select></td><td><input type=\"text\" id=\"price_" + i + "\" name=\"price" + i + "\"/></td><td><button class=\"btn btn-xs btn-danger remove\"><i class=\"fa fa-trash-o\"></i></button></td>";
        $('#addr' + i).html(to_add);
        $('#evaluation_order tbody').append('<tr id="addr' + (i + 1) + '"></tr>');
        map_select2(i);
        i++;
    }
    function map_select2(i) {
        $('#addr' + i + ' select').select2({
            "theme": "classic",
            "placeholder": 'Please select a procedure',
            "formatNoMatches": function () {
                return "No matching procedure found";
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
                "url": PROCEDURE_URL,
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
        $('#addr' + i + ' select').on('select2:select', function (evt) {
            var selected = $(this).find('option:selected');
            var price = selected.data().data.price;
            $('input[name=price' + i + ']').val(price);
            add_row();
        });
        $(".remove").click(function (e) {
            e.preventDefault();
            $(this).closest('tr').remove();
        });

    }
});