<?php
extract($data);
$results = $visit->investigations->where('type', $type)->where('has_result', true);
?>
@include('evaluation::prints.partials.head')
<h2>{{ucfirst($type)}} Results</h2>
<strong>Patient:</strong>{{$visit->patients->full_name}}<br>
<strong>Age: </strong><br>
<strong>Sex:</strong> {{$visit->patients->sex}}<br>
<hr/>
@foreach($results as $item)
<table class="table table-stripped">
    <tr>
        <th>
            <strong>PROCEDURE#{{$loop->iteration}}</strong>
        </th>
        <th>
            {{$item->procedures->name}}<br>
        </th>
    </tr>
</table>

<table>
    <tr>
        <td>
            <strong>Patient:</strong>{{$visit->patients->full_name}}<br>
            <strong>Age: </strong><br>
            <strong>Sex:</strong> {{$visit->patients->sex}}<br>
        </td>
        <td>
            <strong>Ordered By:</strong>
            {{$item->doctors?$item->doctors->profile->full_name:''}}<br>
            <strong>Conducted By:</strong>
            {{$item->results->users->profile->full_name}}<br>
            <strong>Date:</strong>
            {{smart_date_time($item->results->create_at)}}<br/>
            @if(isset($item->visits->external_doctors))
            <strong>Request From:</strong>
            {{$item->visits->external_doctors->profile->full_name}}<br>
            ({{$item->visits->external_doctors->profile->partnerInstitution->name}})
            @endif
        </td>
    </tr>
</table>
<br/>
{!!$item->results->results!!}

<table>
    <tr>
        <td colspan="5">
            <strong>Comments:</strong>
            <p>{{$item->results->comments ?? 'Not provided'}}</p>
        </td>
    </tr>
</table>
<hr>
<br/>
@endforeach
@include('evaluation::prints.partials.footer')