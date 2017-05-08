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
    <tr>
        <th>Test</th>
        <th>Results</th>
        <th>Units</th>
        <th style="text-align:center">Flag</th>
        <th>Ref Range</th>
    </tr>
    @include('evaluation::partials.labs.result_list')
    <tr>
        <td><strong>Comments:</strong></td>
        <td colspan="4">
            {{$item->results->comments ?? 'Not provided'}}
        </td>
    </tr>
</table>
@include('evaluation::prints.partials.footer')