<?php
/*
 * =============================================================================
 *
 * Collabmed Solutions Ltd
 * Project: Collabmed Health Platform
 * Author: Samuel Okoth <sodhiambo@collabmed.com>
 *
 * =============================================================================
 */
?>
<div class="row" id="stripper">
    @foreach($results as $item)
    <table class="table table-stripped">
        <tr>
            <th>
                <strong>Test#{{$loop->iteration}}:</strong>
                {{$item->procedures->name}}<br>
                <strong>Charges#{{$loop->iteration}}:</strong>
                {{$item->pesa}}
            </th>
            <th colspan="4">
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
        <tr>
            <td colspan="5">
                <strong>Documents:</strong>
                @if($item->results->documents)
                Uploaded File -
                <a href="{{route('reception.view_document',$item->results->documents->id)}}" target="_blank">
                    <i class="fa fa-file"></i> {{$item->results->documents->filename}}</a>
                @else
                <p class="text-warning"><i class="fa fa-warning"></i> No file uploaded</p>
                @endif
            </td>
        </tr>
        <tr>
            <th>ACTION</th>
            <th>
                <a target="blank" href="{{route('evaluation.print.print_lab.one', $item->id)}}">
                    <span class="badge alert-success">Print</span></a>
            </th>
            <th colspan="3">
                @if($item->results->status==0)
                <a class="btn btn-info btn-xs" href="{{route('evaluation.lab.approve_result', $item->results->id)}}">
                    Verify<i class="fa fa-send"></i>
                </a>
                @else
                <span class="btn btn-success btn-xs">
                    <i class="fa fa-check"></i>Verified
                </span>
                @endif
            </th>
        </tr>
    </table>
    <hr>
    <hr>
    @endforeach
</div>
<style>
    table{
        font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
        border-collapse: collapse;
        width: 100%;
    }
    table th{
        border: 1px solid #ddd;
        text-align: left;
        padding: 1px;
    }

    table tr:nth-child(even){background-color: #f2f2f2}

    table tr:hover {background-color: #ddd;}

    table th{
        padding-top: 1px;
        padding-bottom: 1px;
        background-color: /*#4CAF50*/ #BBBBBB;
        color: white;
    }
    .left{
        width: 60%;
        float: left;
    }
    .right{
        float: left;
        width: 40%;
    }
    .clear{
        clear: both;
    }
    img{
        width:50%;
        height: 50%/*auto*/;
        float: right;
    }
    td{
        font-size: 70%;
    }
    div #footer{
        font-size: 70%;
    }
    th{
        font-size: 80%;
    }
</style>