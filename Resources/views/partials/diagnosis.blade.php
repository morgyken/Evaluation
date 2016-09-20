<?php
/*
 * Collabmed Solutions Ltd
 * Project: iClinic
 *  Author: Samuel Okoth <sodhiambo@collabmed.com>
 */
//$diagnosis=

$diagnosis = \Dervis\Modules\Setup\Entities\Procedures::whereHas('categories', function ($query) {
            $query->where('applies_to', 7);
        })->get();
?>
@if($diagnosis->isEmpty())
<div class="alert alert-info">
    <i class="fa fa-info-circle"></i> There are no procedures. Please go to setup and add some.
</div>
@else
{!! Form::open(['id'=>'diagnosis_form'])!!}
<table class="table table-condensed table-borderless table-responsive" id="procedures">
    <tbody>
        @foreach($diagnosis as $procedure)
        <tr id="row{{$procedure->id}}">
            <td>
                <input type="checkbox" name="procedure[]" value="{{$procedure->id}}" class="check"/>
            </td>
            <td>
                <span id="name{{$procedure->id}}"> {{$procedure->name}}</span>
                <br/>
                <span class="instructions">
                    <textarea placeholder="Instructions" name="instructions[]" disabled cols="50"></textarea></span>
            </td>
            <td>
                <input type="hidden" name="price[]" value="{{(int)$procedure->cash_charge}}" size="5" id="price{{$procedure->id}}" disabled />
                <input type="text" name="cost[]" value="{{(int)$procedure->cash_charge}}" id="cost{{$procedure->id}}" size="5" disabled/></td>
        </tr>
        @endforeach
    </tbody>
    <thead>
        <tr>
            <th></th>
            <th>Procedure</th>
            <th>Price</th>
            <th></th>
        </tr>
    </thead>
</table>
{!! Form::close()!!}

<script type="text/javascript">
    var VISIT_ID = "{{ $data['visit'] }}";
    var SAVE_URL = "{{route('evaluation.ajax.save_diagnosis')}}";
    $(document).ready(function () {
        $('.accordion').accordion({heightStyle: "content"});
    });
</script>
@endif