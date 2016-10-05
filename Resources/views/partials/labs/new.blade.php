<?php
/*
 * =============================================================================
 *
 * Collabmed Solutions Ltd
 * Project: Collabmed Health Platform
 * Author: Samuel Okoth <sodhiambo@collabmed.com>
 *
 * =============================================================================
 */
?>
{!! Form::open(['route'=>['evaluation.order','labs']])!!}
<table class="table table-condensed" id="evaluation_order">
    <thead>
        <tr>
            <th width="60%">Lab Test</th>
            <th>Price</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <tr id='addr0'>
            <td><select name="item0" id="item_0" class="select2-single" style="width: 100%" ></select></td>
            <td><input type="text" id="item_price_0" name='price0' placeholder='Price'/></td>
            <td>
                <button class="btn btn-xs btn-danger remove"><i class="fa fa-trash-o"></i></button>
            </td>
        </tr>
        <tr id='addr1'>
            <td><select name="item1"   id="item_1" class=" select2-single" style="width: 100%"></select></td>
            <td><input type="text" name='price1' placeholder='Price'/></td>
            <td>
                <button class="btn btn-xs btn-danger remove"><i class="fa fa-trash-o"></i></button>
            </td>
        </tr>
        <tr id='addr2'></tr>
    </tbody>
</table>
{!! Form::close()!!}
<script>
    var PROCEDURE_URL = "{{route('api.evaluation.get_procedures','laboratory')}}";
    $(document).ready(function () {
        map_select2(0);
        map_select2(1);
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
                var price = selected.data().data.cash_price;
                var in_stock = selected.data().data.available;

                $('#fb' + i).attr('available', in_stock);
                $('input[name=price' + i + ']').val(price);
                $('#original' + i).html(selected.data().data.o_price);
            });


            $('#addr' + i + ' input').keyup(function () {
            });
            $(".remove").click(function (e) {
                e.preventDefault();
                $(this).closest('tr').remove();
            });
        }
    });
</script>
<script src="{{m_asset('evaluation:js/myselect.min.js')}}"></script>