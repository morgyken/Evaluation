<?php
extract($data);
$patient = $data['visit']->patients;
$dob = \Carbon\Carbon::parse($patient->dob);
$age_days = $dob->diffInDays();
$age_years = $dob->age;
$age_str = get_age_string($dob);
if (!isset($data['type'])) {
    $item = $data['results'];
}
$clinic = $visit->clinics;
?>
<div id="header">
    <table>
        <tr>
            <td><img width="150" src="{{realpath(base_path('/public/logo.jpg'))}}"/></td>
            <td>
                <div style="text-align: center; color:black">
                    @if(!isset($data['type']))
                    <strong>
                        <h2 style="font-weight: bolder;">
                            Lab Report
                        </h2>
                    </strong>
                    @else
                    <strong>
                        <h1 style="font-weight: bolder;">
                            {{ucfirst($data['type'])}} Report</h1>
                    </strong>
                    @endif
                </div>
            </td>
            <td style="color:black; text-align: right;">
                <small>
                    {{ ucfirst($visit->clinics->name)}}
                    <br>
                    {{$clinic->telephone?'Tel:- '.$clinic->telephone:','}}
                    {{$clinic->mobile?', '.$clinic->mobile:''}}<br/>
                    {{$clinic->email?'Email:- '.$clinic->email:''}}
                </small>
            </td>
        </tr>
    </table>
    <div id="header_2">
        <table style="font-size: 14px">
            <tr class="information">
                <td>
                    <strong style="float: top">Patient Details</strong><br>
                    Name: {{$visit->patients->full_name}}.<br>
                    Patient No: {{$visit->patients->id}}<br>
                    Age: {{$age_str}}<br>
                    Gender: {{$visit->patients->sex}}<br>
                </td>
                <td style="padding-left: 10%;">
                    <strong style="float: top">Sample Details</strong><br>
                    Visit Number: 00{{$visit->id}}<br>
                    Registered: {{smart_date($visit->created_at)}}<br>
                    Collected: {{smart_date_time($visit->updated_at)}}<br>
                    Received: {{smart_date_time($visit->created_at)}}<br>
                </td>
                <td style="text-align: right">
                    <strong style="float: top">Client Details</strong><br>
                    <?php if (!empty($item->visits->external_doctors)) { ?>
                    {{$item->visits->external_doctors?$item->visits->external_doctors->profile->full_name:''}}<br>
                    {{$item->visits->external_doctors?"(".$item->visits->external_doctors->profile->partnerInstitution->name.")":''}}
                    <br/>
                    <?php } else {
                    ?>
                    Name: {{$visit->patients->full_name}}<br>
                    Tel: {{$visit->patients->mobile}}<br>
                    Email: {{$visit->patients->email}}<br>
                    <?php
                    }
                    ?>
                </td>
            </tr>
        </table>
    </div>

</div>
