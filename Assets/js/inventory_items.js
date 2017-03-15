/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


/* global PRODUCTS_URL */

//$('table').hide();
$(document).ready(function () {
    $('#data').DataTable();

    $("#has_items").click(function () {
        show_items();
    });

    $("#labs").hide();

    $("#category").change(function () {
        var selected = parseInt(this.value);
        if (selected === 4) {
            $("#labs").show();
        } else {
            $("#labs").hide();
        }
    });


    function show_items() {
        var status = $("#has_items").is(':checked');
        if (status)
            $("#items").removeClass('hidden');
        else
            $("#items").addClass('hidden');
    }
    show_items();


    $('select[name=supplier]').select2({theme: "bootstrap"});
    $('.date').datepicker({minDate: "0"});
    var i = 1;
    $("#add_row").click(function () {
        var to_add = "<td><select name=\"item" + i + "\" class=\" select2-single\" style=\"width: 100%\"></select></td><td><input type=\"text\" name='qty" + i + "' placeholder='Quantity' value=\"1\"/></td><td><button class=\"btn btn-xs btn-danger remove\"><i class=\"fa fa-trash-o\"></i></button></td>";
        $('#addr' + i).html(to_add);
        $('#tab_logic').append('<tr id="addr' + (i + 1) + '"></tr>');
        map_select2(i);
        i++;
    });

    function map_select2(i) {
        $('#addr' + i + ' select').select2({
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
        $('#addr' + i + ' select').on('select2:select', function (evt) {
            var selected = $(this).find('option:selected');
            var price = selected.data().data.prices.price;
            $('input[name=price' + i + ']').val(price);
            calculate_total();
        });
        $('#addr' + i + ' input').keyup(function () {
            calculate_total();
        });
        $(".remove").click(function (e) {
            e.preventDefault();
            $(this).closest('tr').remove();
        });
    }
    map_select2(0);
    //$('table').show();
});