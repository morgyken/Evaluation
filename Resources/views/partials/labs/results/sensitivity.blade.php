<?php
/**
 * Created by PhpStorm.
 * User: bravoh
 * Date: 9/7/17
 * Time: 7:53 PM
 */

?>
@if(count($item->results->sensitivity_results)>0)
<table class="table sensitivity_table table-condensed">
    <tr>
        <th>Antibiotic</th>
        <th>Interpretation</th>
    </tr>
    @foreach($item->results->sensitivity_results as $stvt)
        <tr>
            <td>{{$stvt->drug->name}}</td>
            <td>{{$stvt->sensitivity}}</td>
        </tr>
    @endforeach
</table>
@else
    <p>No sensitivity/culture results to show</p>
@endif
