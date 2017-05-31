<?php
/*
 * =============================================================================
 *
 * Collabmed Solutions Ltd
 * Project: Collabmed Health Platform
 * Author: Bravo <bkiptoo@collabmed.com>
 *
 * =============================================================================
 */
?>
<div class="accordion">
    @foreach($results as $item)
    <h4>Procedure #{{$loop->iteration}}: {{$item->procedures->name}}</h4>
    <div>
        <div class="col-md-4">
            <table class="table table-striped table-condensed">
                <tr>
                    <td>Procedure</td>
                    <td>{{$item->procedures->name}}</td>
                </tr>
                <tr>
                    <td>Requested By:</td>
                    <td>{{$item->doctors?$item->doctors->profile->full_name:''}}</td>
                </tr>
                <tr>
                    <td>Instructions:</td>
                    <td>{{$item->instructions ?? 'Not provided'}}</td>
                </tr>
                <tr>
                    <td>Charges:</td>
                    <td>{{$item->pesa}}</td>
                </tr>
                <tr>
                    <td>Date:</td>
                    <td>{{smart_date_time($item->created_at)}}</td>
                </tr>
            </table>

            <hr>

            <table class="table table-striped table-condensed">
                <tr>
                    <td>Result By:</td>
                    <td>{{$item->results->users->profile->full_name}}</td>
                </tr>
                <tr>
                    <td>Result Date:</td>
                    <td>{{smart_date_time($item->results->create_at)}}</td>
                </tr>
            </table>
        </div>
        <div class="col-md-8">
            <h4>Results</h4>
            <div class="well well-sm">
                {!!$item->results->results!!}
            </div>
            @if($item->results->documents)
            Uploaded File -
            <a href="{{route('reception.view_document',$item->results->documents->id)}}" target="_blank">
                <i class="fa fa-file"></i> {{$item->results->documents->filename}}</a>
            @else
            <span class="text-warning"><i class="fa fa-warning"></i> No file uploaded</span>
            @endif
            <a class="btn btn-primary btn-xs" target="blank"
               style="color:white"
               href="{{route('evaluation.print.print_res.one',
                           ['id'=>$item->results->id,'visit'=>$data['visit']->id,'type'=>$category])}}">
                <i class="fa fa-print"></i> Print
            </a>

            <a class="btn btn-danger btn-xs" target="blank"
               title="Note this will delete these results"
               style="color:white"
               href="{{route('evaluation.res.revert', $item->results->id)}}">
                <i class="fa fa-undo"></i> Revert
            </a>
        </div>
    </div>
    @endforeach
</div>
<style>
    #striper > div:nth-of-type(odd) {
        background: #e0e0e0;
    }
</style>