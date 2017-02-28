<?php
/*
 * Collabmed Solutions Ltd
 * Project: iClinic
 *  Author: Samuel Okoth <sodhiambo@collabmed.com>
 */
$prescriptions = $data['prescription'];
$patient = $data['visit']->patients;
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
        padding: 1px;
    }

    #items tr:nth-child(even){background-color: #f2f2f2}

    #items tr:hover {background-color: #ddd;}

    #items th {
        padding-top: 1px;
        padding-bottom: 1px;
        background-color: /*#4CAF50*/ #BBBBBB;
        color: white;
    }
    .left{
        width: 60%;
        float: left;
    }
    .right{
        float: left;
        width: 40%;
    }
    .clear{
        clear: both;
    }
    img{
        width:50%;
        height: 50%/*auto*/;
        float: right;
    }
    td{
        font-size: 70%;
    }
    div #footer{
        font-size: 70%;
    }
    th{
        font-size: 80%;
    }
</style>
<div class="box box-info">
    <img src="{{realpath(base_path('/public/logo.jpg'))}}"/>
    <div class="left">

        <p>
            <strong>{{config('practice.name')}}</strong><br/>
            {{config('practice.building')}},
            {{config('practice.street')?config('practice.street').',':''}}<br/>
            {{config('practice.town')}}<br>
            {{config('practice.telephone')?'Call Us:- '.config('practice.telephone'):''}}<br/>
            {{config('practice.email')?'Email:- '.config('practice.email'):''}}
        </p>
        <strong>Name:</strong><span class="content"> {{$patient->full_name}}</span><br/>
        <strong>Date:</strong><span class="content"> {{(new Date())->format('j/m/Y H:i')}}</span><br/>
    </div>
    <div class="clear"></div>
    <div class="content">
        <div id="content">
            <div class="box-body">
                <table id="items" class="table table-borderless">
                    <thead>
                        <tr>
                            <th>Drug</th>
                            <th>Dose</th>
                            <th>Duration</th>
                            <th>Substitution</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($prescriptions as $prescription)
                        <tr>
                            <td>{{$prescription->drugs->name}}</td>
                            <td>{{$prescription->dose}}</td>
                            <td>{{$prescription->duration}}</td>
                            <td>{{$prescription->sub}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <br/>
            </div>
        </div>
    </div>
    <div id="footer">
        <p>
            <strong>{{config('practice.name')}}</strong><br/>
            {{config('practice.building')}},
            {{config('practice.street')?config('practice.street').',':''}}<br/>
            {{config('practice.town')}}<br>
            {{config('practice.telephone')?'Call Us:- '.config('practice.telephone'):''}}<br/>
            {{config('practice.email')?'Email:- '.config('practice.email'):''}}
        </p>
    </div>

</div>