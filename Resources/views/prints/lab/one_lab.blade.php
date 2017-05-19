<?php
$patient = $data['visit']->patients;
$dob = \Carbon\Carbon::parse($patient->dob);
$age_days = $dob->diffInDays();
$age_str = (new Date($dob))->diff(Carbon\Carbon::now())->format('%y years, %m months and %d days');
$age_years = $dob->age;
$item = $data['results']; //->investigations->where('type', 'laboratory')->where('has_result', true);
?>
@include('evaluation::prints.partials.head')
<strong>TEST RESULTS</strong><br/>
<h5>Ref: 00{{$data['visit']->id}}/{{$item->results->id}}</h5>
<h5>{{$item->procedures->name}}</h5>
<strong>Date:</strong>
{{smart_date_time($item->results->create_at)}}<br>
<br/>
<table class="table table-stripped">
    <tr>
        <td>
            <strong>Patient:</strong>{{$item->visits->patients->full_name}}<br>
            <strong>Age:</strong>{{$age_str}}<br>
            <strong>Sex:</strong> {{$item->visits->patients->sex}}<br>
            <br/>
        </td>
        <td colspan="4">
            <strong>Clinic:</strong>
            {{$item->visits->clinics->name}}<br>
            <strong>Ordered By:</strong>
            {{$item->doctors->profile->full_name}}<br>
            <strong>Conducted By:</strong>
            {{$item->results->users->profile->full_name}}<br>
            @if(isset($item->visits->external_doctors))
            <strong>Request From:</strong>
            {{$item->visits->external_doctors->profile->full_name}}<br>
            ({{$item->visits->external_doctors->profile->partnerInstitution->name}})
            @endif
            <br/>
        </td>
    </tr>
    @include('evaluation::partials.labs.results.list')
    <tr style="font-weight: bold">
        <td>Key:</td>
        <td>L:Low</td>
        <td>N:Normal</td>
        <td colspan="2">H:High</td>
    </tr>
</table>
<p>
    Laboratory Technologist:
    {{$item->results->users->profile->full_name}}
</p>
<p>
    Clinical Pathologist:
</p>
@include('evaluation::prints.partials.footer')