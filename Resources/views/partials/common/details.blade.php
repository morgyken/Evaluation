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
                        @if($visit->admission_request_id != 0)
                            @if($visit->admission)
                                <a href="{{ url('/inpatient/evaluations/'.$visit->id.'/discharge') }}" type="button" class="btn btn-success btn-sm">
                                    Request Discharge
                                </a>
                            @else
                                <button type="button" class="btn btn-info btn-sm">
                                    Awaiting Admission
                                </button>
                            @endif    
                        @else
                            <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#admit-patient">
                                Request Admission
                            </button>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Inpatient Request Modals -->
    @include('evaluation::includes.admission_request')
    <!-- End Inpatient Request Modals -->
</div>

<link href="{{m_asset('evaluation/css/vertical-tabs.css')}}" rel="stylesheet"/>