<?php
$results = $data['visit']->investigations->where('type', 'laboratory')->where('has_result', true);
?>
@include('evaluation::prints.partials.head')
<table border='1'>
    <tr>
        <th>Test</th>
        <th>Results</th>
    </tr>
    @foreach($results as $item)
    <tr>
        <td style="width: 50%">
            <h4>Procedure #{{$loop->iteration}}: {{$item->procedures->name}}</h4>
            <p>Requested By:<br> {{$item->doctors->profile->full_name}}</p>
            <p>Instructions:<br> {{$item->instructions ?? 'Not provided'}}</p>
            <p>Charges:<br> {{$item->pesa}}</p>
            <p>Date:<br> {{smart_date_time($item->created_at)}}</p>
            --------------------------

            <p>Result By:<br>{{$item->results->users->profile->full_name}}</p>
            <p>Result Date:<br/>{{smart_date_time($item->results->create_at)}}</p>
        </td>
        <td>{!!$item->results->results!!}</td>
    </tr>
    @endforeach
</table>

@include('evaluation::prints.partials.footer')