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
        var to_add = "\<td><select name=\"item" + i + "\" id=\"item_" + i + "\" class=\"select2-single\" style=\"width: 100%\"></select></td>\n\<td><input type=\"text\" id=\"price_" + i + "\" name=\"price" + i + "\" readonly=''/></td>\n\
<td><input value=\"1\" type=\"text\" id=\"quantity_" + i + "\" name=\"quantity" + i + "\" placeholder=\"No. Performed\"/></td>\n\
<td><input value='0' type='text' id='discount_" + i + "' name='discount" + i + "' placeholder='Discount'/></td>\n\
<td><input type='text' id='amount_" + i + "' name='amount" + i + "' placeholder='Amount' readonly=''/></td>\n\
<td><button class=\"btn btn-xs btn-danger remove\"><i class=\"fa fa-trash-o\"></i></button></td>";
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
            var discount = $("#discount_" + i).val();
            var quantity = $("#quantity_" + i).val();
            var amount = get_amount_given(price, quantity, discount);
            $('input[name=price' + i + ']').val(price);
            $('input[name=amount' + i + ']').val(amount);
            add_row();
        });

        var discount_flag = $("#no_discount").val();
        if (discount_flag == 1) {
            $("#discount_" + i).attr('readonly', true);
            $("#discount_" + i).css('background-color', '#DEDEDE');
        }

        $(".remove").click(function (e) {
            e.preventDefault();
            $(this).closest('tr').remove();
        });

        $("#discount_" + i).keyup(function (e) {
            e.preventDefault();
            culculator(i);
        });

        $("#quantity_" + i).keyup(function (e) {
            e.preventDefault();
            culculator(i);
        });
    }

    function culculator(i) {
        var prc = $("#price_" + i).val();
        var dis = $("#discount_" + i).val();
        var qty = $("#quantity_" + i).val();
        var amnt = get_amount_given(prc, qty, dis);
        $('input[name=amount' + i + ']').val(amnt);
    }

    function get_amount_given(price, qty, discount) {
        try {
            var total = price * qty;
            var d = total * (discount / 100);
            var discounted = total - d;
            return discounted;
        } catch (e) {
            return price;
        }
    }
});