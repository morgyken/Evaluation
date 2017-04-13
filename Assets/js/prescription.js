/* global PRODUCTS_URL, SCHEMES_URL, PHONE_URL, STOCK_URL, CREDIT_URL, INSURANCE */

$('table').hide();
$('#card, #cheque, #mpesa').hide();
$(document).ready(function () {
    var i = 3;
    $("#add_row").click(function () {
        var to_add = "<td><select name=\"item" + i + "\"  id=\"item_" + i + "\" class=\" select2-single\" style=\"width: 100%\"></select></td><td><input type=\"text\" name='qty" + i + "' id='item_qty_" + i + "'  placeholder='Quantity' value=\"0\" class=\"quantities\"/><input type='hidden' name='batch" + i + "'><span id='fb" + i + "'></span></td><td><span id=\"original" + i + "\">0</span></td><td><input type=\"text\" name='price" + i + "' placeholder='Price'/></td> <td><input type=\"text\" name='dis" + i + "' placeholder='Discount' value=\"0\"/></td></td><td><span id=\"total" + i + "\">0.00</span></td><td><button class=\"btn btn-xs btn-danger remove\"><i class=\"fa fa-trash-o\"></i></button></td>";
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
            var dis = rows.find('input[name=dis' + i + ']').val();
            var total = qty * price;
            var discounts = 0;
            try {
                discounts = (qty * dis * price) / 100;
            } catch (e) {
                discounts = 0;
            }
            if (discounts) {
                DISCOUNT += parseInt(discounts);
            }
            if (total) {
                SUM += parseInt(total);
                $("#total" + i).html(total - parseInt(discounts));
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
            var price = selected.data().data.cash_price;
            var in_stock = selected.data().data.available;
            var batch = selected.data().data.batch;
            if (INSURANCE) {
                price = selected.data().data.credit_price;
            }

            $('#fb' + i).attr('available', in_stock);
            $('input[name=price' + i + ']').val(price);
            $('input[name=batch' + i + ']').val(batch);
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
                $("#suggesstion-box1").html(data);
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
            }});
    }
    $("#company").change(function () {
        apply_schemes(this);
    });
    $('body').on('keyup', '.quantities', function () {
        var selected = $(this).closest('tr').find('select').find('option:selected');
        var product = selected.data().data.id;
        var item_id = $(this).attr('id');
        var row_id = item_id.substring(item_id.lastIndexOf('_') + 1);
        try {
            var available = parseInt($('#fb' + row_id).attr('available'));
        } catch (e) {
            available = 0;
        }
        if (available > 0) {
            if ($(this).val() > available) {
                message = "<i class='fa fa-times' style='color:red'></i> Only " + available + " available. <a target='blank' href='/inventory/store/products/adjust/" + product + "'> adjust?</a>";
            } else {
                message = "<i class='fa fa-check' style='color:green'></i> " + available + " avaialable";
            }
        } else {
            message = "<i class='fa fa-times' style='color:red'></i> Out of stock! <a target='blank' href='/inventory/store/products/adjust/" + product + "'> adjust?</a>";
        }
        $("#fb" + row_id).html(message);
    });
    /*
     function creditRate(i) {
     var item = $('#item_' + i).val();
     var mode = $('.payment').val();
     if (mode === 'insurance') {
     $.ajax({
     type: "get",
     url: CREDIT_URL,
     data: {item: item},
     success: function (data) {
     $("input[name=price" + i + "]").val(data);
     }
     });
     }
     }*/
    $('table').show();
});

function setValue(phone, email, first_name, last_name) {
    $("#email").val(email);
    $("#phone").val(phone);
    $("#phone1").val(phone);
    $("#fname").val(first_name);
    $("#lname").val(last_name);
    $("#suggesstion-box").hide();


    $("#email1").val(email);
    $("#phone1").val(phone);
    $("#phone1").val(phone);
    $("#fname1").val(first_name);
    $("#lname1").val(last_name);
    $("#suggesstion-box1").hide();
}


function bill(id) {
    if ($('#check' + id).is(':checked')) {
        var price = $('#prc' + id).val();
        var qty = $('.qty' + id).val();
        var dis = $('#discount' + id).val();
        var sub_total = (qty * price) - ((dis / 100) * (qty * price));
        var t = parseInt($('.total_bill').val());
        t += sub_total;

        $('.sub_total' + id).val(sub_total);
        $('.total_bill').val(t);
        $("input#sum1").val(t.toFixed(2));
        $('.sub_total_text' + id).html('<b>Amount:</b> ' + sub_total);
    } else {
        unBill(id);
    }
}

function unBill(id) {
    var price = $('#prc' + id).val();
    var qty = $('.qty' + id).val();
    var sub_total = qty * price;
    var t = parseInt($('.total_bill').val());
    if (t > 0) {
        t -= sub_total;
    } else {
        t = 0;
    }
    $('.sub_total' + id).val(sub_total);
    $('.total_bill').val(t);
    $('.sub_total_text' + id).html('<b>Amount:</b> ' + sub_total);
}

function cancelPrescription(key) {
    $.ajax({
        type: "get",
        url: prescUR,
        data: {id: key},
        success: function (data) {
            $("#" + key + "row").fadeOut();
            $("#feedback-box").html(data);
        }
    });
}

