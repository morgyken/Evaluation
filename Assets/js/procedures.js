$('#_firm_prices').hide();
//$('#result_type_options').hide();
//$(document).ready(function () {
$('#special_price_check').change(function () {
    if (this.checked)
        $('#_firm_prices').fadeIn('slow');
    else
        $('#_firm_prices').fadeOut('slow');
});

$('#result_type').change(function () {
    toggle_options();
});

$('#result_type').click(function () {
    toggle_options();
});

$(document).ready(function () {
    toggle_options();
});


function toggle_options() {
    var selected = $('#result_type').val();
    if (selected === 'select') {
        $('#result_type_options').fadeIn('slow');
    } else {
        $('#result_type_options').fadeOut('slow');
    }
}
