<div id="discharge-patient" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Request Patient Discharge</h4>
            </div>
            <div class="modal-body">
        
                {!! Form::open(['url'=>['/inpatient/discharge-requests'], 'id'=>'dischargeRequestForm' ])!!}
                    <input type="hidden" name="visit_id" value="{{ $visit->id }}" required>
                    <div class="form-group">
                        <label for="">Choose Discharge Type</label>
                        <select class="form-control" name="admission_type_id" required>
                            @foreach($dischargeTypes as $dischargeType)
                                <option value="{{ $dischargeType->id }}">{{ $dischargeType->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="">Specify reason for discharge</label>
                        <textarea class="form-control" name="reason" rows="5" required></textarea>
                    </div>
                {!! Form::close() !!}
                
            </div>
            <div class="modal-footer">
                <button id="submitDischarge" type="button" class="btn btn-primary">Submit</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal" click>Cancel</button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function () {
        // $('case-time').datepicker();
    });
</script>