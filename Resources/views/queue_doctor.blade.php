<?php
/*
 * Collabmed Solutions Ltd
 * Project: iClinic
 * Author: Samuel Okoth <sodhiambo@collabmed.com>
 */
$count = 0;
?>
@extends('layouts.app')
@section('content_title','Patients Awaiting Doctor')
@section('content_description','Doctor Queue')

@section('content')
<div class="box box-info">
    <div class="box-body">
        <table class="table table-striped">
            <tbody>
                @foreach($data['all'] as $visit)
                <tr id="row_id{{$visit->visit_id}}">
                    <td>{{$visit->patients->full_name}}</td>
                    <td>{{(new Date($visit->created_at))->format('dS M g:i a')}}</td>
                    <td>{{$visit->visit_destination}}</td>
                    <td>
                        <a href="{{route('evaluation.evaluate',$visit->visit_id)}}" class="btn btn-xs btn-primary">
                            <i class="fa fa-ellipsis-h"></i> Evaluate</a>

                        <button value='{{$visit->visit_id}}' class="btn btn-warning btn-xs checkout">
                            <i class="fa fa-sign-out"></i> Checkout</button>
                    </td>
                </tr>
                @endforeach
            </tbody>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Date / Time</th>
                    <th>Doctor</th>
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
    $(document).ready(function () {
        var to_checkout = null;
        var SIGN_OUT = "{{route('evaluation.ajax.checkout_patient')}}";
        var FROM = 'evaluation';
        $('.checkout').click(function () {
            to_checkout = $(this).val();
            $('#myModal').modal('show');
        });
        $('#checkout').click(function () {
            if (!to_checkout) {
                return;
            }
            id = to_checkout;
            $.ajax({
                type: 'GET',
                url: SIGN_OUT,
                data: {'id': id, 'from': FROM},
                success: function () {
                    $("#row_id" + id).remove();
                },
                error: function (data) {
                    // console.log(data);
                }
            });
            $("#myModal").modal('hide');
        });
        try {
            $('table').DataTable();
        } catch (e) {
            //console.error(e);
        }
    });
</script>
@endsection