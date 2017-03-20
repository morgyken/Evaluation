<?php
$results = $data['visit']->investigations->where('type', 'laboratory')->where('has_result', true);
?>
@include('evaluation::prints.partials.head')
<strong>Patient:</strong>{{$data['visit']->patients->full_name}}<br>
<strong>Age:{{$data['visit']->patients->age}}</strong><br>
<strong>Sex:</strong> {{$data['visit']->patients->sex}}<br>
@foreach($results as $item)
<table class="table table-stripped">
    <tr>
        <th colspan="2">
            <strong>Test#{{$loop->iteration}}:</strong>
            {{$item->procedures->name}}<br>
            <strong>Charges#{{$loop->iteration}}:</strong>
            {{$item->pesa}}
        </th>
        <th colspan="3">
            <strong>Doctor:</strong>
            {{$item->doctors->profile->full_name}}<br>
            <strong>Lab Tech:</strong>
            {{$item->results->users->profile->full_name}}<br>
            <strong>Date:</strong>
            {{smart_date_time($item->results->create_at)}}
        </th>
    </tr>
    <tr>
        <td>Instructions:</td>
        <td colspan="4">
            <p>{{$item->instructions ?? 'Not provided'}}</p>
        </td>
    </tr>
    <tr>
        <th>Test</th>
        <th>Results</th>
        <th>Units</th>
        <th>Flag</th>
        <th>Ref Range</th>
    </tr>    <?php
    $results = json_decode($item->results->results);
    ?>
    @foreach ($results as $r)
    <?php
    $p = Ignite\Evaluation\Entities\Procedures::find($r[0]);
    ?>
    <tr>
        <td>{{$p->name}}</td>
        <td>{{$r[1]}}</td>
        <td></td>
        <td>
            @if(isset($p->this_test->lab_min_range))
            @if($r[1]<$p->this_test->lab_min_range)
            <span style="background-color:yellow;">Low</span>
            @elseif($r[1]>$p->this_test->lab_max_range)
            <span style="color: red;">High</span>
            @else
            <span style="color: green;">Normal</span>
            @endif
            @endif
        </td>
        <td>{{$p->this_test->lab_min_range}} - {{$p->this_test->lab_max_range}}</td>
    </tr>
    @endforeach
</table>
<hr>
@endforeach

@include('evaluation::prints.partials.footer')