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
$from_evaluation = 0;
$n = 0;
$previous_patient = null;
$previous_patient_id = null;
if (strpos($referer, '/evaluation/patients/visit/') && strpos($referer, '/evaluate/')) {
    $from_evaluation = 1;
    $url = $referer;
    preg_match('~visit/(.*?)/evaluate~', $url, $visit_id);
    $previous_visit = \Ignite\Evaluation\Entities\Visit::find($visit_id[1]);
    $previous_patient = $previous_visit->patients->full_name;
    $previous_visit_id = $previous_visit->id;
}
?>
@extends('layouts.app')
@section('content_title',"Patients Awaiting $department")
@section('content_description',"$department Queue")

@section('content')
    <div style="margin-bottom: 20px;">
        <a href="{{ route('evaluation.authenticate.store') }}" class="btn btn-primary">Change Store</a>
    </div>

    <div class="box box-info">
        <div class="box-body">

            @include('evaluation::partials.queues.search')

            <table class="table table-striped">
                <tbody>
                @if(isset($all))
                    @foreach($all as $visit)
                        <tr id="row_id{{$visit->id}}">
                            <td>{{$loop->iteration}}</td>
                            <td>{{$visit->patients?$visit->patients->full_name:'-'}}</td>
                            <td>{{$visit->created_at->format('dS class="table table-striped"M g:i a')}}</td>
                            <td>{{$visit->visit_destination}}</td>
                            <td>{{$visit->place}}</td>
                            <td>
                                <a href="{{route('evaluation.preview',[$visit->id,$section])}}"
                                   class="btn btn-xs btn-primary">
                                    <i class="fa fa-ellipsis-h"></i> Manage</a>
                                <button value='{{$visit->id}}' class="btn btn-warning btn-xs checkout">
                                    <i class="fa fa-sign-out"></i> Checkout
                                </button>
                            </td>
                        </tr>
                    @endforeach

                @else
                    @foreach($found as $item)
                        @php
                            $visit=$item->visits;
                        if(empty($visit)){
                        continue;}
                        @endphp

                        <tr id="row_id{{$visit->id}}">
                            <td>{{$visit->id}}</td>
                            <td>{{$visit->patients->full_name}}</td>
                            <td>{{$visit->created_at->format('dS M g:i a')}}</td>
                            <td>{{$visit->visit_destination}}</td>
                            <td>{{$visit->place}}</td>
                            <td>
                                @if($section == 'pharmacy' && $visit->admission)
                                    <a href="{{route('evaluation.preview',[$visit->id,$section])}}"
                                       class="btn btn-xs btn-primary">
                                        <i class="fa fa-arrow-up"></i> Outpatient</a>

                                    <a href="{{route('evaluation.preview',[$visit->id, $section, 'inpatient'])}}"
                                       class="btn btn-xs btn-success">
                                        <i class="fa fa-arrow-down"></i> Inpatient</a>
                                @else
                                    <a href="{{route('evaluation.preview',[$visit->id,$section])}}"
                                       class="btn btn-xs btn-primary">
                                        <i class="fa fa-ellipsis-h"></i> Manage</a>
                                @endif

                                <button value='{{$visit->id}}' class="btn btn-warning btn-xs checkout">
                                    <i class="fa fa-sign-out"></i> Checkout
                                </button>

                            </td>
                        </tr>
                    @endforeach
                @endif
                </tbody>
                <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Date / Time</th>
                    <th>Destination</th>
                    <th>Doctor/Room</th>
                    <th>Actions</th>
                </tr>
                </thead>
            </table>
        </div>
    </div>
    <div class="modal fade" id="myModal" role="dialog">
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
                        <button class="btn btn-warning" id="checkout">Yes</button>
                        <button class="btn btn-default" data-dismiss="modal">No, sorry</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal2" role="dialog">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Checkout Previous Patient?</h4>
                    </div>
                    <div class="modal-body">
                        <p>Do you want to checkout <br><strong>{{$previous_patient}}</strong>? </p>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-danger" id="checkout_previous">Yes</button>
                        <button class="btn btn-primary" data-dismiss="modal">No</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        var SIGN_OUT = "{{route('api.evaluation.checkout_patient')}}";
        var FROM = "<?= $section; ?>";
    </script>

    @if($from_evaluation==1 && $pop)
        <script>
            $(document).ready(function () {
                $('#modal2').modal('show');
                var patient_id = "<?php echo $previous_visit_id; ?>";
                $('#checkout_previous').click(function () {
                    $.ajax({
                        type: 'GET',
                        url: SIGN_OUT,
                        data: {'id': patient_id, 'from': FROM},
                        success: function () {
                            alertify.success('Previous patient has been checked out');
                        },
                        error: function (data) {
                            //alertify.error('Aw. Could not checkout previous patient');
                            alertify.success('Previous patient has been checked out');
                        }
                    });
                    $("#modal2").modal('hide');
                    window.location = "<?php echo $send_to ?>";
                });
            });
        </script>
    @endif
    <script src="{{m_asset('evaluation:js/queues.js')}}" type="text/javascript"></script>
@endsection

