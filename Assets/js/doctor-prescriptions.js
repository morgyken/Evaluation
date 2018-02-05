/* global PRESCRIPTION_URL, alertify */

$(function () {
    $('#prescriptionLoader').hide();
    /*
     * =========================================================================
     * Prescriptions management
     * =========================================================================
     * */
    var $prescriptionForm = $('#prescription_form');
    $prescriptionForm.submit(function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();
        save_prescription();
    });
    var ITEMS_IN_STORE = 0;
    $prescriptionForm.find('select').on('select2:select', function (evt) {
        var selected = $(this).find('option:selected');
        ITEMS_IN_STORE = selected.data().data.available;
    });

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
                        term: term,
                        clinic: $("#clinic").val()
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
        var $btn = $('button#savePrescription');
        $.ajax({
            type: "POST",
            url: PRESCRIPTION_URL,
            data: $prescriptionForm.serialize(),
            beforeSend: function () {
                $btn.hide();
                $('#prescriptionLoader').show();
            },
            success: function () {
                $('#prescriptionLoader').hide();
                $('table#prescribed_drugs').dataTable().api().ajax.reload();
                $prescriptionForm.trigger("reset");
                alertify.success("Prescription saved");
                $(".drug-select").select2("data", null);
                $btn.show();
            },
            error: function () {
                alertify.error('<i class="fa fa-check-warning"></i> An error occured prescribing drug');
                $('#prescriptionLoader').hide();
                $btn.show();
            }
        });
    }

    function getFrequency() {
        var v = $prescriptionForm.find('[name=method]').val();
        switch (v) {
            case '1':
                return 2;
            case '2':
                return 3;
            case '3':
                return 4;
            case '4':
            case '5':
                return 1;
            default:
                return 0;
        }
    }

    function getDuration() {
        var duration = $prescriptionForm.find('[name=duration]').val();
        var measure = $prescriptionForm.find('[name=time_measure]').val();
        switch (measure) {
            case '1':
                $v = 1;
                break;
            case '2':
                $v = 7;
                break;
            case '3':
                $v = 30;
                break;
            case '4':
                $v = 365;
                break;
            default:
                $v = 0;
                break;
        }
        return parseInt(duration) * $v;
    }

    function get_the_units() {
        var dose = $prescriptionForm.find('[name=take]').val();
        var frequency = getFrequency();
        var duration = getDuration();
        var mine = parseInt(dose) * duration * frequency;
        if (mine) {
            $prescriptionForm.find('[name=quantity]').val(mine).trigger('change');
        }
    }

    $prescriptionForm.find('[name=quantity]').change(function () {
        $('#marker,#savePrescription').prop('disabled', false);
        if (ITEMS_IN_STORE < parseInt(this.value)) {
            alertify.log("Only " + ITEMS_IN_STORE + " units remaining, cannot prescribe " + this.value);
            $('#marker,#savePrescription').prop('disabled', true);
        }
    });

    $prescriptionForm.find('[name=method],[name=time_measure]').change(function () {
        get_the_units();
    });
    $prescriptionForm.find('[name=take],[name=duration]').keyup(function () {
        get_the_units();
    });

    // OTHERS
    var $theForm = $('#myModal');
    $theForm.find('[name=method],[name=time_measure]').change(function () {
        get_the_units2();
    });
    $theForm.find('[name=take],[name=duration]').keyup(function () {
        get_the_units2();
    });

    function getFrequency2() {
        var v = $theForm.find('[name=method]').val();
        switch (v) {
            case '1':
                return 2;
            case '2':
                return 3;
            case '3':
                return 4;
            case '4':
            case '5':
                return 1;
            default:
                return 0;
        }
    }

    function getDuration2() {
        var duration = $theForm.find('[name=duration]').val();
        var measure = $theForm.find('[name=time_measure]').val();
        switch (measure) {
            case '1':
                $v = 1;
                break;
            case '2':
                $v = 7;
                break;
            case '3':
                $v = 30;
                break;
            case '4':
                $v = 365;
                break;
            default:
                $v = 0;
                break;
        }
        return parseInt(duration) * $v;
    }

    function get_the_units2() {
        var dose = $theForm.find('[name=take]').val();
        var frequency = getFrequency2();
        var duration = getDuration2();
        var mine = parseInt(dose) * duration * frequency;
        if (mine) {
            $theForm.find('[name=quantity]').val(mine);
        }
    }
});