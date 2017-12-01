<div id="admit-patient" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Request Patient Admission</h4>
            </div>
            <div class="modal-body">
        
                {!! Form::open(['url'=>['/inpatient/admission-requests'], 'id'=>'admissionRequestForm' ])!!}
                    <input type="hidden" name="visit_id" value="{{ $visit->id }}" required>
                    <input type="hidden" name="patient_id" value="{{ $visit->patients->id }}" required>

                    <div class="form-group">
                        <label for="">Choose Admission Type</label>
                        <select class="form-control" name="admission_type_id" required>
                            @foreach($admissionTypes as $admissionType)
                                <option value="{{ $admissionType->id }}">{{ $admissionType->name }} - (ksh. {{ $admissionType->deposit }})</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="">Specify reason for admission</label>
                        <textarea class="form-control" name="reason" rows="5" required></textarea>
                    </div>
                {!! Form::close() !!}
                
            </div>
            <div class="modal-footer">
                <button id="submitAdmission" type="button" class="btn btn-primary">Submit</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal" click>Cancel</button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function(){
        $('#submitAdmission').click(function(){

            $('#admissionRequestForm').submit();

        });
    })
</script>