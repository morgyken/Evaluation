<?php
/*
 * Collabmed Solutions Ltd
 * Project: iClinic
 *  Author: Samuel Okoth <sodhiambo@collabmed.com>
 */
$checkout = '';
try {
    $patient = $visit->patients;
    if (!empty($section)) {
        $checkout = route('evaluation.sign_out', [$visit->id, $section]);
    }
} catch (\Exception $e) {

}
?>
<div class="box box-info">
    <div class="box-body">
        <div class="col-md-5">
            <dt>Name:</dt>
            <dd>{{$patient->full_name}}
                <strong><u>{{$patient->sex?$patient->sex:''}}</u></strong>
            </dd>
            <dt>Gender:</dt>
            <dd>{{$patient->sex}}</dd>
            <dt>Age:</dt>
            <?php try { ?>
                <dd>{{(new Date($patient->dob))->diff(Carbon\Carbon::now())->format('%y years, %m months and %d days')}} Old</dd>
                <?php
            } catch (\Exception $e) {

            }
            ?>
        </div>
        <div class="col-md-3">
            <dt>Payment Mode:</dt>
            <dd>{{$visit->mode}}</dd>
            <dt>
                 @if(!$visit->sign_out)
            <a class="btn btn-primary" href="{{$checkout}}">
                <i class="fa fa-sign-out"></i> Check out</a>
            @else
            <p>Patient signed out for this visit</p>
            @endif<br><br>
            </dt>
        </div>
        <div class="col-md-4">
            @if($status == 'admited')
                @if(\Ignite\Evaluation\Entities\Admission::where('patient_id',$patient->id)->count())
                <button type="button" class="btn btn-warning"><i class="fa fa-share"></i> Awaiting Admission</button>
                @else
                <a class="btn btn-warning btn-xs" href="{{url('evaluation/inpatient/request_discharge/'.$visit->id)}}">Request Discharge</a> 
                @endif
            @elseif($status == 'request admission')
            <a class="btn btn-danger btn-xs" href="{{url('evaluation/inpatient/cancel_request/'.$visit->id)}}">Cancel admission Request</a>
            @else
            <dt>Request Admission:</dt>
            {!! Form::open(['url'=>['/inpatient/requestAdmission'], 'method' => 'POST'])!!}
                
            <input type="hidden" name="patient_id" value="{{$patient->id}}" required>
            <input type="hidden" name="visit_id" class="form-control" value="{{$visit->id}}" required>
            {{-- <label>Reason for Admission</label><br> --}}
            <textarea name="reason" rows="5" cols="50" placeholder="Reason for Admission" required></textarea><br>
                <button class="btn btn-primary " type="submit">Request admission</button>
            {!! Form::close() !!}
            @endif
        </div>
        <div class="col-md-4">
        </div>
    </div>
</div>