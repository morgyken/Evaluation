<?php
$procedures = get_procedures_for('radiology');
$type = 'radiology';
?>
@if($procedures->isEmpty())
<div class="alert alert-info">
    <i class="fa fa-info-circle"></i> There are no procedures.
</div>
@else
@include('evaluation::partials.external.t')
@endif