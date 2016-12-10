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
extract($data);
$section = strtolower($department);
?>
@extends('layouts.app')
@section('content_title',"Patients Awaiting $department")
@section('content_description',"$department Queue")

@section('content')
<div class="box box-info">
    <div class="box-body">
        <table class="table table-striped">
            <tbody>
                @foreach($all as $visit)
                <tr id="row_id{{$visit->id}}">
                    <td>{{$visit->patients->full_name}}</td>
                    <td>{{(new Date($visit->created_at))->format('dS M g:i a')}}</td>
                    <td>{{$visit->visit_destination}}</td>
                    <td>
                        <a href="{{route('evaluation.preview',[$visit->id,$section])}}" class="btn btn-xs btn-primary">
                            <i class="fa fa-ellipsis-h"></i> Manage</a>

                        <button value='{{$visit->id}}' class="btn btn-warning btn-xs checkout">
                            <i class="fa fa-sign-out"></i> Checkout</button>
                    </td>
                </tr>
                @endforeach
            </tbody>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Date / Time</th>
                    <th>Destination</th>
                    <th>Actions</th>
                </tr>
            </thead>
        </table>
    </div>
</div>
<div class="modal fade"  id="myModal" role="dialog">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Checkout patient</h4>
                </div>
                <div class="modal-body">
                    <p>Do you want to check out this patient?</p>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-warning" id="checkout" >Yes</button>
                    <button class="btn btn-default" data-dismiss="modal">No, sorry</button>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    var SIGN_OUT = "{{route('api.evaluation.checkout_patient')}}";
    var FROM = "<?php echo $section; ?>";
</script>
<script src="{{m_asset('evaluation:js/queues.min.js')}}" type="text/javascript"></script>
@endsection