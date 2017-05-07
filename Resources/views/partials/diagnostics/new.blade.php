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
$discount_allowed = json_decode(m_setting('evaluation.discount'));
$type = 'diagnostics';
?>
{!! Form::open(['route'=>['evaluation.order','diagnosis']])!!}
{!! Form::hidden('visit',$visit->id) !!}

@include('evaluation::partials.common.investigations.new')

{!! Form::close()!!}
<?php
$url = route('api.evaluation.get_procedures', ['diagnostics', $visit->id]);
?>
<script>
    var PROCEDURE_URL = "{{$url}}";
</script>
<script src="{{m_asset('evaluation:js/order_investigation.js')}}"></script>