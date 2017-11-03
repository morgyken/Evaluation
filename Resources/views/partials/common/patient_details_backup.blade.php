<?php
/*
 * Collabmed Solutions Ltd
 * Project: iClinic
 *  Author: Samuel Okoth <sodhiambo@collabmed.com>
 */
$checkout = '';
try {
    $patient = $visit->patients;

    dd($patient);
    
    if (!empty($section)) {
        $checkout = route('evaluation.sign_out', [$visit->id, $section]);
    }
} catch (\Exception $e) {

}
if (empty($status)) {
    $status = null;
}
?>
 
<div class="box box-info">
    <div class="panel panel-default">
        <div class="panel-heading" role="tab" id="headingZero">
            <h4 class="panel-title">
                <div class="col-md-12">
                    <p class="col-md-9">{{$patient->full_name}}</b> {{ $patient->dob->age }} yr old, {{$patient->sex}}</p>
                    

                        <!-- <code>Payment Mode: {{$visit->mode}}</code> -->
                    <div class="btn-group col-md-3 pull-right">
                        <button type="button" class="btn btn-danger btn-sm">Checkout</button>
                        <button type="button" class="btn btn-success btn-sm">Request Admission</button>
                    </div>
                </div>
            </h4>
        </div>
        <div id="collapseZero" class="panel-collapse collapse " role="tabpanel" aria-labelledby="headingZero">
            <div class="panel-body">
                <div class="box-body">
                    <div class="col-md-6">
                        <dt>Name:</dt>
                        <dd>{{$patient->full_name}}</dd>
                        <dt>Gender:</dt>
                        <dd>{{$patient->sex}}</dd>
                        <dt>Age:</dt>
                        <dd>{{(new Date($patient->dob))->diff(Carbon\Carbon::now())->format('%y years, %m months and %d days')}}
                            Old
                        </dd>
                        <dt>Payment Mode:</dt>
                        <dd>{{$visit->mode}}</dd>
                        <dt>
                            @if(!$visit->sign_out)
                                <a class="btn btn-primary" href="{{$checkout}}">
                                    <i class="fa fa-sign-out"></i> Check out</a>
                            @else
                                <p>Patient signed out for this visit</p>
                            @endif
                            <br><br>
                        </dt>
                    </div>
                    <div class="col-md-6">
                        {{--  @if(!$visit->sign_out)
                         <a class="btn btn-primary" href="{{$checkout}}">
                             <i class="fa fa-sign-out"></i> Check out</a>
                         @else
                         <p>Patient signed out for this visit</p>
                         @endif
             <br><br> --}}

                        @if($status == 'admited')
                            @if(\Ignite\Evaluation\Entities\Admission::where('patient_id',$patient->id)->count())
                                <button type="button" class="btn btn-warning"><i class="fa fa-share"></i> Awaiting
                                    Admission
                                </button>
                            @else
                                <a class="btn btn-warning btn-xs"
                                   href="{{url('evaluation/inpatient/request_discharge/'.$visit->id)}}">Request
                                    Discharge</a>
                            @endif
                        @elseif($status == 'request admission')
                            <a class="btn btn-danger btn-xs"
                               href="{{url('evaluation/inpatient/cancel_request/'.$visit->id)}}">Cancel
                                admission Request</a>
                        @else
                            <dt>Request Admission:</dt>
                            {!! Form::open(['url'=>['/inpatient/requestAdmission'], 'method' => 'POST'])!!}

                            <input type="hidden" name="patient_id" value="{{$patient->id}}" required>
                            <input type="hidden" name="visit_id" class="form-control" value="{{$visit->id}}" required>
                            {{-- <label>Reason for Admission</label><br> --}}
                            <textarea name="reason" rows="5" cols="50" placeholder="Reason for Admission"
                                      required></textarea><br>
                            <button class="btn btn-primary " type="submit">Request admission</button>
                            {!! Form::close() !!}
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<link href="{{m_asset('evaluation/css/vertical-tabs.css')}}" rel="stylesheet"/>
<link href="{{m_asset('evaluation/css/admission-doctor.css')}}" rel="stylesheet"/>