<?php
/*
 * Collabmed Solutions Ltd
 * Project: iClinic
 *  Author: Samuel Okoth <sodhiambo@collabmed.com>
 */
$payment = $info;
$patient = Collabmed\Model\Reception\Patients::find($payment->patient);
$pays = paymentFor($payment->description);
?>
<style>
    #items {
        font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
        border-collapse: collapse;
        width: 100%;
    }

    #items td, #items th {
        border: 1px solid #ddd;
        text-align: left;
        padding: 8px;
    }

    #items tr:nth-child(even){background-color: #f2f2f2}

    #items tr:hover {background-color: #ddd;}

    #items th {
        padding-top: 5px;
        padding-bottom: 5px;
        background-color: /*#4CAF50*/ #BBBBBB;
        color: white;
    }
</style>
<div class="box box-info">
    <center><img width="80px" height="100px" src="{{realpath(base_path('/public/img/image.jpg'))}}"/></center>
    <div class="box-header with-border">
        <center><h3 class="box-title">{{config('practice.name')}}</h3></center>
        <h5><center>{{get_clinic_name(config('practice.clinic'))}} Clinic</center></h5>
        <h6><center>P.O BOX {{config('practice.address')}}, {{config('practice.town')}}</center></h6>
    </div>
    <div class="box-body">
        <div class="col-md-12">
            <strong>Name:</strong><span class="content"> {{$patient->full_name}}</span><br/>
            <strong>Date:</strong><span class="content"> {{(new Date($payment->created_at))->format('j/m/Y H:i')}}</span><br/>
            <strong>Receipt No: </strong><span>{{$payment->receipt}}</span><br/><br/>
        </div>
        <div class="col-md-6">
            @if(!$pays->isEmpty())
            <table class="table table-striped" id="items">
                <thead>
                    <tr>
                        <th>Item</th>
                        <th>Units</th>
                        <th>Cost (Ksh.)</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pays as $pay)
                    <tr>
                        <td>{{$pay->procedures->name}}</td>
                        <td>{{$pay->no_performed}}</td>
                        <td>{{$pay->price}}</td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th>Total</th>
                        <th></th>
                        <th>{{$pays->sum('net')}}</th>
                    </tr>
                </tfoot>
            </table>
            @endif
        </div>
        <div class="col-md-6">
            <h4>Payment Details</h4>
            @if(!empty($payment->CashAmount))
            Cash Payment: Ksh. {{$payment->CashAmount}}
            <br/>
            @endif
            @if(!empty($payment->MpesaAmount))
            MPESA:  {{$payment->MpesaAmount}}
            <br/>
            @endif
            @if(!empty($payment->ChequeAmount))
            Cheque: {{$payment->ChequeAmount}}
            <br/>
            @endif
            @if(!empty($payment->CardAmount))
            Card: {{$payment->CardAmount}}
            <br/>
            @endif
            <strong>Total Paid: {{$payment->total}}</strong>
        </div>
    </div>
    <hr/>
    <strong>Signature:</strong><u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u>

    <br/><br/>
    Payment Confirmed by: <u>{{Auth::user()->profile->full_name}}</u>
</div>