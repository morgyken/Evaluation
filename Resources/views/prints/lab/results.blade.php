<?php
$patient = $data['visit']->patients;
$dob = \Carbon\Carbon::parse($patient->dob);
$age_days = $dob->diffInDays();
$age_str = (new Date($dob))->diff(Carbon\Carbon::now())->format('%y years, %m months and %d days');
$age_years = $dob->age;
$results = $data['visit']->investigations->where('type', 'laboratory')->where('has_result', true);
?>
@include('evaluation::prints.partials.head')
<h2>TEST RESULTS</h2>
<h5>Ref: 00{{$data['visit']->id}}</h5>
<strong>Patient:</strong>{{$data['visit']->patients->full_name}}<br>
<strong>Age: {{$age_years}}</strong><br>
<strong>Sex:</strong> {{$data['visit']->patients->sex}}
@foreach($results as $item)
<br>
<h5>{{$loop->iteration}}. {{$item->procedures->name}}</h5>
<table class="table table-stripped">
    @include('evaluation::partials.labs.results.list')
    <tr style="font-weight: bold">
        <th>Key:</th>
        <th>L:Low</th>
        <th>N:Normal</th>
        <th colspan="2">H:High</th>
    </tr>
</table>
<strong>Ordered By:</strong>
{{$item->doctors->profile->full_name}}<br>
<strong>Conducted By:</strong>
{{$item->results->users->profile->full_name}}<br>
<strong>Charges</strong>{{$item->pesa}}<br>

<strong>Date:</strong>
{{smart_date_time($item->results->create_at)}}<br>
@if(isset($item->visits->external_doctors))
<strong>Request From:</strong>
{{$item->visits->external_doctors->profile->full_name}}<br>
({{$item->visits->external_doctors->profile->partnerInstitution->name}})
@endif
<hr>
@endforeach
@include('evaluation::prints.partials.footer')