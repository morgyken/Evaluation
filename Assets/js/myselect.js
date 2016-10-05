/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
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

