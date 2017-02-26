<?php
/*
 * Collabmed Solutions Ltd
 * Project: iClinic
 *  Bravo Gidi <bkiptoo@collabmed.com>
 */
$patient = $data['patient'];
$history = patient_visits($patient->id);
?>
<style>
    table{
        font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
        border-collapse: collapse;
        width: 100%;
    }

    table th{
        border: 1px solid #ddd;
        text-align: left;
        padding: 1px;
    }

    table tr:nth-child(even){background-color: #f2f2f2}

    table tr:hover {background-color: #ddd;}

    table th{
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
    <div class="left">
        <p>
            <strong>{{config('practice.name')}}</strong><br/>
            {{config('practice.building')}},
            {{config('practice.street')?config('practice.street').',':''}}<br/>
            {{config('practice.town')}}<br>
            {{config('practice.telephone')?'Call Us:- '.config('practice.telephone'):''}}<br/>
            {{config('practice.email')?'Email:- '.config('practice.email'):''}}
        </p>
        <strong>Patient:</strong><span class="content"> {{$patient->full_name}}</span><br/>
        <strong>Date:</strong><span class="content"> {{(new Date())->format('j/m/Y H:i')}}</span><br/><br/>
    </div>
    <div class="right">
        <img src="{{realpath(base_path('/public/logo.png'))}}"/>
    </div>
    <div class="clear"></div>
    <div class="content">
        <div id="content">
            <div class="box-body">
                <table>
                    @foreach($history as $_visit)
                    <tr>
                        <th>
                            Visit
                        </th>
                        <th>
                            Doctor's Notes
                        </th>
                        <th>
                            Prescriptions
                        </th>
                        <th>
                            Vitals
                        </th>
                        <th>
                            Treatment
                        </th>
                        <th>
                            Diagnosis
                        </th>
                        <th>
                            Lab
                        </th>
                    </tr>
                    <tr>
                        <td>
                            {{(new Date($_visit->created_at))->format('dS M y')}} {{$_visit->clinics->name}}
                        </td>
                        <td>
                            @if(!empty($_visit->notes))
                            <p>
                                <strong>Presenting Complaints</strong>:<br>
                                {{$_visit->notes->presenting_complaints}}<br>
                            </p>

                            <p>
                                <strong>Past Medical History</strong>:<br>
                                {{$_visit->notes->past_medical_history}}<br>
                            </p>

                            <p>
                                <strong>Examination</strong>:<br>
                                {{$_visit->notes->examination}}<br>
                            </p>

                            <p>
                                <strong>Diagnosis</strong><br>
                                {{$_visit->notes->diagnosis}}
                                <br>
                            </p>

                            <p>
                                <strong>Treatment Plan</strong><br>
                                {{$_visit->notes->treatment_plan}}
                            </p>
                            @else
                            <p class="text-warning"><i class="fa fa-info-circle"></i> Notes not available
                            </p>
                            @endif

                        </td>
                        <td>
                            @if(!empty($_visit->prescriptions) && !$_visit->prescriptions->isEmpty())
                            @foreach($_visit->prescriptions as $item)
                            <p>
                                Drug: {{$item->drug}}<br>
                                Dose:{{$item->dose}}<br>
                                Duration:{{$item->duration}}
                            </p>
                            @endforeach
                            @else
                            <p class="text-warning"><i class="fa fa-info-circle"></i> No treatment records
                                available</p>
                            @endif
                        </td>
                        <td>
                            @if(!empty($_visit->vitals))
                            <p>
                                Weight:{{$_visit->vitals->weight }}<br>
                                Height:{{$_visit->vitals->height}}
                            </p>
                            @endif
                        </td>
                        <td>
                            @foreach($_visit->investigations->where('type','treatment') as $item)
                            <p>{{str_limit($item->procedures->name,20,'...')}}
                            </p>
                            @endforeach
                        </td>
                        <td>
                            @foreach($_visit->investigations->where('type','diagnosis') as $item)
                            <p>
                                Procedure:{{str_limit($item->procedures->name,20,'...')}}
                                Price: {{$item->price}}
                                Status: {!! payment_label($item->is_paid) !!}
                            </p>
                            @endforeach
                        </td>
                        <td>
                            @foreach($_visit->investigations->where('type','laboratory') as $item)
                            <p>
                                {{str_limit($item->procedures->name,20,'...')}}
                                {{$item->price}}
                                {!! payment_label($item->is_paid) !!}
                            </p>
                            @endforeach
                        </td>
                    </tr>
                    @endforeach
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