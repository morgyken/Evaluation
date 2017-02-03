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
        <strong>Name:</strong><span class="content"> {{$patient->full_name}}</span><br/>
        <strong>Date:</strong><span class="content"> {{(new Date())->format('j/m/Y H:i')}}</span><br/>
    </div>
    <div class="right">
        <img src="{{realpath(base_path('/public/logo.png'))}}"/>
    </div>
    <div class="clear"></div>
    <div class="content">
        <div id="content">
            <div class="box-body">
                @foreach($history as $_visit)
                <h3 style="background-color:#eee">{{(new Date($_visit->created_at))->format('dS M y')}} <span
                        class="pull-right">{{$_visit->clinics->name}}</span></h3>
                <div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="box box-default">
                                <div class="box-header">
                                    <h3 class="box-title">Doctor's Notes</h3>
                                </div>
                                @if(!empty($_visit->notes))
                                <table class="table table-borderless">
                                    <tbody>
                                        <tr>
                                            <td><strong>Presenting Complaints</strong></td>
                                            <td> {{$_visit->notes->presenting_complaints}}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Past Medical History</strong></td>
                                            <td>{{$_visit->notes->past_medical_history}}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Examination</strong></td>
                                            <td>{{$_visit->notes->examination}}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Diagnosis</strong></td>
                                            <td>{{implode(', ',unserialize($_visit->notes->diagnosis))}}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Treatment Plan</strong></td>
                                            <td>{{$_visit->notes->treatment_plan}}</td>
                                        </tr>
                                    </tbody>
                                </table>
                                @else
                                <p class="text-warning"><i class="fa fa-info-circle"></i> Notes not available
                                </p>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="box box-default">
                                <div class="box-header">
                                    <h3 class="box-title">Treatment</h3>
                                </div>
                                <div class="box-body">
                                    @if(!empty($_visit->treatments) && !$_visit->treatments->isEmpty())
                                    <table class="table table-condensed">
                                        <thead>
                                            <tr>
                                                <th>Procedure</th>
                                                <th>Cost</th>
                                                <th>No.</th>
                                                <th>Payment</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($_visit->treatments as $item)
                                            <tr>
                                                <td>{{empty($item->procedures)?'-':str_limit($item->procedures->name,20,'...')}}</td>
                                                <td>{{$item->price}}</td>
                                                <td>{{$item->no_performed}}</td>
                                                <td>{{$item->is_paid?'Paid':'Not Paid'}}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    @else
                                    <p class="text-warning"><i class="fa fa-info-circle"></i> No treatment records
                                        available</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="box box-default">
                                <div class="box-header">
                                    <h3 class="box-title">OP Notes</h3>
                                </div>
                                <div class="box-body">
                                    @if(!empty($_visit->opnotes))
                                    <table class="table table-condensed">
                                        <tbody>
                                            <tr>
                                                <td><strong>Surgery Indications</strong></td>
                                                <td> {{$_visit->opnotes->surgery_indication}}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Implants</strong></td>
                                                <td>{{$_visit->opnotes->implants}}</td>
                                            </tr>
                                            <tr>
                                                <td>Post OP</td>
                                                <td>{{$_visit->opnotes->postop}}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Indication + procedure</strong></td>
                                                <td>{{$_visit->opnotes->indication}}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    @else
                                    <p><i class="fa fa-info-circle"></i> No records</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
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