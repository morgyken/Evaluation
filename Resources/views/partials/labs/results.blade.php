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
$patient = $data['visit']->patients;
$dob = \Carbon\Carbon::parse($patient->dob);
$age_days = $dob->diffInDays();
$age_years = $dob->age;
?>
<div class="row" id="stripper">
    @foreach($results as $item)
    <div class="col-md-12">
        <h4>Laboratory test #{{$loop->iteration}}: {{$item->procedures->name}}</h4>
        <div class="col-md-4">
            <table class="table table-condensed table-striped">
                <tr>
                    <td><strong>Procedure:</strong></td>
                    <td>{{$item->procedures->name}}</td>
                </tr>
                <tr>
                    <td><strong>Conducted By:</strong></td>
                    <td>{{$item->doctors->profile->full_name}}</td>
                </tr>
                <tr>
                    <td><strong>Instructions:</strong></td>
                    <td>{{$item->results->instructions ?? 'Not provided'}}</td>
                </tr>
                <tr>
                    <td><strong>Charges:</strong></td>
                    <td>{{$item->pesa}}</td>
                </tr>
                <tr>
                    <td><strong>Date:</strong></td>
                    <td>{{smart_date_time($item->created_at)}}</td>
                </tr>
                <tr>
                    <td><strong>Result Date:</strong></td>
                    <td>{{smart_date_time($item->results->create_at)}}</td>
                </tr>
                @if(isset($item->visits->external_doctors))
                <tr>
                    <td><strong>Request By:</strong></td>
                    <td>
                        {{$item->visits->external_doctors?$item->visits->external_doctors->profile->full_name:''}}
                        ({{$item->visits->external_doctors?$item->visits->external_doctors->profile->partnerInstitution->name:''}})
                    </td>
                </tr>
                @endif
            </table>
        </div>
        <div class="col-md-8">
            <h4>Test Results</h4>
            <div class="well well-sm">
                <table class="table table-condensed table-striped">
                    @include('evaluation::partials.labs.results.list')
                </table>
            </div>
            <!--Action Pane -->
            @if($item->results->status==0) <!--pending -->
            <a class="btn btn-primary btn-xs" href="{{route('evaluation.lab.verify', $item->results->id)}}">
                Verify<i class="fa fa-send"></i>
            </a>
            <a title="Note this will delete these results and revert back to test phase" class="btn btn-danger btn-xs" href="{{route('evaluation.lab.revert', $item->results->id)}}">
                Revert<i class="fa fa-trash"></i>
            </a>
            @elseif($item->results->status==1)<!--verified -->
            <a class="btn btn-success btn-xs" href="{{route('evaluation.lab.publish', $item->results->id)}}">
                Accept and Publish <i class="fa fa-send"></i>
            </a>
            @elseif($item->results->status==2)<!--accepted and published -->
            <span class="btn btn-success btn-xs">
                <i class="fa fa-check"></i>Published
            </span>
            <a class="btn btn-info btn-xs" target="blank" href="{{route('evaluation.print.print_lab.one', ['id'=>$item->id,'visit'=>$data['visit']->id])}}">
                Print<i class="fa fa-print"></i>
            </a>
            <a class="btn btn-warning btn-xs" href="{{route('evaluation.lab.send', $item->results->id)}}">
                Send <i class="fa fa-send"></i>
            </a>
            @elseif($item->results->status==3)<!--sent -->
            <span class="btn btn-success btn-xs">
                <i class="fa fa-send"></i>Sent
            </span>
            <a class="btn btn-info btn-xs" target="blank" href="{{route('evaluation.print.print_lab.one', ['id'=>$item->id,'visit'=>$data['visit']->id])}}">
                Print<i class="fa fa-print"></i>
            </a>
            @endif

            @if($item->results->documents)
            Uploaded File -
            <a href="{{route('reception.view_document',$item->results->documents->id)}}" target="_blank">
                <i class="fa fa-file"></i> {{$item->results->documents->filename}}</a>
            @else
            <p class="text-warning"><i class="fa fa-warning"></i> No file uploaded</p>
            @endif
        </div>
    </div>
    <hr/>
    @endforeach
</div>
<style>
    #striper > div:nth-of-type(odd) {
        background: #e0e0e0;
    }
</style>