<div class="box box-info">

    <div class="panel panel-info">
        <div class="panel-heading">
            <i class="fa fa-user"></i> {{ $visit->patients->full_name }} | 
            {{ $visit->patients->dob->age }} yr old, {{ $visit->patients->sex }}
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="col-md-9">
                    <p><code>Payment Mode: {{ $visit->mode }}</code></p> 
                </div>
                <div class="btn-group col-md-3 pull-right">
                    <button type="button" class="btn btn-primary btn-sm">Checkout</button>

                    @if(is_module_enabled('Inpatient'))
                        @if(count($visit->admission_request_id) != 0)
                            @if($visit->admission)
                                <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#discharge-patient">
                                    Request Discharge
                                </button>
                            @else
                                <button type="button" class="btn btn-info btn-sm">
                                    Awaiting Admission
                                </button>
                            @endif    
                        @else
                            @if($visit->admission_request_id == 0)
                                <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#admit-patient">
                                    Request Admission
                                </button>
                            @endif
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>

    @if(is_module_enabled('Inpatient'))
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
    @endif

    @if(is_module_enabled('Inpatient'))
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
    @endif
</div>

<link href="{{m_asset('evaluation/css/vertical-tabs.css')}}" rel="stylesheet"/>

{{-- @push('scripts') --}}
<script type="text/javascript">
    $('#submitAdmission').click(function(){

        $('#admissionRequestForm').submit();

    });
</script>
{{-- @endpush --}}