$(function () {
    var costArray = 0;
    var SUM = 0;
    $('#payForm input').keyup(function () {
        sumPayments();
    });
    function sumPayments() {
        function parser(j) {
            return parseInt(j) || 0;
        }
        var insurance = parser($('input[name=InsuranceAmount]').val());
        var cash = parser($('input[name=CashAmount]').val());
        var mpesa = parser($('input[name=MpesaAmount]').val());
        var cheque = parser($('input[name=ChequeAmount]').val());
        var card = parser($('input[name=CardAmount]').val());
        SUM = insurance + cash + mpesa + cheque + card;
        $('#all').html("Total: <strong>Ksh " + SUM + "</strong>");
    }
    $('#accordion').accordion({heightStyle: "content"});
    $('#payForm').submit(function (e) {
        e.preventDefault();
        if (SUM === 0) {
            alert('Please enter payment amount details');
            return;
        }
        if (SUM !== costArray) {
            alert('Payment does not match the cost for tselected procedures');
            return;
        }
        $('#payForm').unbind().submit();
    });
    $('input').on('ifClicked', function (e) {
        var total = 0;
        $('#paymentsTable > tbody > tr').each(function () {
            if ($(this).find('input:checkbox').is(':checked')) {
                total += parseInt($(this).find('span').html());
                console.log(total);
            }
        });
        $('#total').html("Total: <strrong>Ksh " + total + "</strong>");
    });
    $('#total').html("Total: <strrong>Ksh " + costArray + "</strong>");
    $('#all').html("Total: <strrong>Ksh " + SUM + "</strong>");
    $('#paymentsTable').find('input:radio, input:checkbox').prop('checked', false);
    $('input[type="checkbox"]').iCheck({
        checkboxClass: 'icheckbox_flat-green',
        radioClass: 'iradio_flat-blue',
        increaseArea: '20%'
    });
    $(".accordion").accordion({
        heightStyle: "content"
    });

});
