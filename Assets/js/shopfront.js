/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


/* global PRODUCTS_URL, SCHEMES_URL, PHONE_URL, STOCK_URL, CREDIT_URL, INSURANCE */

$('table').hide();
$(document).ready(function () {
    var i = 3;
    $("#add_row").click(function () {
        var to_add = "<td><select name=\"item" + i + "\"  id=\"item_" + i + "\" class=\" select2-single\" style=\"width: 100%\"></select></td><td><input type=\"text\" name='qty" + i + "' id='item_qty_" + i + "'  placeholder='Units' value=\"0\" class=\"quantities\"/></td><td><span id=\"original" + i + "\">-</span></td><td><input type=\"text\" name='price" + i + "' placeholder='Price'/></td> <td><span id=\"total" + i + "\">0.00</span></td><td><button class=\"btn btn-xs btn-danger remove\"><i class=\"fa fa-trash-o\"></i></button></td>";
        $('#addr' + i).html(to_add);
        $('#tab_logic').append('<tr id="addr' + (i + 1) + '"></tr>');
        map_select2(i);
        i++;
    });

    function calculate_total() {
        var SUM = 0;
        var DISCOUNT = 0;
        $('#tab_logic tbody tr').each(function (i, row) {
            var rows = $(row);
            var qty = rows.find('input[name=qty' + i + ']').val();
            var price = rows.find('input[name=price' + i + ']').val();
            var total = qty * price;
            // if (discounts) {
            //     DISCOUNT += parseInt(discounts);
            // }
            if (total) {
                SUM += parseInt(total);
                $("#total" + i).html(total.toFixed(2));
            }

        });
        $('#total').html((SUM - DISCOUNT).toFixed(2));
        $('#discount').html(DISCOUNT.toFixed(2));
        $('#net').html((SUM - DISCOUNT).toFixed(2));
        $('#amnt').val((SUM - DISCOUNT).toFixed(2));
        $('#sum').html(SUM.toFixed(2));
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
                "url": PROCEDURES_URL,
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
            var price = selected.data().data.cash_price;
            var in_stock = selected.data().data.available;
            if (INSURANCE) {
                price = selected.data().data.credit_price;
            }
            $('#fb' + i).attr('available', in_stock);
            $('input[name=price' + i + ']').val(price);
            $('#original' + i).html(selected.data().data.o_price);
            calculate_total();
        });


        $('#addr' + i + ' input').keyup(function () {
            calculate_total();
        });
        $(".remove").click(function (e) {
            e.preventDefault();
            $(this).closest('tr').remove();
            calculate_total();
        });
    }

    map_select2(0);
    map_select2(1);
    map_select2(2);
    $('select[name=payment_mode]').click(function () {
        show_form($(this).val());
    });
    $('#phone1, #phone').keyup(function () {
        $.ajax({
            type: "get",
            url: PHONE_URL,
            data: {type: 'phone', key: $(this).val()},
            beforeSend: function () {
                $("#phone").css("background", "#FFF");
            },
            success: function (data) {
                $("#suggesstion-box").show();
                $("#suggesstion-box").html(data);

                $("#suggesstion-box1").show();
                $("#suggesstion-box1").html(data)

                $("#phone").css("background", "#FFF");
            }
        });
    });
    $('#payment_mode').change(function () {
        mode = $(this).val();
        INSURANCE = (mode === 'insurance');
    });

    function show_form(opt) {
        $('#cash, #insurance, #card, #cheque, #mpesa').hide();
        $('#' + opt).show();
        if (opt === "insurance") {
            $('#customer').hide();
        } else {
            $('#customer').show();
        }
    }

    function apply_schemes(that) {
        //initialize
        $("#scheme").empty();
        var options = "";
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
                $("#scheme").html(options);
            }
        });
    }

    $("#company").change(function () {
        apply_schemes(this);
    });
    $('table').show();
    $("#patient_select").select2({
        tags: true,
        theme: "classic",
        ajax: {
            url: PATIENTS_URL,
            dataType: 'json',
            cache: true,
            data: function (term, page) {
                return {
                    term: term
                };
            },
            results: function (data, page) {
                return {results: data};
            }
            , cache: true
        },
        formatNoMatches: function () {
            return "No matches found";
        },
        formatInputTooShort: function (input, min) {
            return "Please enter " + (min - input.length) + " more characters";
        },
        formatInputTooLong: function (input, max) {
            return "Please enter " + (input.length - max) + " less characters";
        },
        formatSelectionTooBig: function (limit) {
            return "You can only select " + limit + " items";
        },
        formatLoadMore: function (pageNumber) {
            return "Loading more results...";
        },
        formatSearching: function () {
            return "Searching...";
        },
        minimumInputLength: 2
    });
});
