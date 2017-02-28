<?php
/*
 * Collabmed Solutions Ltd
 * Project: iClinic
 *  Bravo Gidi <bkiptoo@collabmed.com>
 */
$patient = $data['patient'];
$history = patient_visits($patient->id);
?>
@include('evaluation::prints.partials.head')

<strong>Patient:</strong><span class="content"> {{$patient->full_name}}</span><br/>
<strong>Date:</strong><span class="content"> {{(new Date())->format('j/m/Y H:i')}}</span><br/><br/>
<table>
    @foreach($history as $_visit)
    <tr>
        <th>
            Visit
        </th>
        <th>
            Doctor's Notes
        </th>
        <th>
            Prescriptions
        </th>
        <th>
            Vitals
        </th>
        <th>
            Treatment
        </th>
        <th>
            Diagnosis
        </th>
        <th>
            Lab
        </th>
    </tr>
    <tr>
        <td>
            {{(new Date($_visit->created_at))->format('dS M y')}} {{$_visit->clinics->name}}
        </td>
        <td>
            @if(!empty($_visit->notes))
            <p>
                <strong>Presenting Complaints</strong>:<br>
                {{$_visit->notes->presenting_complaints}}<br>
            </p>

            <p>
                <strong>Past Medical History</strong>:<br>
                {{$_visit->notes->past_medical_history}}<br>
            </p>

            <p>
                <strong>Examination</strong>:<br>
                {{$_visit->notes->examination}}<br>
            </p>

            <p>
                <strong>Diagnosis</strong><br>
                {{$_visit->notes->diagnosis}}
                <br>
            </p>

            <p>
                <strong>Treatment Plan</strong><br>
                {{$_visit->notes->treatment_plan}}
            </p>
            @else
            <p class="text-warning"><i class="fa fa-info-circle"></i> Notes not available
            </p>
            @endif

        </td>
        <td>
            @if(!empty($_visit->prescriptions) && !$_visit->prescriptions->isEmpty())
            @foreach($_visit->prescriptions as $item)
            <p>
                Drug: {{$item->drug}}<br>
                Dose:{{$item->dose}}<br>
                Duration:{{$item->duration}}
            </p>
            @endforeach
            @else
            <p class="text-warning"><i class="fa fa-info-circle"></i> No treatment records
                available</p>
            @endif
        </td>
        <td>
            @if(!empty($_visit->vitals))
            <p>
                Weight:{{$_visit->vitals->weight }}<br>
                Height:{{$_visit->vitals->height}}
            </p>
            @endif
        </td>
        <td>
            @foreach($_visit->investigations->where('type','treatment') as $item)
            <p>{{str_limit($item->procedures->name,20,'...')}}
            </p>
            @endforeach
        </td>
        <td>
            @foreach($_visit->investigations->where('type','diagnosis') as $item)
            <p>
                Procedure:{{str_limit($item->procedures->name,20,'...')}}
                Price: {{$item->price}}
                Status: {!! payment_label($item->is_paid) !!}
            </p>
            @endforeach
        </td>
        <td>
            @foreach($_visit->investigations->where('type','laboratory') as $item)
            <p>
                {{str_limit($item->procedures->name,20,'...')}}
                {{$item->price}}
                {!! payment_label($item->is_paid) !!}
            </p>
            @endforeach
        </td>
    </tr>
    @endforeach
</table>
@include('evaluation::prints.partials.footer')