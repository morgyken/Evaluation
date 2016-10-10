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
?>
<script type="text/javascript">
    var USER_ID = parseInt("{{ Auth::user()->id }}");
    var VISIT_ID = parseInt("{{ $visit->id }}");
    var VITALS_URL = "{{route('api.evaluation.save_vitals')}}";
    var NOTES_URL = "{{route('api.evaluation.save_notes')}}";
    var PRESCRIPTION_URL = "{{route('api.evaluation.save_prescription')}}";
    var SET_DATE_URL = "{{route('api.evaluation.set_visit_date')}}";
    var DIAGNOSIS_URL = "{{route('api.evaluation.save_diagnosis')}}";
    var OPNOTES_URL = "{{route('api.evaluation.save_opnotes')}}";
    var TREAT_URL = "{{route('api.evaluation.save_treatment')}}";
    var DRAWINGS_URL = "{{route('api.evaluation.save_drawings')}}";
    var VISIT_METAS_URL = "{{route('api.evaluation.save_visit_metas')}}";
    var PRELIMINARY_EXAMINATION = "{{route('api.evaluation.save_preliminary')}}";
    $(document).ready(function () {
        $('.accordion').accordion({heightStyle: "content"});
    });
</script>
