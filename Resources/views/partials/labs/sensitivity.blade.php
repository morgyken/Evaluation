<?php
/**
 * Created by PhpStorm.
 * User: bravoh
 * Date: 9/4/17
 * Time: 5:35 PM
 */
?>
<table class="sensitivity table  table-striped" id="sense_logic">
    <thead>
    <tr>
        <td colspan="4">
            {{$s_item->name}}
            {{--<input type="hidden" name="item{{$s_item->id}}" value="{{$s_item->id}}" />--}}
        </td>
    </tr>
    <tr>
        <th>Isolate</th>
        <th class="text-center" style="width: 10%;">Interpretation</th>
        <th></th>
    </tr>
    </thead>
    <tbody>
    <tr id='row0'>
        <td>
            <select id="{{$item->id}}" name="isolate{{$item->id}}[]" class="isolate" style="width: 100%"></select>
        </td>
        <td>
            <select id="{{$item->id}}" class="interp" name="interpretation{{$item->id}}[]" >
                <option value='sensitive'>Sensitive</option>
                <option value='resistant'>Resistant</option>
                <option value='susceptible'>Susceptible</option>
                <option value='susceptible dose'>Susceptible Dose</option>
                <option value='intermediate'>Intermediate</option>
            </select>
        </td>
        <td>
            <button id="{{$item->id}}" style="float: right" class="btn btn-xs btn-danger remove">
                <i class="fa fa-trash-o"></i>
            </button>
        </td>
    </tr>
    </tbody>
    <tfoot>
    <tr>
        <td>
            <a  class="add_row btn btn-primary btn-xs pull-left">
                <i class="fa fa-plus"></i>
                Add
            </a>
        </td>
    </tr>
    </tfoot>
</table>
<script type="text/javascript">
    var PRODUCTS_URL = "{{route('api.inventory.get_products')}}";
</script>
<script>
    $(document).ready(function () {
    var i = 1;
    $('body').on('click','.add_row',function (e) {
        e.stopImmediatePropagation();
        var to_add = "<tr id=\"row"+i+"\"  >" +
            "<td><select name=\"isolate{{$item->id}}[]\" id=\"{{$item->id}}\" class=\"isolate\" style=\"width: 100%\"></select></td>" +
            "<td>" +
            "<select id=\"{{$item->id}}\" class='interp' name=\"interpretation{{$item->id}}[]\" >"+
                "<option value=\"sensitive\">Sensitive</option>" +
                "<option value='resistant'>Resistant</option>" +
                "<option value='susceptible'>Susceptible</option>" +
                "<option value='susceptible dose'>Susceptible Dose</option>" +
                "<option value='intermediate'>Intermediate</option>" +
            "</select>" +
            "</td>" +
            "<td><button id=\"{{$item->id}}\" style='float: right' class=\"btn btn-xs btn-danger remove\"><i class=\"fa fa-trash-o\"></i></button></td></tr>";
        $(this).parents('table').find('tbody').append(to_add);
        map_select2(i);
        i++;
    });
    function map_select2(i) {
        $('#row' + i + ' .isolate').select2({
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

        $(".interp").change(function (e) {
            var form_id = $(this).attr("id");
            save_form(form_id);
        });

        $(".interp").click(function (e) {
            var form_id = $(this).attr("id");
            save_form(form_id);
        });

    }
    map_select2(0);    function
        save_form(id) {
            $.ajax({
                type: "POST",
                url: SAVE_URL,
                data: $('#results_form' + id + '').serialize(),
                success: function () {
                    alertify.success('<i class="fa fa-check-circle"></i> Results Posted');
                },
                error: function () {
                    alertify.error('<i class="fa fa-check-warning"></i> Something went wrong, Retry');
                }
            });
        }

    });
</script>

{{--<script src="{!! m_asset('evaluation:js/sensitivity.js') !!}"></script>--}}