$(function () {
    $('#payForm input').keyup(function () {
        show_information();
    });
    function sumPayments() {
        function parser(j) {
            return parseInt(j) || 0;
        }
        var cash = parser($('input[name=CashAmount]').val());
        var mpesa = parser($('input[name=MpesaAmount]').val());
        var cheque = parser($('input[name=ChequeAmount]').val());
        var card = parser($('input[name=CardAmount]').val());
        console.log(cash, mpesa, cheque, card);
        return (cash + mpesa + cheque + card);
    }
    $('input').on('ifChanged', function (e) {
        show_information();
    });
    function calculate_cost_array() {
        var total = 0;
        $('#paymentsTable > tbody > tr').each(function () {
            if ($(this).find('input:checkbox').is(':checked')) {
                total += parseInt($(this).find('span').html());
            }
        });
        return total;
    }
    function show_information() {
        var selected_payments = calculate_cost_array();
        var to_pay = sumPayments();
        var needed = selected_payments - to_pay;
        $('#total').html("Total: Ksh " + selected_payments);
        // $('#all').html("Total Payments: <strong>Ksh " + to_pay + "</strong>");
        $('#balance').html('');
        $('#saver').prop('disabled', false);
        if (needed > 0) {
            $('#balance').html("Balance: <strong style='color:red;'>Ksh " + needed + "</strong>");
            $('#saver').prop('disabled', true);
        }
    }
    $('#paymentsTable').find('input:radio, input:checkbox').prop('checked', false);
    $('input[type="checkbox"]').iCheck({
        checkboxClass: 'icheckbox_flat-green',
        radioClass: 'iradio_flat-blue',
        increaseArea: '20%'
    });
    $('#saver').prop('disabled', true);
    $(".accordion").accordion({
        heightStyle: "content"
    });
    $('.datepicker').datepicker({maxDate: 0, changeMonth: true});
});
