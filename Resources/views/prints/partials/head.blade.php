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
        width: 40%;
        float: left;
    }
    .right{
        width: 40%;
        float: right;
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
        float: right;
    }
    th{
        font-size: 80%;
    }
</style>
<?php
extract($data);
$patient = $data['visit']->patients;
$dob = \Carbon\Carbon::parse($patient->dob);
$age_days = $dob->diffInDays();
$age_str = (new Date($dob))->diff(Carbon\Carbon::now())->format('%y years, %m months and %d days');
$age_years = $dob->age;
$item = $data['results'];
?>
<div class="box box-info">
    <div class="left">
        <img width="100" style="float: left" src="{{realpath(base_path('/public/logo.jpg'))}}"/><br>
        <p>
            <strong>{{config('practice.name')}}</strong><br/>
            {{config('practice.building')}},
            {{config('practice.street')?config('practice.street').',':''}}<br/>
            {{config('practice.town')}}<br>
            {{config('practice.telephone')?'Call Us:- '.config('practice.telephone'):''}}<br/>
            {{config('practice.email')?'Email:- '.config('practice.email'):''}}
        </p>
    </div>
    <div class="right" style="text-align: left">
        <strong>Clinic:</strong>
        {{$item->visits->clinics->name}}<br>
        <strong>Conducted By:</strong>
        {{$item->results->users->profile->full_name}}<br>
        @if(isset($item->visits->external_doctors))
            <strong>Request From:</strong>
            {{$item->visits->external_doctors->profile->full_name}}<br>
            ({{$item->visits->external_doctors->profile->partnerInstitution->name}})
        @endif
        <br/>
        <strong>Patient:</strong>{{$visit->patients->full_name}}<br>
        <strong>Patient No:</strong>{{$visit->patients->id}}<br>
        <strong>Genger:</strong> {{$visit->patients->sex}}<br>
    </div>
    <div class="clear"></div>
    <div class="content">
        <div id="content">
            <div class="box-body">
