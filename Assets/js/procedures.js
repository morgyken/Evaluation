$('#_firm_prices').hide();
$('#result_type_options').hide();
//$(document).ready(function () {
$('#special_price_check').change(function () {
    if (this.checked)
        $('#_firm_prices').fadeIn('slow');
    else
        $('#_firm_prices').fadeOut('slow');
});


$('#result_type').change(function () {
    var selected = this.value;
    if (selected === 'select') {
        $('#result_type_options').fadeIn('slow');
    } else {
        $('#result_type_options').fadeOut('slow');
    }
});
//});