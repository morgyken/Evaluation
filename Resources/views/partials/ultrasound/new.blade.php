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
$type = 'ultrasound';
?>
{!! Form::open(['route'=>['evaluation.order','ultrasound']])!!}
{!! Form::hidden('visit',$visit->id) !!}

@include('evaluation::partials.common.investigations.new')

{!! Form::close()!!}
<?php
$url = route('api.evaluation.get_procedures', ['ultrasound', $visit->id]);
?>
<script>
    var PROCEDURE_URL = "{{$url}}";
    var ORDERING = true;
</script>
<script src="{{m_asset('evaluation:js/order_investigation.js')}}"></script>