<?php
$item = $data['results']; //->investigations->where('type', 'laboratory')->where('has_result', true);
?>
@include('evaluation::prints.partials.head')
<table border='1'>
    <tr>
        <td>
            <strong>Patient:</strong>{{$item->visits->patients->full_name}}<br>
            <strong>Age:</strong><br>
            <strong>Sex:</strong> {{$item->visits->patients->sex}}<br>
        </td>
        <td colspan="4">
            <strong>Clinic:</strong>
            {{$item->visits->clinics->name}}<br>
            <strong>Doctor:</strong>
            {{$item->doctors->profile->full_name}}<br>
            <strong>Lab Tech:</strong>
            {{$item->results->users->profile->full_name}}<br>
            <strong>Date:</strong>
            {{smart_date_time($item->results->create_at)}}
        </td>
    </tr>
    <tr>
        <th>Test</th>
        <th>Results</th>
        <th>Units</th>
        <th>Flag</th>
        <th>Ref Range</th>
    </tr>
    <?php $results = json_decode($item->results->results); ?>
    @foreach ($results as $r)
    <tr>
        <td>{{$r[0]}}</td>
        <td>{{$r[1]}}</td>
        <td></td>
        <td></td>
        <td></td>
    </tr>
    @endforeach
</table>
@include('evaluation::prints.partials.footer')