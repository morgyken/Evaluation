<?php
/*
 * Collabmed Solutions Ltd
 * Project: iClinic
 *  Author: Samuel Okoth <sodhiambo@collabmed.com>
 */
?>
<div class="row">
    <div class="form-horizontal">
        <div class="col-md-12">
            {!! Form::open(['id'=>'prescription_form'])!!}
            {!! Form::hidden('visit',$visit->id) !!}
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h4 class="box-title">Prescriptions</h4>
                </div>
                <div class="box-body">
                    <div class="form-group">
                        <label class="control-label col-md-4">Drug</label>
                        <div class="col-md-8" id="editDrug">
                            @if(is_module_enabled('Inventory'))
                                <select name="drug" id="item_0" class="select2-single form-control"
                                        style="width: 100%"></select>
                            @else
                                <input id="drug" type="text" name='drug' class="form-control"/>
                            @endif
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-4">Dose</label>
                        <div class="col-md-8">
                            <div class="col-md-4">
                                <input type="text" name="take" id="Take" class="form-control"/>
                            </div>
                            <div class="col-md-4">
                                {!! Form::select('whereto',mconfig('evaluation.options.prescription_whereto'),null,['class'=>'form-control'])!!}
                            </div>
                            <div class="col-md-4">
                                {!! Form::select('method',mconfig('evaluation.options.prescription_method'),null,['class'=>'form-control'])!!}
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-4">Duration</label>
                        <div class="col-md-8">
                            <div class="col-md-6">
                                <input type="text" name="duration" placeholder="e.g 3" class='form-control'/>
                            </div>
                            <div class="col-md-6">
                                {!! Form::select('time_measure',mconfig('evaluation.options.prescription_duration'),null,['class'=>'form-control'])!!}
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-4">Units to dispense</label>
                        <div class="col-md-8">
                            {{Form::text('quantity',1,['class'=>'form-control'])}}
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-4">Notes</label>
                        <div class="col-md-8">
                            {{Form::textarea('notes',null,['class'=>'form-control','placeholder'=>'Notes...','rows'=>1])}}
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-offset-4 col-md-8"><input type="checkbox" name="allow_substitution"
                                                                       value="1"/> Substitution allowed</label>
                    </div>
                    <div class="pull-right">
                        <div class="loader" id="prescriptionLoader"></div>
                        <button type="submit" class="btn btn-xs btn-primary" id="savePrescription">
                          <i class="fa fa-save"></i> Save
                        </button>

                    </div>


                    <table id="prescribed_drugs" class="table table-borderless nowrap dt-responsive" width="100%">
                        <thead>
                        <tr>
                            <th>Drug</th>
                            <th>Units</th>
                            <th>Dose</th>
                            <th>#</th>
                        </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                    <br/>
                    <span class="pull-right">
                        <a class="btn btn-primary btn-xs"
                           href="{{route('evaluation.print.prescription',$visit->id)}}" target="_blank">
                            <i class="fa fa-print"></i> Print</a>
                    </span>


                </div>

            </div>
            {!! Form::close()!!}
            <div id="myModal" class="modal fade" role="dialog">
                {{Form::open(['route'=>'evaluation.drug.edit'])}}
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Edit Prescriptions</h4>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" name="id">
                            <div class="form-group">
                                <label class="control-label col-md-4">Dose</label>
                                <div class="col-md-8">
                                    <div class="col-md-4">
                                        <input type="text" name="take" id="Take" class="form-control"/>
                                    </div>
                                    <div class="col-md-4">
                                        {!! Form::select('whereto',mconfig('evaluation.options.prescription_whereto'),null,['class'=>'form-control'])!!}
                                    </div>
                                    <div class="col-md-4">
                                        {!! Form::select('method',mconfig('evaluation.options.prescription_method'),null,['class'=>'form-control'])!!}
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-4">Duration</label>
                                <div class="col-md-8">
                                    <div class="col-md-6">
                                        <input type="text" name="duration" placeholder="e.g 3" class='form-control'/>
                                    </div>
                                    <div class="col-md-6">
                                        {!! Form::select('time_measure',mconfig('evaluation.options.prescription_duration'),null,['class'=>'form-control'])!!}
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-4">Units to dispense</label>
                                <div class="col-md-8">
                                    {{Form::text('quantity',1,['class'=>'form-control'])}}
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-4">Notes</label>
                                <div class="col-md-8">
                                    {{Form::textarea('notes',null,['class'=>'form-control','placeholder'=>'Notes...','rows'=>1])}}
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-offset-4 col-md-8"><input type="checkbox" name="allow_substitution"
                                                                               value="1"/> Substitution allowed</label>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-primary" id="marker">Save</button>
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                    </div>

                </div>
                {{Form::close()}}
            </div>
        </div>

    </div>
</div>
<?php if (is_module_enabled('Inventory')): ?>
<script>
    var INSURANCE = false;
    var STOCK_URL = "{{route('api.inventory.getstock')}}";
    {{--var PRODUCTS_URL = "{{route('api.inventory.get.products')}}";--}}
    var PRODUCTS_URL = "{{route('api.inventory.get.store-products')}}";
    $(function () {

        $('table#prescribed_drugs').dataTable({
            'ajax': "{{route('api.evaluation.performed_prescriptions',$visit->id)}}",
            "searching": false,
            "ordering": false,
            "paging": false,
            responsive: true
        });
        $(document).on('click', '.deleteP', function () {
            $pres_id = $(this).attr('tom');
            $.post({
                'url': "{{route('api.evaluation.drug.delete')}}",
                data: {id: $pres_id, _token: "{{csrf_token()}}"},
                success: function (data) {
                    if (data.success) {
                        $('table#prescribed_drugs').dataTable().api().ajax.reload();
                        alertify.success("Deleted");
                    } else {
                        alertify.error("Something came up");
                    }
                }
            });
        });
        $(document).on('click', '.editP', function () {
            $pres_id = $(this).attr('tom');
            $.ajax({
                url: "{{route('api.evaluation.drug.info')}}",
                data: {id: $pres_id},
                dataType: 'json'
            }).done(function (data) {
                var $myModal = $('#myModal');
                $myModal.find('[name=whereto]').val(data.whereto);
                $myModal.find('[name=method]').val(data.method);
                $myModal.find('[name=take]').val(data.take);
                $myModal.find('[name=duration]').val(data.duration);
                $myModal.find('[name=time_measure]').val(data.time_measure);
                $myModal.find('[name=quantity]').val(data.payment.quantity);
                $myModal.find('[name=notes]').val(data.notes);
                $myModal.find('[name=id]').val(data.id);
                $myModal.modal({show: false});
                $myModal.modal('show');
            });
        });


    });
</script>
<script src="{!! m_asset('evaluation:js/doctor-prescriptions.js') !!}"></script>
<?php endif; ?>