<?php
extract($data);
$results = $visit->investigations->where('type', $type)
        ->where('has_result', true);
?>
@include('evaluation::prints.partials.head')
<h2>{{ucfirst($type)}} Results</h2>
<table>
    <tr>
        <td>
            <strong>Patient:</strong>{{$visit->patients->full_name}}<br>
            <strong>Age: </strong><br>
            <strong>Sex:</strong> {{$visit->patients->sex}}<br>
        </td>
        <td>
            <strong>Ordered By:</strong>
            {{$result->investigations->doctors?$result->investigations->doctors->profile->full_name:''}}<br>
            <strong>Conducted By:</strong>
            {{$result->investigations->results->users->profile->full_name}}<br>
            <strong>Date:</strong>
            {{smart_date_time($result->investigations->results->create_at)}}<br/>
            @if(isset($result->investigations->visits->external_doctors))
            <strong>Request From:</strong>
            {{$result->investigations->visits->external_doctors->profile->full_name}}<br>
            ({{$result->investigations->visits->external_doctors->profile->partnerInstitution->name}})
            @endif
        </td>
    </tr>
</table>
<br/>
<table class="table table-stripped">
    <tr>
        <th>PROCEDURE</th>
        <th>
            {{$result->investigations->procedures->name}}<br>
        </th>
    </tr>
</table>
<br>

{!!$result->results!!}

<table>
    <tr>
        <th>
            <strong>Comments:</strong>
        </th>
    </tr>

    <tr>
        <td>
            <p>{{$result->investigations->results->comments ?? 'Not provided'}}</p>
        </td>
    </tr>
</table>
<hr>
@include('evaluation::prints.partials.footer')