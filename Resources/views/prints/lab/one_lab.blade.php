<?php
$item = $data['results']; //->investigations->where('type', 'laboratory')->where('has_result', true); ?>
@include('evaluation::prints.partials.head')
<strong>TEST RESULTS</strong><br/>
<h5>Ref: 00{{$data['visit']->id}}/{{$item->results->id}}</h5>
<table>
    <tr>
        <td>Date: {{smart_date_time($item->results->create_at)}}<br></td>
    </tr>
</table>
<table class="table table-stripped">
    @include('evaluation::partials.labs.results.list')
    <tr style="font-weight: bold">
        <td>Key:</td>
        <td>L:Low</td>
        <td>N:Normal</td>
        <td colspan="2">H:High</td>
        <td></td>
    </tr>
</table>
@include('evaluation::prints.partials.footer')