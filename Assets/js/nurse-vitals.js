/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/* global VITALS_URL, alertify */

$(function () {

    $('.wh').on('keyup', function () {
        calculateRatio();
    });
    $('.bmi').on('keyup', function () {
        calculateBMI();
    });

    /*
     * Calculate the BMI
     * @returns {undefined}
     */
    function calculateBMI() {
        var weight = $('#weight').val();
        var height = $('#height').val();
        var bmi = 'N/A';
        var status = 'N/A';
        if (height && weight) {
            bmi = (weight / (height * height)).toFixed(4);
            if (bmi > 29.9) {
                status = "Obese"
            } else if (bmi < 30 && bmi > 24.9) {
                status = "Overweight"
            } else if (bmi < 24.8 && bmi > 18.5) {
                status = "Normal"
            } else if (bmi < 18.5) {
                status = "Underweight"
            }
        }
        $('#bmi').html(bmi);
        $('#bmi_status').html(status);
    }

    /**
     * Calculate waist -hip ration
     * @returns {undefined}
     */
    function calculateRatio() {
        var Hip = $('#hip').val();
        var Waist = $('#waist').val();
        var ration = 'N/A';
        if (Hip && Waist) {
            ration = (Waist / Hip).toFixed(4);
        }
        $('#ratio').html(ration);
    }

    $('#vitals_form').submit(function (e) {
        e.preventDefault();
        save_vitals();
    });
    $('#vitals_form').find('input,textarea').change(function () {
        save_vitals();
    });


    function save_vitals() {
        $.ajax({
            type: "POST",
            url: VITALS_URL,
            data: $('#vitals_form').serialize(),
            success: function () {
                alertify.success('<i class="fa fa-check-circle"></i> Vitals saved');
            },
            error: function (xhr, status, errorThrown) {
                alertify.error('<i class="fa fa-check-warning"></i> Something wrong happened, Retry' + errorThrown + ', status ' + status + ', xhr ' + xhr);
            }
        });
    }
});



